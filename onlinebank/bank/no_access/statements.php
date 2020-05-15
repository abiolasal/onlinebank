<?php 
	
    // prepared sql statements
    // the file perms are 751 -> notice not world readable. 

		// prepared sql statement for new transaction
		$sql_transaction = "INSERT INTO `transactions` (`trans_id`, `account_id`, `amount`, `date`, `description`) VALUES (:trans_id, :account_id, :amount, NOW(), :description)";

?>