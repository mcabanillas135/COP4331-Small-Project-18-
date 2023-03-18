<?php
	// Error Testing
	error_reporting(E_ALL);
    	ini_set('display_errors', 'on');

	$inData = getRequestInfo();
	
	$id = 0;
	$username = $inData["User_Name"];
	$password = $inData["Password"];

	$conn = new mysqli("localhost", "contactmanager", "COP4331", "COP4331"); 	

	if( $conn->connect_error )
	{
		returnWithError( $conn->connect_error );
	}
	else
	{
		$stmt = $conn->prepare("SELECT * FROM Contact_user WHERE User_Name = ? AND Password = ?");
		$stmt->bind_param("ss", $username, $password);
		$stmt->execute();
		$result = $stmt->get_result();

		if( $row = $result->fetch_assoc() )
		{
			return returnWithInfo( $row['User_Name'], $row['Password']);
		}
		else
		{
			returnWithError("No Records Found");
		}
		
		$stmt->close();
		$conn->close();
	}
	
	function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}
	
	function returnWithError( $err )
	{
		$retValue = '{"User_Name":"","Password":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
	function returnWithInfo( $user, $pass)
	{
		$retValue = '{"User_Name":"' . $user . '","Password":"' . $pass . '","error":"","success":"Successfully logged in"}';
		sendResultInfoAsJson( $retValue );
	}
	
?>
