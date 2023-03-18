<?php
    class Contact
    {
      public $phone;
      public $firstname;
      public $lastname;
      public $email = "";
    }

    // Error Testing
    error_reporting(E_ALL);
    ini_set('display_errors', 'on');

    $inData = getRequestInfo();
    $contact = new contact();

    // Required Fields
    // $id = $inData["User_Id"];
    $contact->phone = $inData["Phone"];
    $contact->firstname = $inData["First_Name"];
    $contact->lastname = $inData["Last_Name"];

    // Not required Fields
    $contact->email = $inData["Email"];

    $conn = new mysqli("localhost", "contactmanager", "COP4331", "COP4331"); 	

    if( $conn->connect_error )
    {
       returnWithError( 0, $conn->connect_error );
    }
    else
    {
       $stmt = $conn->prepare("SELECT * FROM Contact_database WHERE Phone = ? AND First_Name = ? AND Last_Name = ? AND Email = ?");
       $stmt->bind_param("ssss", $contact->phone, $contact->firstname, $contact->lastname, $contact->email);
       $stmt->execute();
       $result = $stmt->get_result();

       if( $row = $result->fetch_assoc() )
       {
	       returnWithError("Failed to add contact. Contact already exists.");
       }
       else
       {
	       $stmt2 = $conn->prepare("INSERT INTO Contact_database VALUES (?, ?, ?, ?)");
	       $stmt2->bind_param("ssss", $contact->phone, $contact->firstname, $contact->lastname, $contact->email);
	       $result = $stmt2->execute();
	       
	       if ($result) 
	       {
		       returnWithInfo($contact);
	       } else
	       {
		       returnWithError("Failed to add contact");
	       }
			
	       $stmt2->close();
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
       $retValue = '{"Phone":"","First_Name":"","Last_Name":"","Email":"","error":"' . $err . '"}';
       sendResultInfoAsJson( $retValue );
    }

    function returnWithInfo( $contact ) 
    {
        $retValue = '{"Phone":"' . $contact->phone . '","First_Name":"' . $contact->firstname . '","Last_Name":"' . $contact->lastname . '","Email":"' . $contact->email . '","error":"' . $err . '"}';
        sendResultInfoAsJson( $retValue );
    }
	
?>
