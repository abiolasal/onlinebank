<?php 
session_start();
include '_inc/dbconn.php';
        
if(!isset($_SESSION['admin_login'])) 
    header('location:adminlogin.php');   
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Change Password</title>
        
        <link rel="stylesheet" href="newcss.css">
    </head>
        <?php include 'header.php' ?>
        <div class='content'>
           <?php include 'admin_navbar.php'?>
            <div class='admin_change_pwd'>
            <form action="" method="POST">
                <table align="center">
                    <tr>
                        <td>Enter old password</td>
                        <td><input type="password" name="old_password" required=""/></td>
                    </tr>
                    <tr>
                        <td>Enter new password</td>
                        <td><input type="password" name="new_password" placeholder="Password(min. 10 characters)" pattern=".{10,}" required=""/></td>
                    </tr>
                    <tr>
                        <td>Enter new password again</td>
                        <td><input type="password" name="again_password" required=""/></td>
                    </tr>
                    <tr>
                        
                        <td colspan="2" align='center' style='padding-top:20px'><input type="submit" name="change_password" value="Change Password" class="addstaff_button"/></td>
                    </tr>
                </table>
            </form>
                </div>
            </div>
            <?php
            if(isset($_REQUEST['change_password'])){
            $sql="SELECT * FROM staff WHERE staff_id='100002'";
            $result=mysql_query($sql);
            $rws=  mysql_fetch_array($result);

			$salt=$rws[14];
			
			$old=  mysql_real_escape_string($_REQUEST['old_password']);
            $old= hash('sha256', $old.$salt);
			$new=  mysql_real_escape_string($_REQUEST['new_password']);
            $new=  hash('sha256', $new.$salt); 
			$again=  mysql_real_escape_string($_REQUEST['again_password']);
            $again= hash('sha256', $again.$salt);
			
            if($rws[13]==$old && $new==$again){
                $sql1="UPDATE staff SET pass='$new' WHERE staff_id='100002'";
                mysql_query($sql1) or die(mysql_error());
		    echo '<font color="#FF0000"><p align="center">Password changed successfully</p></font>';
               header('location:admin_hompage.php'); 
              //  echo '<script>alert("Password changed successfully ");';
               // echo 'window.location= "admin_hompage.php";</script>';
            }
            else{
		    echo '<font color="#FF0000"><p align="center">Password change failed</p></font>';
               header('location:change_password.php'); 
		    
		    //echo '<script>alert("Password change failed ");';
                //echo 'window.location= "change_password.php";</script>';
            }
            }
            ?>
            
        </div>
        <?php include 'footer.php';?>
