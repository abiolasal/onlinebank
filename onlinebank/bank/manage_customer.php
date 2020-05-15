<?php
session_start();

if(!isset($_SESSION['staff_login']))
    header('location:staff_login.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage customer</title>

    <link rel="stylesheet" href="newcss.css">
    <style>
        .content_customer table,th,td {
            padding:6px;
            border: 1px solid #2E4372;
            border-collapse: collapse;
            text-align: center;
        }

    </style>
</head>
<!-- Header -->
<?php include 'header_staff.php'; ?>
<!-- Navbar -->
<?php include 'staff_navbar.php'?>
<?php
require './no_access/_secret.php';
//Enable a customer
if(isset($_REQUEST['enableBtn'])) {
    $userid=htmlentities($_REQUEST['userid'], ENT_QUOTES);
    $sql="UPDATE user SET user_status = 1 WHERE user_id ='$userid'";
    $db->query($sql);
}

//disable a customer
if(isset($_REQUEST['disableBtn'])){
    $userid=htmlentities($_REQUEST['userid'], ENT_QUOTES);
    $sql="UPDATE user SET user_status = 0 WHERE user_id ='$userid'";
    $db->query($sql);
}
    //reading customer list
    echo "<H1>Enable/Disable a Customer </H1>";
    echo("<form action=\"manage_customer.php\" method=\"POST\">");
    echo "<table border='1'>";
    echo "<tr><th></th><th>Customer ID</th><th>Last name</th><th>First Name</th><th>E-mail</th><th>Phone</th><th>Street</th><th>City</th><th>State</th><th>ZIP</th><th>Status</th><th>Last logon</th></tr>";
    foreach ($db->query('SELECT user_id, first_name, last_name, email, phone_number,
                        street_address, city, state, zip, user_status, lastlogin
                        FROM user;') as $row) {
        echo "<tr>";
        echo "<td><input type=\"radio\" name=\"userid\" value=\"" . $row['user_id'] . "\"></td>";
        echo "<td>" . $row['user_id'] . "</td>";
        echo "<td>" . $row['last_name'] . "</td>";
        echo "<td>" . $row['first_name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['phone_number'] . "</td>";
        echo "<td>" . $row['street_address'] . "</td>";
        echo "<td>" . $row['city'] . "</td>";
        echo "<td>" . $row['state'] . "</td>";
        echo "<td>" . $row['zip'] . "</td>";
        echo "<td>";

        if ($row['user_status'] == "0") {
            echo "Disabled";
        } elseif ($row['user_status'] == "1") {
            echo "Active";
        }
        echo "</td>";
        echo "<td>" . $row['lastlogin'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<br>";

    echo "<table>";
    echo "<tr>";
    echo "<td>";
    echo "<input type=\"submit\" name=\"enableBtn\" value=\"Enable\">";
    echo "</td>";
    echo "<td>";
    echo "<input type=\"submit\" name=\"disableBtn\" value=\"Disable\">";
    echo "</td>";
    echo "<td>";
    echo "<input type=\"reset\" value=\"Clear\">";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "</form>";

?>
<?php include 'footer.php'; ?>

