<?php
    class Contact
    {
	public $phone;
	public $firstname;
	public $lastname;
	public $email = "";
	public $datecreated;
    }

    // Error Testing
    error_reporting(E_ALL);
    ini_set('display_errors', 'on');

    $inData = getRequestInfo();
    $contact = new contact();

    // Required Fields
    $contact->phone = $inData["Phone"];
    $contact->firstname = $inData["First_Name"];
    $contact->lastname = $inData["Last_Name"];
    $contact->email = $inData["Email"];
    $contact->datecreated = $inData["Date_Created"];
	
    $conn = new mysqli("localhost", "contactmanager", "COP4331", "COP4331"); 	

    if( $conn->connect_error )
    {
       returnWithError( $conn->connect_error );
    }
    else
    {
       $stmt = $conn->prepare("SELECT * FROM Contact_database WHERE Phone = ? OR Email = ?");
       $stmt->bind_param("ss", $contact->phone, $contact->email);
       $stmt->execute();
       $result = $stmt->get_result();

       if( $row = $result->fetch_assoc() )
       {
	       returnWithError("Failed to add contact. Phone Number or Email already exists.");
       }
       else
       {
	       $stmt2 = $conn->prepare("INSERT INTO Contact_database VALUES (?, ?, ?, ?, ?)");
	       $stmt2->bind_param("sssss, $contact->phone, $contact->firstname, $contact->lastname, $contact->email, $contact->datecreated";
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
        $retValue = '{"Phone":"' . $contact->phone . '","First_Name":"' . $contact->firstname . '","Last_Name":"' . $contact->lastname . '","Email":"' . $contact->email . '","Date created":"' . $contact->datecreated .'","error":"", "success":"Successfully added contact."}';
        sendResultInfoAsJson( $retValue );
    }
	
?>
