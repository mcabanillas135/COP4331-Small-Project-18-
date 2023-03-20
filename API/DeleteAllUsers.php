<?php
	// Error Testing
	// error_reporting(E_ALL);
  // ini_set('display_errors', 'on');

	$conn = new mysqli( "localhost", "contactmanager", "COP4331", "COP4331" );

	if( $conn->connect_error )
	{
		returnWithError( $conn->connect_error );
	}
	else
	{
		$stmt = $conn->prepare( "DELETE FROM Contact_user" );

		if($stmt->execute())
		{
				returnWithSuccess();
		}
		else
		{
				returnWithError( "Failed to delete all users" );
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
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

	function returnWithSuccess()
	{
		$retValue = '{"success":"All users deleted"}';
		sendResultInfoAsJson( $retValue );
	}

?>
