<?php
  class Contact
  {
    public $userid;
    public $firstname;
    public $lastname;
    public $phone;
    public $email;
    public $street;
    public $city;
    public $state;
    public $zip;
    public $dob;
    public $datecreated;
    public $contactid;
  }

  // Error Testing
  // error_reporting(E_ALL);
  // ini_set('display_errors', 'on');

  $inData = getRequestInfo();
  $contact = new Contact();

  // Required Fields
  $contact->id = $inData["User_Id"];
  $contact->firstname = $inData["FName"];
  $contact->lastname = $inData["LName"];

  $conn = new mysqli( "localhost", "contactmanager", "COP4331", "COP4331" );

  if( $conn->connect_error )
  {
    returnWithError( $conn->connect_error );
  }
  else
  {
    $firstnamepattern = "%" . $contact->firstname . "%";
    $lastnamepattern = "%" . $contact->lastname . "%";
    $stmt = $conn->prepare( "SELECT * FROM Contact_database WHERE User_Id = ? AND (FName LIKE ? OR LName Like ?)" );
    $stmt->bind_param("iss", $contact->userid, $firstnamepattern, $lastnamepattern);
    $stmt->execute();
    $result = $stmt->get_result();

    $contacts = array();

    while( $row = $result->fetch_assoc() )
    {
      $tmp = new Contact();
      $tmp->userid = $row["User_Id"];
      $tmp->contactid = $row["Contact_Id"];
      $tmp->firstname = $row["FName"];
      $tmp->lastname = $row["LName"];
      $tmp->phone = $row["Phone"];
      $tmp->email = $row["Email"];
      $tmp->street = $row["Street"];
      $tmp->city = $row["City"];
      $tmp->state = $row["State"];
      $tmp->zip = $row["Zip_Code"];
      $tmp->dob = $row["DOB"];
      $tmp->datecreated = $row["Date_Created"];
      $contacts[] = $tmp;
    }
    
    if( count($contacts) == 0 )
    {
      returnWithError("Contact(s) not found.");
    }
    else
    {
      returnWithInfo($contacts); 
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

  function returnWithInfo( $contacts )
  {
    $retValue = array();
    $retValue['success'] = 'Found ' . count($contacts) . ' contact(s).';
    $retValue['contacts'] = array();
    
    foreach ($contacts as $contact) {
      $retValue['contacts'][] = array(
        'User_Id' => $contact->userid,
        'Contact_Id' => $contact->contactid,
        'FName' => $contact->firstname,
        'LName' => $contact->lastname,
        'Phone' => $contact->phone,
        'Email' => $contact->email,
        'Street' => $contact->street,
        'City' => $contact->city,
        'State' => $contact->state,
        'Zip_Code' => $contact->zip,
        'DOB' => $contact->dob,
        'Date_Created' => $contact->datecreated,
      );
    }
    
    sendResultInfoAsJson( json_encode($retValue) );
  }

?>
