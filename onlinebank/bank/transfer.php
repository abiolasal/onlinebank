<?php 
session_start();
        
if(!isset($_SESSION['customer_login'])) 
    header('location:index.php');   
?>

<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <title>Transfer Funds - Online Banking</title>
      
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
    //	$account_id          => the account id of the sender in the transaction
    //	$account_transfer_to => the account id of the receiver in the transaction
    //	$amount			         => the amount of money being transfered
    //	$description		     => a description of the transaction. if not set, the default is set to 'not given'
    //
    // This function connects to the database and creates a transaction record in the transaction table.
    //	
    // On success, this function returns True.
    // On error, this function returns False.
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ preform_transfer ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    function transfer($account_from, $account_transfer_to, $amount, $description = 'not given'){
    
      $flags = 0;
      // NOTE: a possible user sanity check can go here.

      //*************VERIFY BOTH ACCOUNT EXIST */
      $sql_account_verification = "SELECT * FROM `accounts` WHERE `account_id` IN ($account_from, $account_transfer_to);";
      $result = mysql_query($sql_account_verification);

      //if query does not send back ONLY 2 rows print error message
      if(mysql_num_rows($result) != 2){
        echo "One of more accounts do not exists";
        return false;

      }

      $result_from;
      $result_to;

      //verify the rows queried are what returned
      while($row = mysql_fetch_assoc($result)){
        //if account is the one performing transfer
        if($row['account_id'] == $account_from){
          $result_from = $row;
        }
        else if($row['account_id'] == $account_transfer_to){
          $result_to = $row;
        }
        else{
          header('location:customer_logout.php');
        }
        
      }

      if($result_from['account_id'] == $account_from){
          //if account has sufficient funds for transfer, we will let account go to zero
          if($result_from['balance'] < $amount){
            echo "Insufficient funds for transfer";
            return false;
          }
          //create new balance information
          $newBal = $result_from['balance'] - $amount;
          //update balance in accounts table
          $sql_account_update = "UPDATE accounts SET balance='$newBal' WHERE account_id='$account_from'";
          mysql_query($sql_account_update) or die(mysql_error());

          //insert transaction into transaction table
          $trans_id = sprintf("%'010d",Date('U')) . sprintf("%'04d",$account_from) . sprintf("%'04d",$account_transfer_to) ;
          $sql_transaction = "INSERT INTO `transactions` (`trans_id`, `account_id`, `amount`, `trans_date`, `description`, `type`) VALUES ($trans_id, $account_from, -$amount, NOW(), '$description', 'transfer')";
          mysql_query($sql_transaction) or die(mysql_error());
          $flags += 1;
        }
        //if account is the one recieving funds
        if(($result_to['account_id'] == $account_transfer_to) && ($flags == 1)){
          //create new balance information
          $newBal = $result_to['balance'] + $amount;
          //update balance in accounts table
          $sql_account_update = "UPDATE accounts SET balance='$newBal' WHERE account_id='$account_transfer_to'";
          mysql_query($sql_account_update) or die(mysql_error());

          //add transaction to transaction table
          $trans_id = sprintf("%'010d",Date('U')) . sprintf("%'04d",$account_transfer_to) . sprintf("%'04d",$account_from) ;
          $sql_transaction_to = "INSERT INTO `transactions` (`trans_id`, `account_id`, `amount`, `trans_date`, `description`, `type`) VALUES ($trans_id, $account_transfer_to, $amount, NOW(), '$description', 'transfer')";
          mysql_query($sql_transaction_to) or die(mysql_error());
          $flags += 1;
        }

      if($flags == 2){
        return true;
      }
      else{
        echo "Something went wrong. Contact administrator";
        return false;
      }
    }

    // verify 
    if( isset($_POST["transaction_amount"]) && isset($_POST["transaction_reciever"]) ){

      // DEBUG: required to be signed on at this stage of the website. For that reason, i have dummy variables to represent this
      $cust_id=$_SESSION['cust_id'];
      $sql="SELECT * FROM user WHERE email='$cust_id'";
      $result=  mysql_query($sql) or die(mysql_error());
      $rws=  mysql_fetch_array($result);

      $account_from = $rws[0];
      $account_to = $_POST["transaction_reciever"];
      $trans_amount = $_POST["transaction_amount"];
      $trans_description = $_POST["transaction_description"];



      // if we recieved a negative number for the transaction amount
      if ( $_POST["transaction_amount"] <= 0 ){
        echo "Incorrect value for transaction amount given. <br>";
        return false;
      }

      // if we recieved a description too long
      if ( strlen($_POST["transaction_description"]) > 20 ){
        echo "Too long of a description given. <br>";
        return false;
      }

      // if we don't have a user account signed in
      if ( !isset($account_from) ){ 
        echo "No user Signed in. <br>";
         return false;
      }

      //perform transfer
      $results = transfer( $account_from, $account_to, $trans_amount, $trans_description);
    
      //send result to user>"
      echo "</br>";
      echo ($results) ? "SUCCESS" : "FAILED" ;
    }
  }
  else{
    echo("not connected to the database");
  }

?>
<br><br><br><br>
    <h3 style="text-align:center;color:#2E4372;"><u>Transfer Funds</u></h3>
            <form action="transfer.php" method="POST">
                <table align="center">
                    <tr>
                        <td>Transfer to:</td>
                        <td><input type="number" name="transaction_reciever" id="transaction_reciever_input" min="1" step="1"></td>
                    </tr>
                    <tr>
                        <td>Amount</td>
                        <td><input type="number" name="transaction_amount" id="transaction_amount_input" min="0" step="0.01"></td>
                    </tr>
                    <tr>
                        <td>Transfer description:</td>
                        <td><textarea id="transaction_description" name="transaction_description" maxlength="20"></textarea></td>
                    </tr>
                    </table>
                    
                       <table align="center"><tr>
                        <td><input type="submit" name="submit_transfer" value="Transfer" class="addstaff_button"/></td>
                    </tr>
                </table>
            </form>
</body>
</html>
