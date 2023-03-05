<?php

	$inData = getRequestInfo();
	
	// Imported the connection since it will be the same code across the entire api
	// Adds a level of encryption as the database login details arent AS visible
	require_once('db_connection.php');
	
	// If the connectino is a success, enter the sql query. Not very safe would be better to have a handleLogin() function instead
	// Not a big deal for our purposes
	if( !$conn->connect_error )
	{
		$user_info = getUserInfo($conn, $inData['User_Name'], $inData['Password']);

		// If logging in returns a user, return the user with the success code
		if ($user_info) 
		{
			returnWithInfo($user_info['user_name'], $user_info['password'], $user_info['user_id']);
		} else 
		{
			returnWithError("No Records Found");
		}
		
		$conn->close();
	}

	function getUserInfo($conn, $username, $password) {
		// Preparing the sql query with a statement, much more secure as opposed to the sql_query() function
		$stmt = $conn->prepare("SELECT * FROM Contact_User WHERE User_Name = ? AND Password = ?");
		$stmt->bind_param("ss", $username, $password);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($row = $result->fetch_assoc()) 
		{
			// Returning it like this makes it easier to format into json if i remember correctly
			return 
			[
				'user_name' => $row['User_Name'],
				'password' => $row['Password'],
				'user_id' => $row['User_Id']
			];
		} else 
		{
			return null;
		}

		$stmt->close();
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
		$retValue = '{"User_Id":0,"User_Name":"","Password":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
	function returnWithInfo( $user_name, $password, $id )
	{
		// Print a success
		http_response_code(200);
		$retValue = '{"User_Id":' . $id . ',"User_Name":"' . $user_name . '","Password":"' . $password . '","error":""}';
		sendResultInfoAsJson( $retValue );
	}
	
?>
