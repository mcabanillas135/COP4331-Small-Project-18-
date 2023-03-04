<?php

	$inData = getRequestInfo();
	
	$id = 0;
	$firstName = "";
	$lastName = "";
	
	$host = 'cop4332.xyz';
	$user = 'contactmanager';
	$password = 'COP4331';
	$database = 'COP4331';

	// Create connection
	$conn = new mysqli($host, $user, $password, $database);
	if( $conn->connect_error )
	{
		returnWithError( $conn->connect_error );
	}
	else
	{
		$stmt = $conn->prepare("SELECT * FROM Contact_User WHERE User_Name = ? AND Password = ?");
		$stmt->bind_param("ss", $inData["User_Name"], $inData["Password"]);
		$stmt->execute();
		$result = $stmt->get_result();

		if( $row = $result->fetch_assoc()  )
		{
			returnWithInfo( $row['User_Name'], $row['Password'], $row['User_Id'] );
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
		$retValue = '{"User_Id":0,"User_Name":"","Password":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
	function returnWithInfo( $firstName, $lastName, $id )
	{
		$retValue = '{"User_Id":' . $id . ',"User_Name":"' . $firstName . '","Password":"' . $lastName . '","error":""}';
		sendResultInfoAsJson( $retValue );
	}
	
?>
