<?php

    $inData = getRequestInfo();

    require_once( 'db_connection.php' );

	if( !$conn->connect_error ) 
    {
        $result = addUser($conn, $inData['User_Id'], $inData['User_Name'], $inData['Password']);
        
        if ($result) 
        {
            returnWithInfo($inData['User_name'], $inData['User_Id']);
        } else
        {
            returnWithError("Failed to add user");
        }
        
        $conn->close();
    }
    
    function addUser($conn, $id, $username, $password)
    {
        $sqlSelect = "SELECT * FROM Contact_User WHERE User_Id = '$id'";
        $result = $conn->query($sqlSelect);
        
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
		$retValue = '{"User_Id":0,"User_Name":"","Password":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
                
    function returnWithInfo( $newUser, $id )
	{
		// Print a success
		http_response_code(200);
		$retValue = '{"User_Id":' . $id . ',"User_Name":"' . $user_name . '","error":"none"}';
		sendResultInfoAsJson( $retValue );
	}

?>
