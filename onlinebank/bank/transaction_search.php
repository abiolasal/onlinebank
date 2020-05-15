
<?php 
//Starting the session
session_start();
//Checking if customer is logged in the site.        
if(!isset($_SESSION['customer_login'])) 
    header('location:index.php');   

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Account Statement</title>
        
        <link rel="stylesheet" href="newcss.css">
        <!--Styling for the transaction table -->
        <style>
            .content_customer table,th,td {
                padding:6px;
                border: 1px solid #2E4372;
                border-collapse: collapse;
                text-align: center;
                }
                .hoverTable td{ 
                        padding:7px; border:#4e95f4 1px solid;
                }
                /* Define the default color for all the table rows */
                .hoverTable tr{
                        background: #b8d1f3;
                }
                /* Define the hover highlight color for the table row */
                .hoverTable tr:hover {
                background-color: #ffff99;
                                             
                }
                /* Define the default color for all the table rows */
        
                .abc tr{
                        background: #b8d1f3;
                }
                /* Define the hover highlight color for the table row */
                .abc tr:hover {
                background-color: #ffff99;
                                                }

        </style>
    </head>
    <!--Adding header for the page-->
        <?php include 'header.php' ?>
<div class='content_customer'>
            <!--Including php page for navigation bar-->
           <?php include 'customer_navbar.php'?>
    
    
<div class="customer_top_nav">
            
        
            </div>

    <br><br><br><br>
    <h3 style="text-align:center;color:#2E4372;"><u>Account summary by Date</u></h3>
    <!--Creating form for searching the transaction.-->
    <form action="search_summary_date.php" method="POST">
    <table class = "hoverTable" align="center">
        <tr><td>Start Date  </td><td>
        <input type="date" name="date1" required></td></tr>
        
        <tr><td>End Date  </td><td>
        <input type="date" name="date2" required></td></tr>
     </table>
    
        <table align="center"  class = 'abc' ><tr>
            <td colspan="2"  align='center' >
        <input type="submit" name="summary" value="Search" class="addstaff_button"/></td>
        </tr>
        </table>
          </form>  
    
    </div>
    
</html>