<?php
    class Contact
    {
      public $firstname;
      public $lastname;
    }

    // Error Testing
    error_reporting(E_ALL);
    ini_set('display_errors', 'on');

    $inData = getRequestInfo();
    $contact = new Contact();

    // Required Fields
    $contact->firstname = $inData["First_Name"];
    $contact->lastname = $inData["Last_Name"];

    $conn = new mysqli("localhost", "contactmanager", "COP4331", "COP4331"); 	

    if( $conn->connect_error )
    {
       returnWithError( $conn->connect_error );
    }
    else
    {
       $stmt = $conn->prepare("SELECT * FROM Contact_database WHERE First_Name = ? AND Last_Name = ?");
       $stmt->bind_param("ss", $contact->firstname, $contact->lastname);
       $stmt->execute();
       $result = $stmt->get_result();

       if( $row = $result->fetch_assoc() )
       {
		returnWithInfo($contact);
       }
       else
       {
       		returnWithError("Contact does not exist.");
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
       $retValue = '{"First_Name":"","Last_Name":"","error":"' . $err . '"}';
       sendResultInfoAsJson( $retValue );
    }

    function returnWithInfo( $contact ) 
    {
        $retValue = '{"First_Name":"' . $contact->firstname . '","Last_Name":"' . $contact->lastname . '","error":"","success":"Found Contact."}';
        sendResultInfoAsJson( $retValue );
    }
	
?>
