<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel = "stylesheet" href="newcss.css">
    <style>
	#transaction_amount_label, #deposit, #transaction_type_label, #transaction_description_label{
		margin: 1rem;
		font-size: 1.5rem;
	} 

	#deposit{
		background-color: red;
		display: inline;

	}


    </style>
</head>
<body>
	<?php 
	session_start();
	        
	if(!isset($_SESSION['customer_login'])) 
	    header('location:index.php');   
	?>

   <!--Adding header for the page-->
   <?php include 'header.php'?>

        <div class = "state_customer">
        <?php include 'customer_navbar.php'?>

<form action="Withdraw.php" method="POST">
	<div style="marign: 0px auto; padding: 0.5rem 1rem;" class='content_customer'>
	<h1>Withdraw/Deposit</h1>
	<div>
	<label id="transaction_amount_label" for="transaction_amount">Amount:</label>
	<input type="number" name="transaction_amount" id="transaction_amount_input" min="0" step="0.01"><br>
	</div>
	<div>
	<p id="transaction_type_label" style="display:inline;">Type:</p>
	<input type="radio" id="deposit" name="transaction_type" value="deposit" checked>
	<label for="deposit">deposit</label>
	<input type="radio" id="withdraw" name="transaction_type" value="withdraw">
	<label for="withdraw">withdraw</label>
	</div>
	<div>
	<label id="transaction_description_label"for="transaction_description">Description:</label><br>
	<textarea id="transaction_description" name="transaction_description" maxlength="30"></textarea><br>
	</div>
	<input type="submit" value="Submit">
    <?php 
	// this allows us to use a centeralized database in our php files. 
	require './no_access/database_connection.php';
	
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ preform_transaction ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	//	$account_id              => the account id of the sender in the transaction
	//	$account_id_for_transfer => the account id of the receiver in the transaction
	//	$amount			         => the amount of money being transfered
	//	$description		     => a description of the transaction. if not set, the default is set to 'not given'
	//
	// This function connects to the database and creates a transaction record in the transaction table.
	//	
	// On success, this function returns True.
	// On error, this function returns False.
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ preform_transaction ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	function preform_transaction($account_id, $account_id_for_transfer, $amount, $type, $description = 'not given'){

		// gets the centeralized database
		$db = retrieve_database();
	
		// if the database was not able to connect, return False;
		if( !isset($db) ){ return False; }
	
		// NOTE: a possible user sanity check can go here.	

		// create unique transaction id
		$trans_id = sprintf("%'010d",Date('U')) . sprintf("%'04d",$account_id) . sprintf("%'04d",$account_id_for_transfer) ;

		// TODO: need to update query to support account_id_for_transfer. need transaction table updated before this can happen.		

		// prepares sql statement to be executed. prevents SQL injection
		$sql = "INSERT INTO `transactions` (`trans_id`, `account_id`, `amount`, `trans_date`, `type`, `description`) VALUES (:trans_id, :account_id, :amount, NOW(), :type, :description)";
		$transaction_statement = $db->prepare($sql);
		
		// DEBUG: prints the query that is being preformed. 
		//echo "INSERT INTO `transactions` (`trans_id`, `account_id`, `amount`, `trans_date`, `description`, `type`) VALUES (" . $trans_id . ", " . $account_id . ", " . $amount . ", NOW(), '"  . $type . "', '" . $description . "')";	

		// executes query with data given
		$result = $transaction_statement->execute(array(':trans_id' => $trans_id, ':account_id' => $account_id, ':amount' => $amount, ':type' => $type, ':description' => $description));
		
		if( $result ){

			// prepares sql statement to be executed. prevents SQL injection
			$sql = "UPDATE `accounts` SET `balance` = `balance` + :amount WHERE `account_id` = :account_id";
			$transaction_statement = $db->prepare($sql);
	
			// DEBUG: prints the query that is being preformed. 
			//echo "UPDATE `accounts` SET `balance` = `balance` + " . $amount . " WHERE `account_id` = " . $account_id . ";";	

			// executes query with data given
			$result = $transaction_statement->execute(array(':amount' => $amount, ':account_id' => $account_id));
		
		}

		// if the query completed successfully, return True; else returns false;
		return $result;
	}

	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ check_for_overdraft ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	//	$account_id              => the account id of the sender in the transaction
	//	$amount			 => the amount of money wanting to be transfered
	//
	// This function connects to the database and checks if the amount given would cause an overdraft on a
	// given accounts balance. 
	//
	// On success, this function will return True if there will be an overdraft. Otherwise, False.
	// On error, this function returns False.
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ check_for_overdraft ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	function check_for_overdraft( $account_id, $amount ){
	
		// if they arent taking money out of the system, return True
		if( $amount >= 0  ){ return False; }

		// gets the centeralized database
		$db = retrieve_database();
	
		// if the database was not able to connect, dont do a transaction
		if( !isset($db) ){ return True; }
	
		// NOTE: a possible user sanity check can go here.

		// prepares sql statement to be executed. prevents SQL injection
		$sql = "SELECT `balance` + :amount FROM `accounts` WHERE `account_id` = :account_id";
		$overdraft_statement = $db->prepare($sql);
		
		// DEBUG: prints the query that is being preformed. 
		//echo "SELECT (`balance` + " . $amount . ") as balance FROM `accounts` WHERE `account_id` = " . $account_id . ";";	

		// executes query with data given
		$result = $overdraft_statement->execute(array(':account_id' => $account_id, ':amount' => $amount));
		
		// if we failed to execute the query, dont do a transaction
		if ( !$result ){ return True; }
		
		// gets the row from the db
		$amount = $overdraft_statement->fetch();
		
		// returns if the query will cause an overdraft (amount < 0)
		return ($amount[0] < 0) ? True: False;
	}

	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ retrieve_transactions_by_user ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	//	$account_id              => the account id of the sender in the transaction
	//	$position_flag           => this specifies if the account can be a sender, receiver, or both
	//
	// This function connects to the database and retrieves all transaction record in the transaction table for a
	// specified user. The user can be the sender or the receiver by default. To limit the function to only grab
	// transactions on sender, set the position flag to 1. To limit the function to only grab transactions on 
	// receiver, set the position flag to 0.
	//
	// On success, this function will return an array of transactions.
	// On error, this function returns an empty array.
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ retrieve_transactions_by_user ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	function retrieve_transactions_by_user($account_id, $position_flag = 0){
		
		// the inital list of transactions to return
		$transaction_list = array();

		// gets the centeralized database
		$db = retrieve_database();
	
		// if the database was not able to connect, return empty list;
		if( !isset($db) ){ return $transaction_list; }
	
		// NOTE: a possible user sanity check can go here.	
		
		// TODO: implement position_flag. need transaction table updated before this can happen.

		// prepares sql statement to be executed. prevents SQL injection
		$sql = "SELECT trans_id, amount, date, description from transactions where account_id = :account_id;";
		$deposit_statement = $db->prepare($sql);
		
		// DEBUG: prints the query that is being preformed. 
		// echo "SELECT trans_id, amount, date, description from transactions where account_id = " . $account_id . ";";	

		// executes query with data given
		if ( $deposit_statement->execute(array(':account_id' => $account_id)) ){
			while( $row = $deposit_statement->fetch(PDO::FETCH_ASSOC) ){
				$transaction_list[] = $row;	
			}	
		}
		
		// if the query completed successfully, returns the list of transactions;
		return $transaction_list;
	}	

	// if we are sent values required.
	if( isset($_POST["transaction_amount"]) && isset($_POST["transaction_type"]) ){

		// if we recieved an invalid transaction type
		if( $_POST["transaction_type"] != "withdraw" && $_POST["transaction_type"] != "deposit" ){
			echo "Incorrect value for transaction type given. <br>";
			return;
		}	

		// if we recieved a negative number for the transaction amount
		if ( $_POST["transaction_amount"] <= 0 ){
			echo "Incorrect value for transaction amount given. <br>";
			return;
		}

		// if we recieved a description too long
		if ( strlen($_POST["transaction_description"]) > 30 ){
			echo "Too long of a description given. <br>";
			return;
		}

		// if we don't have a user account signed in
		if ( !isset($_SESSION['login_id']) ){ 
			echo "No user Signed in. <br>";
			return;
		}

		// TODO: check if the transaction type is possible.
		// TODO: check if the receiver exist.
		// TODO: implement trans_type into query. need transaction table updated before this can happen.

		$trans_type = ($_POST["transaction_type"] == "withdraw") ? "debit" : "credit";
		$trans_amount = ($_POST["transaction_type"] == "withdraw") ? -$_POST["transaction_amount"] : $_POST["transaction_amount"];
		$account_id = $_SESSION['login_id'];
		$overdraft = check_for_overdraft( $account_id, $trans_amount );

		if ( !$overdraft ){ 
			$results = preform_transaction( $account_id, $account_id, $trans_amount, $trans_type, $_POST["transaction_description"] );
			echo ($results) ? "SUCCESS" : "FAILED" ;
		}

		else{
			echo "Overdraft detected <br>";
		}
	}

?>

	</div>
</form>
<?php include 'footer.php'?>
</body>
</html>
