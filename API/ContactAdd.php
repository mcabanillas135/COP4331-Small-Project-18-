<?php
    class Contact
    {
      public $username;
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
    $contact->username = $inData["User_Name"];
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
       $stmt = $conn->prepare("SELECT * FROM Contact_user WHERE User_Name = ? AND Password = ?");
       $stmt->bind_param("ss", $username, $password);
       $stmt->execute();
       $result = $stmt->get_result();

       if( $row = $result->fetch_assoc() )
       {
           returnWithInfo($row['User_Name'], $row['Password']);
       }
       else
       {
           returnWithError("No Records Found");
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
       $retValue = '{"Contact User":"","Phone":"","First_Name":"","Last_Name":"","Email":"","error":"' . $err . '"}';
       sendResultInfoAsJson( $retValue );
    }

    function returnWithInfo( $contact ) 
    {
        $retValue = '{"Contact User":"' . $contact->username . '","Phone":"' . $contact->phone . '","First_Name":"' . $contact->firstname . '","Last_Name":"' . $contact->lastname . '","Email":"' . $contact->email . '","error":"' . $err . '"}';
        sendResultInfoAsJson( $retValue );
    }
	
?>
