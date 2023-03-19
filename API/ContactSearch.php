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
  error_reporting(E_ALL);
  ini_set('display_errors', 'on');

  $inData = getRequestInfo();
  $contact = new Contact();

  // Required Fields
  $contact->id = $inData["User_Id"];
  $contact->username = $inData["User_Name"];
  $contact->firstname = $inData["FName"];
  $contact->lastname = $inData["LName"];

  $conn = new mysqli("localhost", "contactmanager", "COP4331", "COP4331");

  if( $conn->connect_error )
  {
    returnWithError( $conn->connect_error );
  }
  else
  {
    $stmt = $conn->prepare("SELECT * FROM Contact_database WHERE User_Id = ? AND User_Name = ? AND (FName LIKE ? OR LName Like ?)");
    $stmt->bind_param("ssss", $contact->id, $contact->username, "%" . $contact->firstname . "%", "%" . $contact->lastname . "%");
    $stmt->execute();
    $result = $stmt->get_result();

    $counter = 0;

    while( $row = $result->fetch_assoc() )
    {
      $counter = counter + 1;
      $contact->firstname = $row["FName"];
      $contact->lastname = $row["LName"];
      $contact->phone = $row["Phone"];
      $contact->email = $row["Email"];
      $contact->street = $row["Street"];
      $contact->city = $row["City"];
      $contact->state = $row["State"];
      $contact->zip = $row["Zip_Code"];
      $contact->dob = $row["DOB"];
      $contact->datecreated = $row["Date_Created"];

      returnWithInfo($contact);
    }

    if($counter == 0)
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
    $retValue = '{"User_Id":"' . $contact->id . '","User_Name":"' . $contact->username . '","FName":"' . $contact->firstname . '","LName":"' . $contact->lastname . '","Phone":"' . $contact->phone . '","Email":"' . $contact->email . '","Street":"' . $contact->street . '","City":"' . $contact->city . '","State":"' . $contact->state . '","Zip_Code":"' . $contact->zip . '","DOB":"' . $contact->dob . '","Date_Created":"' . $contact->datecreated . '"}';
    sendResultInfoAsJson( $retValue );
  }

?>
