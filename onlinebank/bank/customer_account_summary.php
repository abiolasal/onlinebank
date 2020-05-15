<?php 
session_start();
        
if(!isset($_SESSION['customer_login'])) 
    header('location:index.php');   
?>
<?php
                $cust_id=$_SESSION['cust_id'];
                include '_inc/dbconn.php';
                $sql="SELECT * FROM user WHERE email='$cust_id'";
                $result=  mysql_query($sql) or die(mysql_error());
                $rws=  mysql_fetch_array($result);
                
                $account_no= $rws[0];
				$first_name= $rws[1];
				$last_name= $rws[2];
				//$full_name = "$first_name.$last_name"
				//"<br>Your customer ID is ".$row['customerid'];
                
                $email=$rws[3];
				$last_login= $rws[10];
                $user_status=$rws[9];		
                $street_address=$rws[5];
                $city=$rws[6];
                $state=$rws[7];
				$zipcode=$rws[8];
                $phone_number=$rws[4];

                
                $_SESSION['login_id']=$account_no;
                $_SESSION['name']=$first_name;
                ?>

<!DOCTYPE html>
<html>
    <head>
        
        <meta charset="UTF-8">
        <title>Home - Online Banking</title>
        
        <link rel="stylesheet" href="newcss.css">
    </head>
        <?php include 'header.php' ?>
        <div class='content_customer'>
            
           <?php include 'customer_navbar.php'?>
            <div class="customer_top_nav">
             <div class="text">Welcome <?php echo htmlentities($_SESSION['name'], ENT_QUOTES);//echo $_SESSION['name']?></div>
            </div>
            
            
            <?php
                
                $sql="SELECT * FROM accounts WHERE user_id = '$account_no'";
                $result=  mysql_query($sql) or die(mysql_error());
                while($rws=  mysql_fetch_array($result))
                {
                $balance=$rws[2];
				$acc_status=$rws[3];
				switch($acc_status){
					case '1': $acc_status="ACTIVE";
						break;
					case '0': $acc_status="DORMANT";
						break;
					}
                }            
?>
            <div class="customer_body">
                <div class="content1">
            <p><span class="heading">Account No: </span><?php echo htmlentities($account_no, ENT_QUOTES);//echo $account_no;?></p>
            <p><span class="heading">First Name: </span><?php echo htmlentities($first_name, ENT_QUOTES);//echo $first_name;?></p>
            <p><span class="heading">Last Name: </span><?php echo htmlentities($last_name, ENT_QUOTES);//echo $last_name;?></p>
            </div>
            
            <div class="content2">
            <p><span class="heading">Balance: $ </span><?php echo htmlentities($balance, ENT_QUOTES);//echo $balance;?></p>
            <p><span class="heading">Account status: </span><?php echo htmlentities($acc_status, ENT_QUOTES);//echo $acc_status;?></p>
            <p><span class="heading">Last Login: </span><?php echo htmlentities($last_login, ENT_QUOTES);//echo $last_login;?></p>
           </div>
            
            
        </div>
    
               <?php include 'footer.php';?>
            
    </body>
</html>