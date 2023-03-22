<?php
	// Error Testing
	// error_reporting(E_ALL);
  // ini_set('display_errors', 'on');

	$inData = getRequestInfo();

	$id = $inData["User_Id"];
	$password = $inData["Password"];

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
			$stmt2 = $conn->prepare( "UPDATE Contact_user SET Password = ? WHERE User_Id = ?" );
      $stmt2->bind_param( "si", $password, $id );
      $stmt2->execute();
      $affectedRows = $stmt2->affected_rows;

      if ($affectedRows > 0)
      {
        returnWithInfo( $id, $password );
      }
      else
      {

        returnWithError( "Failed to edit password" );

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
		$retValue = '{"User_Id":"","Password":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

	function returnWithInfo( $id, $pass )
	{
		$retValue = '{"User_Id":"' . $id . '","Password":"' . $pass . '","error":"","success":"Successfully edited password."}';
		sendResultInfoAsJson( $retValue );
	}

?>
