<?php 
session_start();
        
if(isset($_SESSION['staff_login'])) 
    header('location:staff_homepage.php');   
?>
<!DOCTYPE html>
<html>
    <head>
        <noscript><meta http-equiv="refresh" content="0;url=no-js.php"></noscript>  
        <meta charset="UTF-8">
        <title>Staff Login - Online Banking</title>
        
        <link rel="stylesheet" href="newcss.css">
    </head>
<?php
include 'header.php'; ?>

<div class='content'>
<div class="user_login">
    <form action='' method='POST'>
        <table align="center">
            <tr><td><span class="caption">Staff Login</span></td></tr>
            <tr><td colspan="2"><hr></td></tr>
            <tr><td>Username:</td></tr>
            <tr><td><input type="text" name="uname" required></td></tr>
            <tr><td>Password:</td></tr>
            <tr><td><input type="password" name="pwd" required></td></tr>
            <tr><td class="button1"><input type="submit" name="submitBtn" value="Log In" class="button"></td></tr>

		</table>
    </form>
		<?php
if(isset($_REQUEST['submitBtn'])){
    include '_inc/dbconn.php';
    
	$username=htmlentities($_REQUEST['uname'], ENT_QUOTES);
	$username= mysql_real_escape_string($username);
	$username=strtolower($username);
    $sql1="SELECT staff_id, email, pass, salt, status FROM staff WHERE email='$username'";
	$result1=mysql_query($sql1) or die(mysql_error());
	$rws1=  mysql_fetch_array($result1);
	$staff_id=$rws1[0];
	$email=$rws1[1];
	$pass=$rws1[2];
	$salt=$rws1[3];
	$status=$rws1[4];
	
	//salting of password
	$password=  mysql_real_escape_string($_REQUEST['pwd']);
	$password= hash('sha256', $password.$salt); 
	
  
	if($_POST['submitBtn'])
	{
	
	
		if(!$username || !$password )
		{
			echo "You have not entered all the required fields.<br />";
			echo "Please go back and try again.";
			exit();
		}
		else if (strtolower($username) == 'admin')
		{
		
		     
			//echo '<script>alert("Invalid User");';
			echo '<font color="#FF0000" ><p align="center">Invalid User!</p></font>';
			//echo 'Invalid';
			//echo 'window.location= "staff_login.php";</script>';
		}
		
		
		else{
				//add slashes to protect from sql injection
				if (!get_magic_quotes_gpc())
				{
					$username=  addslashes($username);
					$password=  addslashes($password);
				}

				if(strtolower($rws1[1])==strtolower($username) && $rws1[2]==$password)
				{
					if($status==0)
						{
							echo '<font color="#FF0000" ><p align="center">Account has been disabled. Please visit a branch to re-activate. Thank you.</p></font>';
							//echo '<script>alert("Account has been disabled. Please visit a branch to re-activate. Thank you.");</script>';
						}else{
					session_start();
					$_SESSION['staff_login']=1;
					$_SESSION['staff_id']=$username;
					header('location:staff_homepage.php'); 
					}
				}	
				else{
					echo '<font color="#FF0000" ><p align="center">Incorrect Login Credentials</p></font>';
					//echo '<script>alert("Incorrect Login Credentials");';
					//echo 'window.location= "staff_login.php";</script>';
					}
		}	}
	}
?>
            </div>
        </div>
          
