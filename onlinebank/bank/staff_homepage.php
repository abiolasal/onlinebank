<?php 
session_start();
        
if(!isset($_SESSION['staff_login'])) 
    header('location:staff_login.php');   
?>
 <?php
                $staff_id=$_SESSION['staff_id'];
                include '_inc/dbconn.php';
                $sql="SELECT * FROM staff WHERE email='$staff_id'";
                $result=  mysql_query($sql) or die(mysql_error());
                $rws=  mysql_fetch_array($result);
                
                $staff_id=$rws[0];
                $first_name=$rws[1];
				$last_name=$rws[2];
				$name = ucwords($first_name).' '. ucwords($last_name);
				$email=$rws[3];
				$mobile=$rws[4];
				$hire_date=$rws[5];
                $street_add=$rws[6];
                $city=$rws[7];
				$state=$rws[8];
				$zip=$rws[9];
				$address = ucwords($street_address).', '. ucwords($city).', ' .$zip.  ', ' .ucwords($state);

				$type=$rws[10];
				switch($type){
					case '1': $type="ADMIN";
						break;
					case '0': $type="STAFF";
						break;
					}
				$department=$rws[11];
				$last_login=$rws[12];
				$status=$rws[15];
				switch($status){
					case '1': $status="ACTIVE";
						break;
					case '0': $status="INACTIVE";
						break;
					}
               
                $_SESSION['login_id']=$email;
                $_SESSION['name1']=$first_name;
                $_SESSION['id']=$staff_id;
                ?>
            
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Staff Home</title>
        
        <link rel="stylesheet" href="newcss.css">
    </head>
        <?php include 'header.php' ?>
        <div class="displaystaff_content">
            
           <?php include 'staff_navbar.php'?>
            <div class="customer_top_nav">
             <div class="text">Welcome <?php echo htmlentities($_SESSION['name1'], ENT_QUOTES);//echo $_SESSION['name1']?></div>
            </div>
           
            <div class="customer_body">
             <div class="content1">
                <p><span class="heading">Name: </span><?php echo htmlentities($name, ENT_QUOTES);//echo $name;?></p>
            <p><span class="heading">Department: </span><?php echo htmlentities($department, ENT_QUOTES);//echo $department;?></p>
            <p><span class="heading">Account: </span><?php echo htmlentities($type, ENT_QUOTES);//echo $type;?></p>
            <p><span class="heading">Email: </span><?php echo htmlentities($email, ENT_QUOTES);//echo $email;?></p>
            </div>
             <div class="content2">
            <p><span class="heading">Staff ID: </span><?php echo htmlentities($staff_id, ENT_QUOTES);//echo $staff_id;?></p>
			<p><span class="heading">Hire Date: </span><?php echo htmlentities($hire_date, ENT_QUOTES);//echo $hire_date;?></p>
			<p><span class="heading">Status: </span><?php echo htmlentities($status, ENT_QUOTES);//echo $status;?></p>
            <p><span class="heading">Last Login: </span><?php echo htmlentities($last_login, ENT_QUOTES);//echo $last_login;?></p>
            </div>
            </div>
        </div>
    <?php include 'footer.php';?>
<?php
$date1=date('Y-m-d H:i:s');
$_SESSION['staff_date']=$date1;
?>
            
                
