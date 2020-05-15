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
require './_inc/dbconn.php';
// Edit a customer

if(isset($_REQUEST['doneEdit'])){
  echo  "Edit Successful!</br>";

  $user = $_REQUEST['person'];

  $new_cust_sql = "SELECT first_name, last_name, email, phone_number, street_address, city, state, zip FROM user WHERE user_id=$user";

  $result = mysql_query($new_cust_sql);
  $row = mysql_fetch_array($result);

  if(htmlentities($_REQUEST['fname'], ENT_QUOTES) != $row['first_name'])
    $row['first_name'] = htmlentities($_REQUEST['fname'], ENT_QUOTES);
  if(htmlentities($_REQUEST['lname'], ENT_QUOTES) != $row['last_name'])
    $row['last_name'] = htmlentities($_REQUEST['lname'], ENT_QUOTES);
  if(htmlentities($_REQUEST['email'], ENT_QUOTES) != $row['email'])
    $row['email'] = htmlentities($_REQUEST['email'], ENT_QUOTES);
  if(htmlentities($_REQUEST['phone'], ENT_QUOTES) != $row['phone_number'])
    $row['phone_number'] = htmlentities($_REQUEST['phone'], ENT_QUOTES);
  if(htmlentities($_REQUEST['street'], ENT_QUOTES) != $row['street_address'])
    $row['street_address'] = htmlentities($_REQUEST['street'], ENT_QUOTES);
  if(htmlentities($_REQUEST['city'], ENT_QUOTES) != $row['city'])
    $row['city'] = htmlentities($_REQUEST['city'], ENT_QUOTES);
  if(htmlentities($_REQUEST['state'], ENT_QUOTES) != $row['state'])
    $row['state'] = htmlentities($_REQUEST['state'], ENT_QUOTES);
  if(htmlentities($_REQUEST['zip'], ENT_QUOTES) != $row['zip'])
    $row['zip'] = htmlentities($_REQUEST['zip'], ENT_QUOTES);

  $new_fname = $row['first_name'];
  $new_lname = $row['last_name'];
  $new_email = $row['email'];
  $new_phone = $row['phone_number'];
  $new_street = $row['street_address'];
  $new_city = $row['city'];
  $new_state = $row['state'];
  $new_zip = $row['zip'];

  $new_cust_sql = "UPDATE user SET first_name=\"" . $new_fname . "\", last_name=\"" . $row['last_name'] . "\", email=\""
    . $row['email'] . "\", phone_number=\"" . $row['phone_number'] . "\", street_address=\"" . $row['street_address'] . "\", city=\""
    . $row['city'] . "\", state=\"" . $row['state'] . "\", zip=\"" . $row['zip'] . "\" WHERE user_id=$user";

  mysql_query($new_cust_sql) or die(mysql_error());

}
if(isset($_REQUEST['editBtn'])) {
    $user=htmlentities($_REQUEST['userid'], ENT_QUOTES);
    $sql="SELECT * FROM user WHERE user_id='$user'";
    $result = mysql_query($sql) or die(my_sql_error());
    $row = mysql_fetch_array($result);

    if($row){
      echo "<h3 style=\"color:#2E4372;\"><u>Edit Customer Information</u></h3>";
        echo "<form action=\"edit_customer.php\" method=\"POST\">";
          echo "<table>";
            echo "<tr><td>First Name:</td><td><input type=\"text\" name=\"fname\" id=\"fnameInput\" value=\"" . $row['first_name'] . "\"maxlength=20></td></tr>";
            echo "<tr><td>Last Name:</td><td><input type=\"text\" name=\"lname\" id=\"lnameInput\" value=\"" . $row['last_name'] . "\"maxlength=20></td></tr>";
            echo "<tr><td>E-Mail:</td><td><input type=\"email\" name=\"email\" id=\"emailInput\" value=\"" . $row['email'] . "\"maxlength=25></td></tr>";
            echo "<tr><td>Phone Number:</td><td><input type=\"tel\" name=\"phone\" id=\"phoneInput\" value=\"" . $row['phone_number'] . "\"pattern=[0-9]{10}></td></tr>";
            echo "<tr><td>Street Address</td><td><input type=\"text\" name=\"street\" id=\"streetInput\" value=\"" . $row['street_address'] . "\"maxlength=20></td></tr>";
            echo "<tr><td>City</td><td><input type=\"text\" name=\"city\" id=\"cityInput\" value=\"" . $row['city'] . "\"maxlength=20></td></tr>";
            echo "<tr><td>State</td><td><select name=\"state\" required>
              <option value=\"". $row['state'] . "\">" . $row['state'] . "</option>
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
            </select>";
           echo "</td>";
          echo "</tr>";
            echo "<tr><td>Zip Code:</td><td><input type=\"text\" name=\"zip\" id=\"zipInput\" value=\"" . $row['zip'] . "\"pattern=(\d{5}([\-]\d{4})?)></td></tr>";
          echo "</table>";
          echo "<table>";
            echo "<tr><td><input type=\"submit\" name=\"doneEdit\" value=\"Submit Edits\"></td>";
            echo "<td><input type=\"reset\" value=\"Reset\"></td></tr>";
            echo "<input type=\"hidden\" name=\"person\" value=\"" . $row['user_id'] . "\"";
          echo "</table>";
        echo "</form>";
    }
}
else{
  //reading customer list
  echo "<H1>Edit Customer </H1>";
  echo("<form action=\"edit_customer.php\" method=\"POST\">");
  echo "<table border='1'>";
  echo "<tr><th></th><th>Customer ID</th><th>First Name</th><th>Last Name</th><th>E-mail</th></tr>";
  $result = mysql_query('SELECT user_id, first_name, last_name, email, phone_number,
                      street_address, city, state, zip, user_status, lastlogin
                      FROM user;') or die(my_sql_error());
                      
while($row = mysql_fetch_assoc($result)){
      echo "<tr>";
      echo "<td><input type=\"radio\" name=\"userid\" value=\"" . $row['user_id'] . "\"></td>";
      echo "<td>" . $row['user_id'] . "</td>";
      echo "<td>" . $row['first_name'] . "</td>";
      echo "<td>" . $row['last_name'] . "</td>";
      echo "<td>" . $row['email'] . "</td>";
  }
  echo "</table>";
  echo "<br>";

  echo "<table>";
  echo "<tr>";
  echo "<td>";
  echo "<input type=\"submit\" name=\"editBtn\" value=\"Edit\">";
  echo "</td>";
  echo "<td>";
  echo "<input type=\"reset\" value=\"Clear\">";
  echo "</td>";
  echo "</tr>";
  echo "</table>";
  echo "</form>";
  }
?>
<?php include 'footer.php'; ?>

