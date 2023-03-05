<?php

    	$inData = getRequestInfo();

    	require_once( 'db_connection.php' );
	
	$result = addUser($conn, $inData['User_Id'], $inData['User_Name'], $inData['Password']);

	if ($result) 
	{
	    returnWithInfo($inData['User_Name'], $inData['User_Id']);
	} else
	{
	    returnWithError("Failed to add user");
	}

	$conn->close();
   	
    
    function addUser($conn, $id, $username, $password)
    {
        $stmt = $conn->prepare("SELECT * FROM Contact_User WHERE User_Id = ? OR User_Name = ?");
   	$stmt->bind_param("ss", $id, $username);
   	$stmt->execute();
    	$result = $stmt->get_result();
   	$stmt->close();
        
        if(!$result || $result->num_rows > 0)
        {
           return false;  
        }
        
        $stmt = $conn->prepare("INSERT INTO Contact_User VALUES (?, ?, ?)");
	$stmt->bind_param("sss", $id, $username, $password);
	$result = $stmt->execute();
        $stmt->close();
        
        return $result
    }

    function sendResultInfoAsJson( $obj )
	{
		// Lets the receiver/sender know the data type
		header('Content-type: application/json');
		echo $obj;
	}
                
    function getRequestInfo() {
        return json_decode(file_get_contents('php://input'), true);   
    }

    function returnWithError( $err )
	{
		http_response_code(400);
	    	$retValue = 
			[        
				'User_Id' => 0,
				'User_Name' => '',
				'Password' => '',
				'error' => $err 
			];
		sendResultInfoAsJson( json_encode($retValue) );
	}
                
    function returnWithInfo( $username, $id )
	{
		// Print a success
		http_response_code(200);
	    	$retValue =
			[
				'User_Id' => $id,
				'User_Name' => $username,
				'error' => 'none'
			];
		sendResultInfoAsJson( json_encode($retValue) );
	}

?>
