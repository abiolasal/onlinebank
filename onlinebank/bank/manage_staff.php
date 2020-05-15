<?php
session_start();

if(!isset($_SESSION['admin_login']))
    header('location:adminlogin.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="newcss.css">
    <style>
        .content_customer table,th,td {
            padding:6px;
            border: 1px solid #2E4372;
            border-collapse: collapse;
            text-align: center;
        }

    </style>
    <title>Manage staff</title>
</head>
<!-- Header -->
<?php include 'header_admin.php'; ?>
<!-- Navbar -->
<?php include 'admin_navbar.php'?>


<?php
    require('./no_access/_secret.php');

//Enable staff
if(isset($_REQUEST['enableBtn'])) {
    $staffid=htmlentities($_REQUEST['staffid'], ENT_QUOTES);
    $sql="UPDATE staff SET status = 1 WHERE staff_id ='$staffid'";
    $db->query($sql);
}

//disable staff
if(isset($_REQUEST['disableBtn'])){
    $staffid=htmlentities($_REQUEST['staffid'], ENT_QUOTES);
    $sql="UPDATE staff SET status = 0 WHERE staff_id ='$staffid'";
    $db->query($sql);
}

//reading staff list
    echo ("<form action=\"manage_staff.php\" method=\"POST\">");
    echo "<h2>Members of staff</h2>";
    echo "<table>";
    echo ("<tr>
        <th>Select</th>
        <th>Staff ID</th>
        <th>Last name</th>
        <th>First name</th>
        <th>E-Mail</th>
        <th>Phone</th>
        <th>Hire date</th>
        <th>Street</th>
        <th>City</th>
        <th>State</th>
        <th>ZIP</th>
        <th>Type</th>
        <th>Role</th>
        <th>Last login</th>
        <th>Status</th>
        </tr>");
    forEach( $db->query('SELECT staff_id, first_name, last_name, email, phone_number, hire_date,
                                        street_address, city, state, zip, type, department, lastlogin, status
                        FROM staff;') as $row ){
        echo "<tr>";
        echo "<td><input type=\"radio\" name=\"staffid\" value=\"" . $row['staff_id'] . "\"></td>";
        echo "<td>" . $row['staff_id'] . "</td>";
        echo "<td>" . $row['last_name'] . "</td>";
        echo "<td>" . $row['first_name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['phone_number'] . "</td>";
        echo "<td>" . $row['hire_date'] . "</td>";
        echo "<td>" . $row['street_address'] . "</td>";
        echo "<td>" . $row['city'] . "</td>";
        echo "<td>" . $row['state'] . "</td>";
        echo "<td>" . $row['zip'] . "</td>";
        echo "<td>";

        if ($row['type']=="0"){
            echo "Staff";
        }
        elseif ($row['type']=="1") {
            echo "Admin";
        }
        echo  "</td>";
        echo "<td>" . $row['department'] . "</td>";
        echo "<td>" . $row['lastlogin'] . "</td>";
        echo "<td>";
        if ($row['status']=="0"){
            echo "Disabled";
        }
        elseif ($row['status']=="1") {
            echo "Enabled";
        }
        //. $row['status'] .
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";

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
