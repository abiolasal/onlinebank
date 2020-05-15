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
    <title>Add new staffer</title>
</head>
<!-- Header -->
<?php include 'header_admin.php'; ?>
<!-- Navbar -->
<?php include 'admin_navbar.php'?>

<?php
require('./no_access/_secret.php');



if(isset($_REQUEST['Submit'])) {
    foreach ($db->query("SELECT MAX(staff_id) AS mv FROM `staff`;") as $row)
    {
        $staffid = $row['mv'] + 1;
    }
    //echo $staffid . "<br>";
    $salt = rand(1000000000, 9999999999);
    //echo $salt . "<br>";
    $pwd = htmlentities($_REQUEST['pwd'], ENT_QUOTES);
    $hashpw = hash("sha256", $pwd . $salt);
    //echo $hashpw . "<br>";
    $lname = htmlentities($_REQUEST['l_name'], ENT_QUOTES);
    //echo $lname . "<br>";
    $fname = htmlentities($_REQUEST['f_name'], ENT_QUOTES);
    //echo $fname . "<br>";
    $email = htmlentities($_REQUEST['e_mail'], ENT_QUOTES);
    //echo $email . "<br>";
    $phonenum = htmlentities($_REQUEST['phone_num'], ENT_QUOTES);
    //echo $phonenum . "<br>";
    $hrdate = $_REQUEST['hr_date'];
    //echo $hrdate . "<br>";
    $street = htmlentities($_REQUEST['street'], ENT_QUOTES);
    //echo $street . "<br>";
    $city = htmlentities($_REQUEST['city'], ENT_QUOTES);
    //echo $city . "<br>";
    $state = $_REQUEST['state'];
    //echo $state . "<br>";
    $zip = htmlentities($_REQUEST['zip'], ENT_QUOTES);
    //echo $zip . "<br>";
    $role = htmlentities($_REQUEST['role'], ENT_QUOTES);
    //echo $role . "<br>";
    $type = $_REQUEST['type'];


    $sql1 = "INSERT INTO staff (`staff_id`, `first_name`, `last_name`, `email`, `phone_number`, `hire_date`,
                `street_address`, `city`, `state`, `zip`, `type`, `department`, `pass`, `salt`,
                `status`) VALUES ('$staffid','$fname','$lname','$email','$phonenum','$hrdate',
                        '$street','$city','$state','$zip','$type','$role','$hashpw','$salt',1)";
    $db->query($sql1);


}

echo ("<form action=\"add_staff.php\" method=\"POST\">");
echo "<h2> Add user </h2>";
echo "<table>";
echo "<tr>";
echo "<td>";
echo"<label for=\"f_name\">First name</label>";
echo "</td>";
echo "<td>";
echo "<input type=\"text\" id=\"f_name\" name=\"f_name\" required>";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo "<label for=\"l_name\">Last name</label>";
echo "</td>";
echo "<td>";
echo "<input type=\"text\" id=\"l_name\" name=\"l_name\" required>";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo "<label for=\"e_mail\">E-Mail</label>";
echo "</td>";
echo "<td>";
echo "<input type=\"email\" id=\"e_mail\" name=\"e_mail\" required>";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo "<label for=\"phone_num\">Phone number</label>";
echo "</td>";
echo "<td>";
echo "<input type=\"text\" id=\"phone_num\" name=\"phone_num\" required>";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo "<label for=\"hr_date\">Hire date</label>";
echo "</td>";
echo "<td>";
echo "<input type=\"date\" id=\"hr_date\" name=\"hr_date\" value=\"mm / dd / yyyy\" required>";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo "<label for=\"street\">Street</label>";
echo "</td>";
echo "<td>";
echo "<input type=\"text\" id=\"street\" name=\"street\" required>";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo "<label for=\"city\">City</label>";
echo "</td>";
echo "<td>";
echo "<input type=\"text\" id=\"city\" name=\"city\" required>";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo "<label for=\"state\">State</label>";
echo "</td>";
echo "<td>";
echo (" <select name=\"state\" required>
						<option value=\"\"> STATE</option>
						<option value=\"AK\">Alaska</option>
						<option value=\"AZ\">Arizona</option>
						<option value=\"AR\">Arkansas</option>
						<option value=\"CA\">California</option>
						<option value=\"CO\">Colorado</option>
						<option value=\"CT\">Connecticut</option>
						<option value=\"DE\">Delaware</option>
						<option value=\"FL\">Florida</option>
						<option value=\"GA\">Georgia</option>
						<option value=\"HI\">Hawaii</option>
						<option value=\"ID\">Idaho</option>
						<option value=\"IL\">Illinois</option>
						<option value=\"IN\">Indiana</option>
						<option value=\"IA\">Iowa</option>
						<option value=\"KS\">Kansas</option>
						<option value=\"KY\">Kentucky</option>
						<option value=\"LA\">Louisiana</option>
						<option value=\"ME\">Maine</option>
						<option value=\"MD\">Maryland</option>
						<option value=\"MA\">Massachusetts</option>
						<option value=\"MI\">Michigan</option>
						<option value=\"MN\">Minnesota</option>
						<option value=\"MS\">Mississippi</option>
						<option value=\"MO\">Missouri</option>
						<option value=\"MT\">Montana</option>
						<option value=\"NE\">Nebraska</option>
						<option value=\"NV\">Nevada</option>
						<option value=\"NH\">New Hampshire</option>
						<option value=\"NJ\">New Jersey</option>
						<option value=\"NM\">New Mexico</option>
						<option value=\"NY\">New York</option>
						<option value=\"NC\">North Carolina</option>
						<option value=\"ND\">North Dakota</option>
						<option value=\"OH\">Ohio</option>
						<option value=\"OK\">Oklahoma</option>
						<option value=\"OR\">Oregon</option>
						<option value=\"PA\">Pennsylvania</option>
						<option value=\"RI\">Rhode Island</option>
						<option value=\"SC\">South Carolina</option>
						<option value=\"SD\">South Dakota</option>
						<option value=\"TN\">Tennessee</option>
						<option value=\"TX\">Texas</option>
						<option value=\"UT\">Utah</option>
						<option value=\"VT\">Vermont</option>
						<option value=\"VA\">Virginia</option>
						<option value=\"WA\">Washington</option>
						<option value=\"WV\">West Virginia</option>
						<option value=\"WI\">Wisconsin</option>
						<option value=\"WY\">Wyoming</option>
					</select>");
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo "<label for=\"zip\">ZIP Code</label>";
echo "</td>";
echo "<td>";
echo "<input type=\"text\" id=\"zip\" name=\"zip\">";
echo "</td>";
echo "</tr>";

echo ("<tr>
            <td>
                <label for=\"role\">Role</label>
            </td>
            <td>
                <input type=\"text\" id=\"role\" name=\"role\" required>
            </td>
        </tr>");

echo ("<tr>
            <td>
                <label for=\"type\">Type</label>
            </td>
            <td>
                <select name=\"type\" required>
                    <option value=\"1\">Admin</option>
                    <option value=\"0\" selected>Staff</option>
                </select>
            </td>
        </tr>");
echo ("<tr>
            <td>
                <label for=\"pwd\">Password</label>
            </td>
            <td>
                <input type=\"password\" id=\"pwd\" name=\"pwd\" required>
            </td>
        </tr>
        </table>");

echo ("
            <table><tr>
            <td>
                <input type=\"submit\" value=\"Add staff\" name=\"Submit\">
            </td>
            <td>
                <input type=\"reset\" value=\"Clear\">
            </td>
        </tr>
        </table>
    </form>");

?>