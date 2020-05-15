</*?php 
session_start();
        
if(!isset($_SESSION['customer_login'])) 
    header('location:index.php');   
?*/>

<?php
if(isset($_REQUEST['submitBtn2']))
{
	include '_inc/dbconn.php';
	$username=htmlentities($_REQUEST['uname'], ENT_QUOTES);
	$first_name=  mysql_real_escape_string(htmlentities($_REQUEST['first_name'], ENT_QUOTES));
	$last_name=  mysql_real_escape_string(htmlentities($_REQUEST['last_name'], ENT_QUOTES));
	$street_address=  mysql_real_escape_string(htmlentities($_REQUEST['street_address'], ENT_QUOTES));
	$city=  mysql_real_escape_string(htmlentities($_REQUEST['city'], ENT_QUOTES));
	$state=  mysql_real_escape_string(htmlentities($_REQUEST['state'], ENT_QUOTES));
	$zip=  mysql_real_escape_string(htmlentities($_REQUEST['zipcode'], ENT_QUOTES));
	$phone_number=  mysql_real_escape_string(htmlentities($_REQUEST['customer_mobile'], ENT_QUOTES));
	$email=  mysql_real_escape_string(htmlentities($_REQUEST['customer_email'], ENT_QUOTES));

	$date=date("Y-m-d");
	//salting of password
	$salt = rand(1000000000,9999999999);
	$pass= hash('sha256', $_REQUEST['customer_pwd'].$salt);

	if ($_POST["submitBtn2"])
	{
		if(!$first_name || !$last_name || !$street_address || !$city || !$state || !$phone_number || !$email || !$zip || !$date)
		{
			echo "You have not entered all the required fields.<br />";
			echo "Please go back and try again.";
			exit();
		}
		else{
				//add slashes to protect from sql injection
				if (!get_magic_quotes_gpc())
				{
					$first_name=  addslashes($first_name);
					$last_name=  addslashes($last_name);
					//$user_id=  addslashes($user_id);
					$street_address=  addslashes($street_address);
					$city=  addslashes($city);
					$state=  addslashes($state);
					$phone_number=  addslashes($phone_number);
					$email= addslashes($email);
					$zip=  addslashes($zip);
					$pass=  addslashes($pass);
					$user_status = "1";
					//$lastlogin = "";
				}
				if (mysqli_connect_error())
				{
					echo 'Error: Could not create profile. Please try again later.';
					exit();
				}
				
				// insert user details into user table
				$sql="insert into user values('','$first_name','$last_name','$email','$phone_number','$street_address','$city',
				'$state','$zip','$user_status', '0')";
				$result = mysql_query($sql);

				//query user table to retrieve user's user ID
				$sql2 = "SELECT user_id FROM user WHERE email='$email'";
				$result2=mysql_query($sql2) or die(mysql_error());
				$rws =  mysql_fetch_array($result2);
				$user_id = $rws[0];
				//$pwd=$rws[1];    
				
				// insert user password and salt into pwd table
				$sql3="insert into pwd values('$user_id','$pass','$salt')";
				$result3 = mysql_query($sql3);

				// register user on the accounts table
				
				$sql4="insert into accounts values('$user_id','$user_id','0','1', '0')";
				$result4 = mysql_query($sql4);
				
				if ( $result2 && $result3 && $result4)
				{
					//echo '<script>alert("$user_id");';
					
					echo '<font color="#00FF00"><p align="center">Registration Successful. You will receive login details via email shortly. Thank you.</p></font>';
					header("Refresh:1; url=index.php");
					//echo '<script>alert("Registration Successful. You will receive login details via email shortly. Thank you. ");';
					//echo 'window.location= "index.php";</script>';
				}
				else
				{ //echo $salt;
				
					
					echo '<font color="#FF0000"><p align="center">User Already Exist!</p></font>';
					header("Refresh:1; url=index.php");
					//echo '<script>alert("User Already Exist!");';
					//echo 'window.location= "index.php";</script>';
				}
					
			}
	}}
?>
