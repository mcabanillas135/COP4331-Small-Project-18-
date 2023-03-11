<?php
	$inData = getRequestInfo();

	$username = $inData['User_Name'];
	$password = $inData['Password'];

	// Imported the connection since it will be the same code across the entire api
	// Adds a level of encryption as the database login details arent AS visible
	require_once('db_connection.php');

	// If the connectin is a success, automatically enter the sql query. Not very safe would be better to have a handleLogin() function instead
	// Not a big deal for our purposes
	$user_info = getUserInfo($conn, $username, $password);

	$conn->close();


	function getUserInfo($conn, $user, $pass) 
	{
		// Preparing the sql query with a statement, much more secure as opposed to the sql_query() function
		$stmt = $conn->prepare("SELECT * FROM Contact_User WHERE User_Name = ? AND Password = ? LIMIT 1");
		$stmt->bind_param("ss", $user, $pass);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
		
		// If logging in returns a user, return the user with the success code
		if ($row = $result->fetch_assoc()) 
		{
			returnWithInfo($row['User_Name'], $row['Password']);
			return 
			[
				'User_Name' => $row['User_Name'],
				'Password' => $row['Password'],
			];
		} else 
		{
			returnWithError("No Records Found");
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
				'User_Name' => '',
				'Password' => '',
				'error' => $err 
			];
		sendResultInfoAsJson( $retValue );
	}
	
	function returnWithInfo( $user_name, $password )
	{
		// Print a success
		http_response_code(200);
		$retValue =
			[
				'User_Name' => $user_name,
				'Password' => $password,
				'error' => 'none'
			];
		sendResultInfoAsJson( $retValue );
	}
	
?>
