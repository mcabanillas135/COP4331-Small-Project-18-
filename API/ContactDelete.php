<?php
	// Error Testing
	error_reporting(E_ALL);
	ini_set('display_errors', 'on');

	$inData = getRequestInfo();

	$id = $inData["User_Id"];

	$conn = new mysqli("localhost", "contactmanager", "COP4331", "COP4331");

	if( $conn->connect_error )
	{
		returnWithError( $conn->connect_error );
	}
	else
	{

		$stmt1 = $conn->prepare("DELETE FROM Contact_database WHERE User_Id = ?");
		$stmt1->bind_param("i", $id);
		$stmt1->execute();
		$result = $stmt1->get_result();
    
			if ($result)
			{
				returnWithInfo($id);
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

	function returnWithInfo($id)
	{
		$retValue = '{"User_Id":"' . $id . '","error":"","success":"Successfully deleted contact."}';
		sendResultInfoAsJson( $retValue );
	}

?>
