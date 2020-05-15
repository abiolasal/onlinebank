
<?php 
//Starting the session
session_start();
//Checking if customer is logged in the site.        
if(!isset($_SESSION['customer_login'])) 
    header('location:index.php');   

?>
<!DOCTYPE html>
<html>
    <title>Account Statement</title>
    <link rel = "stylesheet" href="newcss.css">
    <!--Styling for the transaction table -->
    <style>
                .state_customer table,th,td {
                flex-wrap: wrap;
                padding:6px;
                border: 1px solid #2E4372;
                border-collapse: collapse;
                text-align: center; }
                
                /* Define the default color for all the table rows */
                .hoverTable tr{
                        background: #b8d1f3;
                        
                }
                /* Define the hover highlight color for the table row */
                .hoverTable tr:hover {
                background-color: #ffff99;
                                                }
</style>

   
   </head>
   <!--Adding header for the page-->
   <?php include 'header.php'?>

        <div class = "state_customer">
        <?php include 'customer_navbar.php'?>
                
                
                <h3 style ="text-align:center;color:#2E4372;"><u>Transaction history</u></h3>
                <!--Creating table in HTML-->
                <table class='hoverTable' align="center">
                        
                        <th>ID</th>
                        <th>Transaction Date</th>
                        <th>Description</th>
                        <th>Transaction Type</th>
                        <th>Amount</th>
                        <!--Including the database connection page.-->
                        <?php include '_inc/dbconn.php' ;?>
<?php
   
	                //Retreving the id of the account
                        $acc_id = $_SESSION['login_id'];
                        // SQl state foe query
                        $sql_qury="SELECT * FROM transactions WHERE account_id = '$acc_id'";
                        
                        // Querering the database
                        $qury_result =  mysql_query($sql_qury) or die(mysql_error());
                        $data  = mysql_fetch_array($qury_result);

                        //Checking if result is empty
                        if($data ==False){
                                echo "<p align = 'center'> <font color=blue>No Transaction Found.</font> </p>";}
                        do{
                        // Showing result in the table
                        $stt0 = $data[0];
                        $stt2 = $data[2];
                        $stt3 = $data[3];
                        $stt4 = $data[4];
                        $stt5 = $data[5];
                        echo "<tr>";
                        echo "<td>".htmlentities($stt0, ENT_QUOTES | ENT_HTML5, 'UTF-8')."</td>";
                        echo "<td>".htmlentities($stt3, ENT_QUOTES | ENT_HTML5, 'UTF-8')."</td>";
   
     
                        echo "<td>".htmlentities($stt4, ENT_QUOTES | ENT_HTML5, 'UTF-8')."</td>";
                        echo "<td>".htmlentities($stt5, ENT_QUOTES | ENT_HTML5, 'UTF-8')."</td>";
                        echo "<td>".htmlentities($stt2, ENT_QUOTES | ENT_HTML5, 'UTF-8')."</td>";


                        echo "</tr>";
                        }while($data =  mysql_fetch_array($qury_result))

?>
                        
                    
                </table>
        </div>
        <!--Adding footer for the page-->
        <?php include 'footer.php'?>


</html>
