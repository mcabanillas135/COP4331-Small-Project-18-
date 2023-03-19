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
  // error_reporting(E_ALL);
  // ini_set('display_errors', 'on');

  $inData = getRequestInfo();
  $querycontact = new Contact();

  $querycontact->id = $inData["User_Id"];
  $querycontact->phone = $inData["Phone"];

  $conn = new mysqli("localhost", "contactmanager", "COP4331", "COP4331");

  if( $conn->connect_error )
  {
    returnWithError( $conn->connect_error );
  }
  else
  {
    $stmt = $conn->prepare( "SELECT * FROM Contact_database WHERE User_Id = ? AND Phone = ? LIMIT 1" );
    $stmt->bind_param("ss", $querycontact->id, $querycontact->phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if( $row = $result->fetch_assoc() )
    {
      $fetchedcontact = new Contact();
      $fetchedcontact->id = $row["User_Id"];
      $fetchedcontact->username = $row["User_Name"];
      $fetchedcontact->firstname = $row["FName"];
      $fetchedcontact->lastname = $row["LName"];
      $fetchedcontact->phone = $row["Phone"];
      $fetchedcontact->email = $row["Email"];
      $fetchedcontact->fetchedstreet = $row["Street"];
      $fetchedcontact->city = $row["City"];
      $fetchedcontact->state = $row["State"];
      $fetchedcontact->zip = $row["Zip_Code"];
      $fetchedcontact->dob = $row["DOB"];
      $fetchedcontact->datecreated = $row["Date_Created"];
      returnWithInfo($fetchedcontact);
    }
    else
    {
      returnWithError("Contacts Do not exist.");
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
    $retValue = '{"User_Id":"","User_Name":"","FName":"","LName":"","Phone":"","Email":"","Street":"","City":"","State":"","Zip_Code":"","DOB":"","Date_Created":"","error":"' . $err . '"}';
    sendResultInfoAsJson( $retValue );
  }

  function returnWithInfo( $contact )
  {
    $retValue = '{"User_Id":"' . $contact->id . '","User_Name":"' . $contact->username . '","FName":"' . $contact->firstname . '","LName":"' . $contact->lastname . '","Phone":"' . $contact->phone . '","Email":"' . $contact->email . '","Street":"' . $contact->street . '","City":"' . $contact->city . '","State":"' . $contact->state . '","Zip_Code":"' . $contact->zip . '","DOB":"' . $contact->dob . '","Date_Created":"' . $contact->datecreated . '","error":"", "success":"Successfully added contact."}';
    sendResultInfoAsJson( $retValue );
  }

?>
