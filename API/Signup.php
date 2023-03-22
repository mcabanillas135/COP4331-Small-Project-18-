<?php
	// Error Testing
	// error_reporting(E_ALL);
	// ini_set('display_errors', 'on');

	$inData = getRequestInfo();

	$username = $inData["User_Name"];
	$password = $inData["Password"];

	$conn = new mysqli("localhost", "contactmanager", "COP4331", "COP4331");

	if( $conn->connect_error )
	{
		returnWithError( $conn->connect_error );
	}
	else
	{
		if(!$username || !$password)
		{
			returnWithError("Empty User");
		}

		$stmt1 = $conn->prepare("SELECT * FROM Contact_user WHERE User_Name = ?");
		$stmt1->bind_param("s", $username);
		$stmt1->execute();
		$result = $stmt1->get_result();


		if( $row = $result->fetch_assoc() )
		{
			returnWithError("Failed to add user. Username already exists.");
		}
		else
		{
			$stmt2 = $conn->prepare("INSERT INTO Contact_user (User_Name, Password) VALUES (?, ?)");
			$stmt2->bind_param("ss", $username, $password);
			$result = $stmt2->execute();
			$id = $stmt2->insert_id;

			if ($result)
			{
				returnWithInfo($id, $username, $password);
			} else
			{
				returnWithError("Failed to add user");
			}

			$stmt2->close();
		}

		$stmt1->close();
		$conn->close();
	}

	function sendResultInfoAsJson( $obj )
	{
		// Lets the receiver/sender know the data type
		header('Content-type: application/json');
		echo $obj;
	}

	function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	function returnWithError( $err )
	{
		$retValue = '{"User_Name":"","Password":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

	function returnWithInfo( $id, $user, $pass )
	{
		$retValue = '{"User_Id":"' . $id . '","User_Name":"' . $user . '","Password":"' . $pass . '","error":"","success":"Successfully created user"}';
		sendResultInfoAsJson( $retValue );
	}

?>
