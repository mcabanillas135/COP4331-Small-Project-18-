<?php
	// Error Testing
	//error_reporting(E_ALL);
	//ini_set('display_errors', 'on');

	$inData = getRequestInfo();

	$contactid = $inData["Contact_Id"];

	$conn = new mysqli("localhost", "contactmanager", "COP4331", "COP4331");

	if( $conn->connect_error )
	{
		returnWithError( $conn->connect_error );
	}
	else
	{

		$stmt1 = $conn->prepare("DELETE FROM Contact_database WHERE Contact_Id = ?");
		$stmt1->bind_param("i", $contactid);
		$stmt1->execute();
		$affectedRows = $stmt1->affected_rows;
    
		if ($affectedRows > 0)
		{
			returnWithInfo($contactid);
		} else
		{
			returnWithError("Failed to delete contact.");
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
		$retValue = '{"User_Id":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

	function returnWithInfo( $id )
	{
		$retValue = '{"User_Id":"' . $id . '","error":"","success":"Successfully deleted contact."}';
		sendResultInfoAsJson( $retValue );
	}

?>
