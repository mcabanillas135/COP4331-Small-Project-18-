<?php
	// Error Testing
	error_reporting(E_ALL);
  	ini_set('display_errors', 'on');

	$inData = getRequestInfo();

	$id = $inData["User_Id"];
	$username = $inData["User_Name"];

	$conn = new mysqli( "localhost", "contactmanager", "COP4331", "COP4331" );

	if( $conn->connect_error )
	{
		returnWithError( $conn->connect_error );
	}
	else
	{
		$stmt = $conn->prepare( "SELECT * FROM Contact_user WHERE User_Id = ?" );
		$stmt->bind_param( "i", $id );
		$stmt->execute();
		$result = $stmt->get_result();
		if ( $row = $result->fetch_assoc() )
		{
			$stmt2 = $conn->prepare( "SELECT * FROM Contact_user WHERE User_Name = ?" );
			$stmt2->bind_param( "s", $username );
			$stmt2->execute();
			$result = $stmt2->get_result();

			if ( $row = $result->fetch_assoc() )
			{
				returnWithError( "That username is already in use" );
			}
			else
			{
				$stmt3 = $conn->prepare( "UPDATE Contact_user SET User_Name = ? WHERE User_Id = ?" );
				$stmt3->bind_param( "si", $username, $id );
				$stmt3->execute();
				$affectedRows = $stmt3->affected_rows;

				if ($affectedRows > 0)
				{
					returnWithInfo( $id, $username );
				}
				else
				{

					returnWithError( "Failed to edit username" );

				}	

				$stmt3->close();
			}


			$stmt2->close();	
		}
		else
		{
			returnWithError( "User_Id not found" );	
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
		$retValue = '{"User_Id":"","User_Name":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

	function returnWithInfo( $id, $user )
	{
		$retValue = '{"User_Id":"' . $id . '","User_Name":"' . $user . '","error":"","success":"Successfully edited username."}';
		sendResultInfoAsJson( $retValue );
	}

?>
