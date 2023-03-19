<?php
	// Error Testing
	//error_reporting(E_ALL);
	//ini_set('display_errors', 'on');

	class Contact
  {
    public $firstname;
    public $lastname;
    public $email;
    public $street = "";
    public $city = "";
    public $state = "";
    public $zip = "";
    public $dob = "";
  }

  $inData = getRequestInfo();
  $contact = new Contact();

  $phone = $inData["Phone"];

  // these values are not allowed to be null
  $contact->firstname = $inData["FName"];
  $contact->lastname = $inData["LName"];
  $contact->email = $inData["Email"];
  $contact->street = $inData["Street"];
  $contact->city = $inData["City"];

  // can be null
  $contact->state = $inData["State"];

  // an int
  $contact->zip = $inData["Zip_Code"];

  // a Date
  $contact->dob = $inData["DOB"];

  $conn = new mysqli("localhost", "contactmanager", "COP4331", "COP4331");

	if( $conn->connect_error )
	{
		returnWithError( $conn->connect_error );
	}
	else
	{

		$stmt1 = $conn->prepare("UPDATE Contact_database SET FName = ?, LName = ?, Email = ?, Street = ?, City = ?, State = ?, Zip_Code = ?, DOB = ? WHERE Phone = ?");
		$stmt1->bind_param("sssssssss", $contact->firstname, $contact->lastname, $contact->email, $contact->street, $contact->city, $contact->state, $contact->zip, $contact->dob, $phone);
		$stmt1->execute();
		$affectedRows = $stmt1->affected_rows;
    
			if ($affectedRows > 0)
			{
				returnWithInfo($contact, $phone);
			} else
			{
				returnWithError("Failed to update contact.");
			}

		$stmt1->close();
		$conn->close();
	}

	function sendResultInfoAsJson( $obj )
	{
		// Lets the receiver/sender know the data type
		header('Content-type: application/json');
		echo $obj;
	}

	function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	function returnWithError( $err )
	{
		$retValue = '{"FName":"","LName":"","Phone":"","Email":"","Street":"","City":"","State":"","Zip_Code":"","DOB":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

	function returnWithInfo($contact, $phone)
	{
		$retValue = '{"FName":"' . $contact->firstname . '","LName":"' . $contact->lastname . '","Phone":"' . $phone . '","Email":"' . $contact->email . '","Street":"' . $contact->street . '","City":"' . $contact->city . '","State":"' . $contact->state . '","Zip_Code":"' . $contact->zip . '","DOB":"' . $contact->dob . '","error":"", "success":"Successfully updated contact."}';
    		sendResultInfoAsJson( $retValue );
  	}

?>
