<?php
	// Error Testing
	//error_reporting(E_ALL);
	//ini_set('display_errors', 'on');

	$inData = getRequestInfo();

	$phone = $inData["Phone"];

	$conn = new mysqli("localhost", "contactmanager", "COP4331", "COP4331");

	if( $conn->connect_error )
	{
		returnWithError( $conn->connect_error );
	}
	else
	{

		$stmt1 = $conn->prepare("DELETE FROM Contact_database WHERE Phone = ?");
		$stmt1->bind_param("s", $phone);
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
		$retValue = '{"Phone":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

	function returnWithInfo($id)
	{
		$retValue = '{"Phone":"' . $phone . '","error":"","success":"Successfully deleted contact."}';
		sendResultInfoAsJson( $retValue );
	}

?>
