<?php 
session_start();
include '_inc/dbconn.php';

$date=date('Y-m-d H:i:s');
$id=$_SESSION['admin_login'];
$sql="UPDATE staff SET lastlogin='$date' WHERE first_name='admin'";
mysql_query($sql) or die(mysql_error());

session_destroy();
header('location:adminlogin.php');   
?>
