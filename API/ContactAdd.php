<?php
  class Contact
  {
    public $userid;
    public $firstname;
    public $lastname;
    public $phone;
    public $email;
    public $street = "";
    public $city = "";
    public $state = "";
    public $zip = "";
    public $dob = "";
    public $datecreated;
    public $contactid;
  }

  // Error Testing
  // error_reporting(E_ALL);
  // ini_set('display_errors', 'on');

  $inData = getRequestInfo();
  $contact = new Contact();

  $contact->userid = $inData["User_Id"];
  $contact->firstname = $inData["FName"];
  $contact->lastname = $inData["LName"];
  $contact->phone = $inData["Phone"];
  $contact->email = $inData["Email"];
  $contact->street = $inData["Street"];
  $contact->city = $inData["City"];
  $contact->state = $inData["State"];
  $contact->zip = $inData["Zip_Code"];
  $contact->dob = $inData["DOB"];
  $contact->datecreated = $inData["Date_Created"];

  $conn = new mysqli("localhost", "contactmanager", "COP4331", "COP4331");

  if( $conn->connect_error )
  {
    returnWithError( $conn->connect_error );
  }
  else
  {
    $stmt = $conn->prepare("INSERT INTO Contact_database VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssssiss", $contact->userid, $contact->firstname, $contact->lastname, $contact->phone, $contact->email,
                        $contact->street, $contact->city, $contact->state, $contact->zip, $contact->dob, $contact->datecreated);
    $result = $stmt->execute();
    $contact->contactid = $stmt->insert_id;
    
    if ($result)
    {
      returnWithInfo($contact);
    } 
    else
    {
      returnWithError("Failed to add contact");
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
    $retValue = '{"User_Id":"","Contact_Id":"","FName":"","LName":"","Phone":"","Email":"","Street":"","City":"","State":"","Zip_Code":"","DOB":"","Date_Created":"","error":"' . $err . '"}';
    sendResultInfoAsJson( $retValue );
  }

  function returnWithInfo( $contact )
  {
    $retValue = '{"User_Id":"' . $contact->userid . '","Contact_Id":"' . $contact->contactid . '","FName":"' . $contact->firstname . '","LName":"' . $contact->lastname . '","Phone":"' . $contact->phone . '","Email":"' . $contact->email . '","Street":"' . $contact->street . '","City":"' . $contact->city . '","State":"' . $contact->state . '","Zip_Code":"' . $contact->zip . '","DOB":"' . $contact->dob . '","Date_Created":"' . $contact->datecreated . '","error":"", "success":"Successfully added contact."}';
    sendResultInfoAsJson( $retValue );
  }

?>
