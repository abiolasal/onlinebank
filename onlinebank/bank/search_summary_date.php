
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
    <!-- Styling the transaction table-->>
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
   <?php include 'header.php'?>

        <div class = "state_customer">
        <?php include 'customer_navbar.php'?>

                
                <h3 style ="text-align:center;color:#2E4372;"><u>Transaction history</u></h3>
                <table class='hoverTable' align="center">
                        <!--Creating table in HTML-->
                        <th>ID</th>
                        <th>Transaction Date</th>
                        <th>Description</th>
                        <th>Transaction Type</th>
                        <th>Amount</th>
                        <?php include '_inc/dbconn.php' ; ?>
                        
                        <?php if(isset($_REQUEST['summary'])) {
                        /* Fetching date value from form.*/
                        
                        $date1=$_REQUEST['date1'];
                        $date2=$_REQUEST['date2'];
                        $id = $_SESSION['login_id'];
                        $date_up = strtotime($date2);
                        /* Increasing the date by one to make it inclusive in SQL*/
                        $date2_up = date("Y-m-d", strtotime("+1 day", $date_up));
                        /* Creating SQL query*/
                        $sql_qury="SELECT * FROM transactions WHERE (trans_date BETWEEN '$date1' AND '$date2_up') AND account_id = $id";
                        /*Quering the database*/
                        $qury_result =  mysql_query($sql_qury) or die(mysql_error());
                        /*Fetching result*/
                        $dt = mysql_fetch_array($qury_result);
                        /*checking if date is wrongly enterted*/
                        if ($date2>$date1){
                        /*Cheaking if transaction for particular date is there.*/
                        if($dt ==False){
                                echo "<p align = 'center'> <font color=blue>No Transaction Found.</font> </p>";}
                        
                        while($data =  mysql_fetch_array($qury_result)){
                        /*Showing result of trasaction in table.*/
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
                        }}else{echo "<p align = 'center' > <font color=blue>Enter date correctly.</font> </p>";}}?>
                        
                    
                </table>
        </div>
        


</html>
