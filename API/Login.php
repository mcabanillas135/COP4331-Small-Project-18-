<?php
	$inData = getRequestInfo();
	
	$firstName = "";
	$lastName = "";

	$conn = new mysqli("localhost", "contactmanager", "COP4331", "COP4331"); 	
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
			returnWithInfo( $row['User_Name'], $row['Password']);
		}
		else
		{
			returnWithError("No Records Found");
		}
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
		$retValue = '{"id":0,"firstName":"","lastName":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
	function returnWithInfo( $firstName, $lastName)
	{
		$retValue = '{"firstName":"' . $firstName . '","lastName":"' . $lastName . '","error":"","success":"Successfully logged in"}';
		sendResultInfoAsJson( $retValue );
	}
	
?>
