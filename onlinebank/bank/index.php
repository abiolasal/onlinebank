
<?php 
if(isset($_REQUEST['submitBtn']))
{	$attempt=0;

    include '_inc/dbconn.php';
	$username=htmlentities($_REQUEST['uname'], ENT_QUOTES);
	$username=mysql_real_escape_string($username);
    $username=strtolower($username);
	
	if ($_POST["submitBtn"])
		{	
			//add slashes to protect from sql injection
			if (!get_magic_quotes_gpc())
			{
				$username = addslashes($username);
				$attempt = $_REQUEST['hidden'];
				if($attempt<4)
				{
					$sql1="SELECT user_id, email, user_status FROM user WHERE email='$username'";
					$result1=mysql_query($sql1) or die(mysql_error());
					$rws1=  mysql_fetch_array($result1);
					$user_id=$rws1[0];
					$email=$rws1[1];
					$user_status=$rws1[2];
					
					$sql2="SELECT pass, salt FROM pwd WHERE user_id='$user_id'";
					$result2=mysql_query($sql2) or die(mysql_error());
					$rws2=  mysql_fetch_array($result2);
					$pass=$rws2[0];
					$salt=$rws2[1];
					
					//salting of password
					$password= hash('sha256', $_REQUEST['pwd'].$salt);   
					
					if(strtolower($email)==strtolower($username) && $pass==$password)
					{
					
						if($user_status==0)
						{
							echo '<font color="#FF0000"><p align="center">Account has been disabled. Please visit a branch to re-activate. Thank you.</p></font>';

							//echo '<script>alert("Account has been disabled. Please visit a branch to re-activate. Thank you.");</script>';
						}else{
						
						session_start();
						$_SESSION['customer_login']=1;
						$_SESSION['cust_id']=$username;
						header('location:customer_account_summary.php'); 
						}
					}
					else
					{	$attempt++;
						echo '<font color="#FF0000"><p align="center">Incorrect Username/Password!</p></font>';
					}
				}
				else if ($attempt==4)
					{	$attempt++;
						echo '<font color="#FF0000"><p align="center">Too many wrong attempts. You have been locked out!</p></font>';

						//echo '<script>alert("Too many wrong attempts. Try again later");</script>';
						//echo 'window.location= "index.php";'; 
					}
		}
	}
}
?>
<?php 
session_start();
        
if(isset($_SESSION['customer_login'])) 
    header('location:customer_account_summary.php');   
?>

<!DOCTYPE html>

<html>
    <head>
        
        <noscript><meta http-equiv="refresh" content="0;url=no-js.php"></noscript>    
        
        
        <meta charset="UTF-8">
        <title>Online Banking System</title>
        <link rel="stylesheet" href="newcss.css">
    </head>
    <body>
        <div class="wrapper">
            
        <div class="header">
            <img src="header.jpg" height="100%" width="100%"/>
            </div>
            <div class="navbar">
                
            <ul>
            <li><a href="index.php">Home </a></li>
            <li><a href="features.php">About </a></li>
            <li><a href="contact.php">Contact Us</a></li>
            </ul>
            </div>
            
        <div class="user_login">
            <form action='' method='POST'>
        <table align="left">
		    <?php echo "<input type='hidden' name='hidden' value='".$attempt."'>"; ?>
            <tr><td><span class="caption">Login</span></td></tr>
            <tr><td colspan="2"><hr></td></tr>
            <tr><td>Username:</td></tr>
            <tr><td><input type="text" name="uname" <?php if($attempt==4){?> disabled="disabled" <?php } ?> required></td> </tr>
            <tr><td>Password:</td></tr>
            <tr><td><input type="password" name="pwd" <?php if($attempt==4){?> disabled="disabled" <?php } ?> required></td></tr>
            
            <tr><td class="button1"><input type="submit" name="submitBtn" value="Log In" class="button" <?php if($attempt==4){?> disabled="disabled" <?php } ?> >
									<a href="forgot_password.php">forgot password? </a></td>

			</tr>

		</table>
                </form>
            </div>
			
        
        <div class="image">
            <img src="home.jpg" height="100%" width="100%"/>
            
            </div>
            				
		<div class="right_panel">
            <form action='new_customer_registration.php' method='POST'>
        <table align="left">
            <tr><td><span class="caption">New Registration</span></td></tr>
            <tr><td colspan="2"><hr></td></tr>
            <tr><td>First Name <input type="text" name="first_name" placeholder="FirstName" required></td> </tr>
            <tr><td>Last Name <input type="text" name="last_name" placeholder="LastName" required></td> </tr>
			<tr><td>Email Address <input type="email" name="customer_email" required=""/></td></tr>
			<tr><td>Password <input type="password" name="customer_pwd" placeholder="Password(min. 8 characters)" pattern=".{8,}" required=""/></td></tr>
			<tr><td>Phone <input type="text" name="customer_mobile" required="True" pattern="[0-9]{10}$" /></td></tr>
			<tr><td>Street Address <input type="text" name="street_address" placeholder="street address" required=""></td></tr>
			<tr><td>City <input type="text" name="city" placeholder="city" pattern="[A-Za-z]{*}" required=""></td></tr>
			<tr><td>State<select name="state" required>
						<option value=""> STATE</option>
						<option value="AK">Alaska</option>
						<option value="AZ">Arizona</option>
						<option value="AR">Arkansas</option>
						<option value="CA">California</option>
						<option value="CO">Colorado</option>
						<option value="CT">Connecticut</option>
						<option value="DE">Delaware</option>
						<option value="FL">Florida</option>
						<option value="GA">Georgia</option>
						<option value="HI">Hawaii</option>
						<option value="ID">Idaho</option>
						<option value="IL">Illinois</option>
						<option value="IN">Indiana</option>
						<option value="IA">Iowa</option>
						<option value="KS">Kansas</option>
						<option value="KY">Kentucky</option>
						<option value="LA">Louisiana</option>
						<option value="ME">Maine</option>
						<option value="MD">Maryland</option>
						<option value="MA">Massachusetts</option>
						<option value="MI">Michigan</option>
						<option value="MN">Minnesota</option>
						<option value="MS">Mississippi</option>
						<option value="MO">Missouri</option>
						<option value="MT">Montana</option>
						<option value="NE">Nebraska</option>
						<option value="NV">Nevada</option>
						<option value="NH">New Hampshire</option>
						<option value="NJ">New Jersey</option>
						<option value="NM">New Mexico</option>
						<option value="NY">New York</option>
						<option value="NC">North Carolina</option>
						<option value="ND">North Dakota</option>
						<option value="OH">Ohio</option>
						<option value="OK">Oklahoma</option>
						<option value="OR">Oregon</option>
						<option value="PA">Pennsylvania</option>
						<option value="RI">Rhode Island</option>
						<option value="SC">South Carolina</option>
						<option value="SD">South Dakota</option>
						<option value="TN">Tennessee</option>
						<option value="TX">Texas</option>
						<option value="UT">Utah</option>
						<option value="VT">Vermont</option>
						<option value="VA">Virginia</option>
						<option value="WA">Washington</option>
						<option value="WV">West Virginia</option>
						<option value="WI">Wisconsin</option>
						<option value="WY">Wyoming</option>
					</select>
				</td>
			</tr>
			<tr><td>Zipcode <input type="text" name="zipcode" required="True" pattern="[0-9]{5}$" /></td></tr>
            <tr><td class="button1"><input type="submit" name="submitBtn2" value="Apply" class="button"></td></tr>
        </table>
                </form>
            </div>
            
            <div class="left_panel">
	
					
                </div>
				</div>
				</body>
                    <?php include 'footer.php' ?>
