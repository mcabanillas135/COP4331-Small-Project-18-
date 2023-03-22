<?php
	// Error Testing
	error_reporting(E_ALL);
  	ini_set('display_errors', 'on');

	$inData = getRequestInfo();

	$id = $inData["User_Id"];
	$username = $inData["User_Name"];
	$password = $inData["Password"];

	$conn = new mysqli( "localhost", "contactmanager", "COP4331", "COP4331" );

	if( $conn->connect_error )
	{
		returnWithError( $conn->connect_error );
	}
	else
	{
		$stmt= $conn->prepare( "SELECT * FROM Contact_user WHERE User_Name = ?" );
		$stmt->bind_param( "s", $username );
		$stmt->execute();
		$result = $stmt->get_result();
		
		if ( $row = $result->fetch_assoc() )
		{
			returnWithError( "That username is already in use" );
		}
		else
		{
			$stmt2 = $conn->prepare( "UPDATE Contact_user SET User_Name = ?, Password = ? WHERE User_Id = ?" );
			$stmt2->bind_param( "ssi", $username, $password, $id );
			$stmt2->execute();
			$affectedRows = $stmt2->affected_rows;

			if ($affectedRows > 0)
			{
				returnWithInfo($id, $username, $password);
			}
			else
			{
				$stmt3 = $conn->prepare( "SELECT * FROM Contact_user WHERE User_Id = ?" );
				$stmt3->bind_param( "i", $id );
				$stmt3->execute();
				$result = $stmt3->get_result();
				
				if ($result->num_rows == 0)
				{
					returnWithError( "User not found." );
				}
				else
				{
					returnWithError( "Failed to edit user" );
				}
				
				$stmt3->close();
			}	
			
			$stmt2->close();
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
		$retValue = '{"User_Id":"","User_Name":"","Password":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

	function returnWithInfo( $id, $user, $pass )
	{
		$retValue = '{"User_Id":"' . $id . '","User_Name":"' . $user . '","Password":"' . $pass . '","error":"","success":"Successfully edited user"}';
		sendResultInfoAsJson( $retValue );
	}

?>
