<?php
    	$inData = getRequestInfo();
	
	$id = 0;
	$username = $inData["User_Name"];
	$password = $inData["Password"];
	
    	$conn = new mysqli("localhost", "contactmanager", "COP4331", "COP4331"); 	

	if( $conn->connect_error )
	{
		returnWithError( $conn->connect_error );
	}
	else
	{
		$stmt = $conn->prepare("SELECT * FROM Contact_User WHERE User_Name = ?");
   		$stmt->bind_param("s", $username);
   		$stmt->execute();
    		$result = $stmt->get_result();
		$stmt->close();
		
		if($result->num_rows > 0)
        	{
          		return returnWithError("Failed to add user. User already exists.");  
        	}
		
		$stmt = $conn->prepare("INSERT INTO Contact_User VALUES (?, ?)");
		$stmt->bind_param("ss", $username, $password);
		$result = $stmt->execute();
        	
		if ($result) 
		{
		    returnWithInfo($username, $password);
		} else
		{
		    returnWithError("Failed to add user");
		}
		
		$stmt->close();
		$conn->close();
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
	    	$retValue = '{"User_Name":"","Password":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
                
    function returnWithInfo( $username, $password )
	{
		// Print a success
	    	$retValue = $retValue = '{"User_Name":"' . $username . '","Password":"' . $password . '","error":"","success":"Successfully created user"}';
		sendResultInfoAsJson( $retValue );
	}

?>
