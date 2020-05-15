<?php
	// this file is used to keep a centeralized db. Anytime the database in need, calling the retrieve_database function will return the database.
	// this function only ever initializes the database once. After that, it returns the previous instance of the database.
	
	$db = NULL;
	function retrieve_database(){
		global $db;

		// importing the secret database connection string, username, and password
	    require_once 'secret.php';

		// if the database has already been defined, return the db
		if( isset($db) ){ return $db; }
		
		// if the database hasn't been created, create it and return it
		try{
			$db = new PDO($db_connection_string ,$db_user,$db_password);
			return $db;
		} 
		
		// if we fail to create the database, print the error and return NULL
		catch( PDOException $e ){
			echo "Connection failed: " . $e->getMessage();
			return NULL;
		}
	}
?>