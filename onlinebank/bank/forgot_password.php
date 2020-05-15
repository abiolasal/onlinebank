
<?php
if(isset($_REQUEST['submitBtn']))
{
	echo '<script>alert("If your email is registered, an email has been sent to you. ");';
	echo 'window.location= "index.php";</script>';
}

?>

<!DOCTYPE html>

<html>
    <head>
        
        <noscript><meta http-equiv="refresh" content="0;url=no-js.php"></noscript>    
        
        
        <meta charset="UTF-8">
        <title>Team A Banking System</title>
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
            <li><a href="features.php">Features </a></li>
            <li id="last"><a href="contact.php">Contact Us</a></li>
            </ul>
            </div>
            
        <div class="user_login">
            <form action='' method='POST'>
        <table align="left">
            <tr><td><span class="caption">Enter registered email address</span></td></tr>
            <tr><td colspan="2"><hr></td></tr>
            <tr><td>Email:</td></tr>
            <tr><td><input type="email" name="email" required></td> </tr>
            <tr><td class="button1"><input type="submit" name="submitBtn" value="Submit" class="button">
				</td>

			</tr>

		</table>
                </form>
            </div>
			
        
        <div class="image">
            <img src="home.jpg" height="100%" width="100%"/>
            
            </div>
            				
		
				</div>
				</body>
                    <?php include 'footer.php' ?>
