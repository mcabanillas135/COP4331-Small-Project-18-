<?php
	// Error Testing
	// error_reporting(E_ALL);
  // ini_set('display_errors', 'on');

	$inData = getRequestInfo();

	$id = $inData["User_Id"];

	$conn = new mysqli( "localhost", "contactmanager", "COP4331", "COP4331" );

	if( $conn->connect_error )
	{
		returnWithError( $conn->connect_error );
	}
	else
	{
		$stmt = $conn->prepare( "DELETE FROM Contact_user WHERE User_Id = ?" );
		$stmt->bind_param( "i", $id );
		$stmt->execute();
		$affectedRows = $stmt->affected_rows;
    
		if ($affectedRows > 0)
		{
			returnWithInfo($id);
		} 
   		else
		{
			returnWithError("Failed to delete user.");
		}

		$stmt1->close();
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

	function returnWithInfo( $id )
	{
		$retValue = '{"error":"","success":"Successfully deleted User_Id '. $id . '"}';
		sendResultInfoAsJson( $retValue );
	}

?>
