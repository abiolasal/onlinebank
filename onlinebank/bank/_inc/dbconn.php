<?php
$serverName="localhost";
$dbusername="";
$dbpassword="";
$dbname="test";
mysql_connect($serverName,$dbusername,$dbpassword);
mysql_select_db($dbname) or die(mysql_error());
?>
