<?php 
session_start();
        
if(!isset($_SESSION['customer_login'])) 
    header('location:index.php');   
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Personal Details</title>
        
        <link rel="stylesheet" href="newcss.css">
    </head>
        <?php include 'header.php' ?>
        <div class='content_customer'>
            
           <?php include 'customer_navbar.php'?>
            <div class="customer_top_nav">
             <div class="text">Welcome <?php echo htmlentities($_SESSION['name'], ENT_QUOTES);//echo $_SESSION['name']?></div>
            </div>
            <br><br><br><br>
            <h3 style="text-align:center;color:#2E4372;"><u>Personal Details</u></h3>
            
            <?php
                $cust_id=$_SESSION['cust_id'];
                include '_inc/dbconn.php';
                $sql="SELECT * FROM user WHERE email='$cust_id'";
                $result=  mysql_query($sql) or die(mysql_error());
                $rws=  mysql_fetch_array($result);
                
                
                $account_no= $rws[0];
				$first_name= $rws[1];
				$last_name= $rws[2];
                $email=$rws[3];
                $phone_number=$rws[4];
                $lastlogin= $rws[10];
                //$gender=$rws[2];
                $city=$rws[6];
                $state=$rws[7];
                $street_address=$rws[5];
                $zip= $rws[8];
                $user_status=$rws[9];
               // $acc_type=$rws[4];
				$address = ucwords($street_address).', '. ucwords($city).', ' .$zip.  ', ' .ucwords($state);
                                
?>          <div class="customer_body">
            <div class="content3">
            <p><span class="heading">First Name: </span><?php echo htmlentities($first_name);//echo $first_name;?></p>
            <p><span class="heading">Last Name: </span><?php echo htmlentities($last_name, ENT_QUOTES);//echo $last_name;?></p>
            <p><span class="heading">Mobile: </span><?php echo htmlentities($phone_number, ENT_QUOTES);//echo $phone_number;?></p>
            <p><span class="heading">Email: </span><?php echo htmlentities($email, ENT_QUOTES);//echo $email;?></p>
            
            </div>
            <div class="content4">
            <p><span class="heading">Account No: </span><?php echo htmlentities($account_no, ENT_QUOTES);//echo $account_no;?></p>
			<p><span class="heading">Address: </span><?php echo htmlentities($address, ENT_QUOTES);//echo $address;?></p>
            
            </div>
            </div>
        </div>
               <?php include 'footer.php';?>
            
    </body>
</html>