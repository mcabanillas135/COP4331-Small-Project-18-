<?php
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
	header('Access-Control-Allow-Headers: Content-Type');

	$inData = getRequestInfo();
	
	$id = $inData['User_Id'];
	$username = $inData['User_Name'];
	$password = $inData['Password'];

	// Imported the connection since it will be the same code across the entire api
	// Adds a level of encryption as the database login details arent AS visible
	// require_once('db_connection.php');
	$host = 'cop4332.xyz';
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


	// If the connectin is a success, automatically enter the sql query. Not very safe would be better to have a handleLogin() function instead
	// Not a big deal for our purposes
	$user_info = getUserInfo($conn, $username, $password);

	// If logging in returns a user, return the user with the success code
	if ($user_info) 
	{
		returnWithInfo($user_info['User_Name'], $user_info['Password'], $user_info['User_Id']);
	} else 
	{
		returnWithError("No Records Found");
	}

	$conn->close();


	function getUserInfo($conn, $user, $pass) 
	{
		// Preparing the sql query with a statement, much more secure as opposed to the sql_query() function
		$stmt = $conn->prepare("SELECT * FROM Contact_User WHERE User_Name = ? AND Password = ? LIMIT 1");
		$stmt->bind_param("ss", $user, $pass);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
		
		if ($row = $result->fetch_assoc()) 
		{
			// Returning it like this makes it easier to format into json if i remember correctly
			return 
			[
				'User_Name' => $row['User_Name'],
				'Password' => $row['Password'],
				'User_Id' => $row['User_Id']
			];
		} else 
		{
			return null;
		}
	}

	function getRequestInfo()
	{
		// Just the normal php syntax for getting a post request i believe
		return json_decode(file_get_contents('php://input'), true);
	}

	function sendResultInfoAsJson( $obj )
	{
		// Lets the receiver/sender know the data type
		header('Content-type: application/json');
		echo $obj;
	}
	
	function returnWithError( $err )
	{
		// Print an error
		http_response_code(400);
		$retValue = 
			[        
				'User_Id' => 0,
				'User_Name' => '',
				'Password' => '',
				'error' => $err 
			];
		sendResultInfoAsJson( json_encode($retValue) );
	}
	
	function returnWithInfo( $user_name, $password, $id )
	{
		// Print a success
		http_response_code(200);
		$retValue =
			[
				'User_Id' => $id,
				'User_Name' => $user_name,
				'Password' => $password,
				'error' => 'none'
			];
		sendResultInfoAsJson( json_encode($retValue) );
	}
	
?>
