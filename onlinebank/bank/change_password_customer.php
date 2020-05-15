<?php 
session_start();
include '_inc/dbconn.php';
        
if(!isset($_SESSION['customer_login'])) 
    header('location:index.php');   
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Change Password</title>
        
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
             <div class="text">Welcome <?php echo $_SESSION['name']?></div>
            </div>

    <br><br><br><br>
    <h3 style="text-align:center;color:#2E4372;"><u>Change Password</u></h3>
            <form action="" method="POST">
                <table align="center">
                    <tr>
                        <td>Enter old password:</td>
                        <td><input type="password" name="old_password" required=""/></td>
                    </tr>
                    <tr>
                        <td>Enter new password:</td>
                        <td><input type="password" name="new_password" placeholder="Password(min. 8 characters)" pattern=".{8,}" required=""/></td>
                    </tr>
                    <tr>
                        <td>Enter new password again:</td>
                        <td><input type="password" name="again_password" pattern=".{8,}" required=""/></td>
                    </tr>
                    </table>
                    
                       <table align="center"><tr>
                        <td><input type="submit" name="change_password" value="Change Password" class="addstaff_button"/></td>
                    </tr>
                </table>
            </form>
            <?php
            $change=$_SESSION['login_id'];
            if(isset($_REQUEST['change_password'])){
            $sql="SELECT * FROM user WHERE user_id='$change'";
            $result=mysql_query($sql);
            $rws=  mysql_fetch_array($result);
			
			$sql2="SELECT * FROM pwd WHERE user_id='$change'";
            $result2=mysql_query($sql2);
            $rws2=  mysql_fetch_array($result2);
			
            
            $salt=$rws2[2];
			$old=  mysql_real_escape_string($_REQUEST['old_password']);
            $old= hash('sha256', $old.$salt);
			$new=  mysql_real_escape_string($_REQUEST['new_password']);
            $new=  hash('sha256', $new.$salt); 
			$again=  mysql_real_escape_string($_REQUEST['again_password']);
            $again= hash('sha256', $again.$salt);
            
            if($rws2[1]==$old && $new==$again){
                $sql1="UPDATE pwd SET pass='$new' WHERE user_id='$change'";
                mysql_query($sql1) or die(mysql_error());
			echo '<font color="#FF0000"><p align="center">Password changed successfully!</p></font>';
		    	header('location:customer_account_summary.php');
		  // echo '<script>alert("Password changed successfully ");';
                //echo 'window.location= "customer_account_summary.php";</script>';
            }
            else{
                echo '<font color="#FF0000"><p align="center">Password change failed</p></font>';
		    	header('location:customer_account_summary.php');
		  //  echo '<script>alert("Password change failed ");';
               // echo 'window.location= "customer_account_summary.php";</script>';
				}
            }
            ?>
            
        </div>
        <?php include 'footer.php';?>
