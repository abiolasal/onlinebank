<?php 
session_start();

include '_inc/dbconn.php';
$date=date('Y-m-d H:i:s');
$staff_id=$_SESSION['staff_id'];
$sql="UPDATE staff SET lastlogin='$date' WHERE email='$staff_id'";
mysql_query($sql) or die(mysql_error());

session_destroy();
header('location:staff_login.php');
?>