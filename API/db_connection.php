<?php
	
	// $host = 'cop4332.xyz';
	$host = '24.199.121.145';
	$user = 'contactmanager';
	$password = 'COP4331';
	$database = 'COP4331';

	// Create connection
	$conn = new mysqli($host, $user, $password, $database);

	// Check connection
	if ($conn->connect_error) 
	{
		$retValue = '{"User_Id":0,"User_Name":"","Password":"","error":"' . $conn->connect_error . '"}';
		header('Content-type: application/json');
		echo $retValue;
	
   		// Adding a more explicit script terminator because of science
		exit()
    	}

	// Set the charset to UTF-8
	// uncomment if we know that our database is using utf8, by default sql uses Latin1 or something
	// mysqli_set_charset($conn, "utf8mb4");

?>
