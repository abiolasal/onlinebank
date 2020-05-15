<?php 
session_start();
        
if(isset($_SESSION['admin_login'])) 
    header('location:admin_homepage.php');   
?>

<!DOCTYPE html>
<html>
    <head>
        <noscript><meta http-equiv="refresh" content="0;url=no-js.php"></noscript>  
        <meta charset="UTF-8">
        <title>Admin Login - Online Banking</title>
        
        <link rel="stylesheet" href="newcss.css">
    </head>
<?php
include 'header.php'; ?>

<div class='content'>
<div class="user_login">
    <form action='' method='POST'>
        <table align="center">
            <tr><td><span class="caption">Admin Login</span></td></tr>
            <tr><td colspan="2"><hr></td></tr>
            <tr><td>Username:</td></tr>
            <tr><td><input type="text" name="uname" required></td></tr>
            <tr><td>Password:</td></tr>
            <tr><td><input type="password" name="pwd" required></td></tr>
            <tr><td class="button1"><input type="submit" name="submitBtn" value="Log In" class="button"></td></tr>
        </table>
    </form>
            </div>
        </div>
          
<?php include 'footer.php';
?>
<?php 

if(!isset($_SESSION['admin_login']))
	{
		if(isset($_REQUEST['submitBtn'])){
		include '_inc/dbconn.php';
		
		$username=  strtolower(mysql_real_escape_string($_REQUEST['uname']));
		$sql1="SELECT staff_id, first_name, pass, salt FROM staff WHERE first_name='$username'";
		$result1=mysql_query($sql1) or die(mysql_error());
		$rws1=  mysql_fetch_array($result1);
		$staff_id=$rws1[0];
		$first_name=$rws1[1];
		$pass=$rws1[2];
		$salt=$rws1[3];
		
		
		//salting of password
		$password=  mysql_real_escape_string($_REQUEST['pwd']);
		$password= hash('sha256', $password.$salt); 
		
		
		if ($_POST["submitBtn"])
		{
			if(!$username || !$password)
			{
				echo "You have not entered all the required fields.<br />";
				echo "Please go back and try again.";
				exit();
			}
			else{
				//add slashes to protect from sql injection
				if (!get_magic_quotes_gpc())
				{
					$username=  addslashes($username);
					$password=  addslashes($password);
				}
	
				//$sql="SELECT * FROM admin WHERE id='1'";
				//$result=mysql_query($sql);
				//$rws=  mysql_fetch_array($result);
								
				if(strtolower($username)==strtolower($rws1[1]) && $password==$rws1[2]) {
        
				$_SESSION['admin_login']=1;
				header('location:admin_hompage.php'); }
				else
					header('location:adminlogin.php');      
				}
			}
else {
    header('location:admin_hompage.php');
}}}
?>