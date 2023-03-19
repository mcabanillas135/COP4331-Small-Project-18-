<?php
  class Contact
  {
    public $id;
    public $username;
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
  }

  // Error Testing
  error_reporting(E_ALL);
  ini_set('display_errors', 'on');

  $inData = getRequestInfo();
  $contact = new Contact();

  $contact->id = $inData["User_Id"];
  $contact->username = $inData["User_Name"];

  $conn = new mysqli("localhost", "contactmanager", "COP4331", "COP4331");

  if( $conn->connect_error )
  {
    returnWithError( $conn->connect_error );
  }
  else
  {
    $stmt = $conn->prepare( "SELECT * FROM Contact_database WHERE User_Id = ? AND User_Name = ?" );
    $stmt->bind_param("ss", $contact->id, $contact->username);
    $stmt->execute();
    $result = $stmt->get_result();

    $contacts = array();

    while( $row = $result->fetch_assoc() )
    {
      $fetchedcontact = new Contact();
      $fetchedcontact->id = $row["User_Id"];
      $fetchedcontact->username = $row["User_Name"];
      $fetchedcontact->firstname = $row["First_Name"];
      $fetchedcontact->lastname = $row["Last_Name"];
      $fetchedcontact->phone = $row["Phone"];
      $fetchedcontact->email = $row["Email"];
      $fetchedcontact->fetchedstreet = $row["Street"];
      $fetchedcontact->city = $row["City"];
      $fetchedcontact->state = $row["State"];
      $fetchedcontact->zip = $row["Zip_Code"];
      $fetchedcontact->dob = $row["DOB"];
      $fetchedcontact->datecreated = $row["Date_Created"];
      $contacts[] = $fetchedcontact;
    }

    if(count($contacts) == 0)
    {
      returnWithError("Contacts Do not exist.");
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
    $retValue = '{"First_Name":"","Last_Name":"","error":"' . $err . '"}';
    sendResultInfoAsJson( $retValue );
  }

  function returnWithInfo( $contacts )
  {
    $retValue = array();
    $retValue['success'] = 'Found ' . count($contacts) . ' contact(s).';
    $retValue['contacts'] = array();
    
    foreach ($contacts as $contact) {
      $retValue['contacts'][] = array(
        'User_Id' => $contact->id,
        'User_Name' => $contact->username,
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
