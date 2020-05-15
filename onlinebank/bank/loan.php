<?php 
session_start();
        
if(!isset($_SESSION['customer_login'])) 
    header('location:index.php');   
?>

<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <title>Loan Request - Online Banking</title>
      
      <link rel="stylesheet" href="newcss.css">
      <style>
        .content_customer table,th,td {
          padding:6px;
          border: 1px solid #2E4372;
          border-collapse: collapse;
          text-align: center;
        }
      </style>
  </head>
  <?php include 'header.php' ?>
  <div class='content_customer'>
    <?php include 'customer_navbar.php'?>
    <div class="customer_top_nav">
      <div class="text">Welcome <?php echo $_SESSION['name']?>
      </div>
    </div>
<body>
	<?php
	// this allows us to use a centeralized database in our php files. 
	if(@include '_inc/dbconn.php'){
    //@include './no_access/statements.php';
	
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ preform_transfer ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    //	$account_id          => the account id of the requester
    //	$amount			         => the amount of money being loaned
    //	$description		     => a description of the reason the loan is being taken out
    //
    // This function connects to the database and creates a transaction record in the transaction table.
    //	
    // On success, this function returns True.
    // On error, this function returns False.
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ preform_transfer ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    function approve_loan($account_id, $amount, $description = 'not given'){
    
      $flags = 0;
      // NOTE: a possible user sanity check can go here.

      //*************VERIFY ACCOUNT EXIST */
      $sql_account_verification = "SELECT account_id, balance, loans FROM accounts WHERE account_id=$account_id";
      $result = mysql_query($sql_account_verification) or die(mysql_erro());

      //if query does not send back ONLY 2 rows print error message
      if(mysql_num_rows($result) != 1){
        echo "Something went wrong, try again<br/>";
        return false;

      }
      
      //extract row information
      $row = mysql_fetch_assoc($result);
      //verify the rows queried are what returned
      if($row['account_id'] != $account_id){
        header('location:customer_logout.php');
      }

      if($row['loans'] == 9){
        echo "Maximum number of loans exceeded. Contact Administrator for additional loans.<br/ ";
        return false;
      }
      

      //create new balance information/
      $newBal = $row['balance'] + $amount;

      if($newBal > 1000000000){
        echo "This establishment can not support an account this large, you need a new bank <br/>";
        return false;
      }
      $totalLoan = $row['loans'] += 1;
      //update balance in accounts table
      $sql_account_update = "UPDATE accounts SET balance='$newBal', loans='$totalLoan' WHERE account_id='$account_id'";

      $loan_update = mysql_query($sql_account_update) or die(mysql_error());

      //if balance update successful 
      if($loan_update)
        $flags += 1;

      //insert transaction into transaction table
      $trans_id = sprintf("%'010d",Date('U')) . sprintf("%'08d",$account_id) ;
      $sql_transaction = "INSERT INTO `transactions` (`trans_id`, `account_id`, `amount`, `trans_date`, `description`, `type`) VALUES ($trans_id, $account_id, $amount, NOW(), '$description', 'loan')";
      $trans_added = mysql_query($sql_transaction) or die(mysql_error());
      
      //if transaction add successful
      if($trans_added)
        $flags += 1;

      //if both balance update and transaction add successful
      if($flags == 2){
        return true;
      }
      else{
        echo "Something went wrong. Contact administrator";
        return false;
      }
    }

    // verify 
    if(isset($_POST["loan_amount"]) && isset($_POST["loan_description"]) ){

      // DEBUG: required to be signed on at this stage of the website. For that reason, i have dummy variables to represent this
      $cust_id=$_SESSION['cust_id'];
      $sql="SELECT * FROM user WHERE email='$cust_id'";
      $result=  mysql_query($sql) or die(mysql_error());
      $rws=  mysql_fetch_array($result);

      $account_id = $rws[0];

      // if we recieved a description too long
      if ( strlen($_POST["loan_description"]) > 20 ){
        echo "Too long of a description given. <br>";
        return false;
      }
      if($_POST['loan_amount'] > 999999999.99){
        echo "This establishment can not support your transaction, you need a new bank <br/>";
        return false;
      }

      $results = approve_loan($account_id, $_POST["loan_amount"], $_POST["loan_description"]);
    
      
      echo ($results) ? "SUCCESS" : "FAILED" ;
    }
  }
  else{
    echo("not connected to the database");
  }

?>
<br><br><br><br>
    <h3 style="text-align:center;color:#2E4372;"><u>Loan Request</u></h3>
            <form action="loan.php" method="POST">
                <table align="center">
                    <tr>
                        <td>Amount</td>
                        <td><input type="number" name="loan_amount" id="loann_amount_input" min="0" step="0.01"></td>
                    </tr>
                    <tr>
                        <td>Loan description:</td>
                        <td><textarea id="loan_description" name="loan_description" maxlength="20"></textarea></td>
                    </tr>
                    </table>
                    
                       <table align="center"><tr>
                        <td><input type="submit" name="submit_loan" value="Submit Loan Request" class="addstaff_button"/></td>
                    </tr>
                </table>
            </form>
</body>
</html>
