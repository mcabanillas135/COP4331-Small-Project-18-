<?php
  class Contact
  {
    public $id;
    public $username;
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
  }

  // Error Testing
  // error_reporting(E_ALL);
  // ini_set('display_errors', 'on');

  $inData = getRequestInfo();
  $contact = new Contact();

  // these values are not allowed to be null
  $contact->username = $inData["User_Name"];
  $contact->firstname = $inData["FName"];
  $contact->lastname = $inData["LName"];
  $contact->phone = $inData["Phone"];
  $contact->email = $inData["Email"];
  $contact->street = $inData["Street"];
  $contact->city = $inData["City"];

  // can be null
  $contact->state = $inData["State"];

  // an int
  $contact->id = $inData["User_Id"];
  $contact->zip = $inData["Zip_Code"];

  // a Date
  $contact->dob = $inData["DOB"];
  $contact->datecreated = $inData["Date_Created"];

  $conn = new mysqli("localhost", "contactmanager", "COP4331", "COP4331");

  if( $conn->connect_error )
  {
    returnWithError( $conn->connect_error );
  }
  else
  {
    $stmt = $conn->prepare("SELECT * FROM Contact_database WHERE Phone = ? AND User_Id = ?");
    $stmt->bind_param("ss", $contact->phone, $contact->id);
    $stmt->execute();
    $result = $stmt->get_result();

    if( $row = $result->fetch_assoc() )
    {
      returnWithError("Failed to add contact. Phone Number already exists.");
    }
    else
    {
      $stmt2 = $conn->prepare("INSERT INTO Contact_database VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt2->bind_param("ssssssssssss", $contact->id, $contact->username, $contact->firstname, $contact->lastname, $contact->phone, $contact->email,
                          $contact->street, $contact->city, $contact->state, $contact->zip, $contact->dob, $contact->datecreated);
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
    $retValue = '{"User_Id":"","User_Name":"","FName":"","LName":"","Phone":"","Email":"","Street":"","City":"","State":"","Zip_Code":"","DOB":"","Date_Created":"","error":"' . $err . '"}';
    sendResultInfoAsJson( $retValue );
  }

  function returnWithInfo( $contact )
  {
    $retValue = '{"User_Id":"' . $contact->id . '","User_Name":"' . $contact->username . '","FName":"' . $contact->firstname . '","LName":"' . $contact->lastname . '","Phone":"' . $contact->phone . '","Email":"' . $contact->email . '","Street":"' . $contact->street . '","City":"' . $contact->city . '","State":"' . $contact->state . '","Zip_Code":"' . $contact->zip . '","DOB":"' . $contact->dob . '","Date_Created":"' . $contact->datecreated . '","error":"", "success":"Successfully added contact."}';
    sendResultInfoAsJson( $retValue );
  }

?>
