<?php 
session_start();

include '_inc/dbconn.php';

$date=date('Y-m-d H:i:s');
$id=$_SESSION['login_id'];
$sql="UPDATE user SET lastlogin='$date' WHERE user_id='$id'";
mysql_query($sql) or die(mysql_error());

session_destroy();
header('location:index.php');
?>