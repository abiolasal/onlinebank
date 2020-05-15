<?php 
session_start();
        
if(!isset($_SESSION['admin_login'])) 
    header('location:adminlogin.php');   
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin Homepage</title>
        
        <link rel="stylesheet" href="newcss.css">
    </head>
        <?php include 'header_admin.php' ?>
        <div class='content'>
            
           <?php include 'admin_navbar.php'?>
            <div class='admin_staff'>
               
                <ul>
                    <li><b><u>Staff</u></b></li>
				   <li> <a href="manage_staff.php">Manage staff</a></li>
                    <li> <a href="add_staff.php">Add new staff</a></li>
        </ul>
        </div>
        </div>
        <?php include 'footer.php';?>

</html>