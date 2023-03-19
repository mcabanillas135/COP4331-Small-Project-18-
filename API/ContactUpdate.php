<?php
	// Error Testing
	//error_reporting(E_ALL);
	//ini_set('display_errors', 'on');

	class Contact
  {
    public $firstname;
    public $lastname;
    public $phone;
    public $email;
    public $street = "";
    public $city = "";
    public $state = "";
    public $zip = "";
    public $dob = "";
  }

	$conn = new mysqli("localhost", "contactmanager", "COP4331", "COP4331");

  $inData = getRequestInfo();
  $contact = new Contact();

  $id = $inData["User_Id"];

  // these values are not allowed to be null
  $contact->firstname = $inData["FName"];
  $contact->lastname = $inData["LName"];
  $contact->phone = $inData["Phone"];
  $contact->email = $inData["Email"];
  $contact->street = $inData["Street"];
  $contact->city = $inData["City"];

  // can be null
  $contact->state = $inData["State"];

  // an int
  $contact->zip = $inData["Zip_Code"];

  // a Date
  $contact->dob = $inData["DOB"];

	if( $conn->connect_error )
	{
		returnWithError( $conn->connect_error );
	}
	else
	{

		$stmt1 = $conn->prepare("UPDATE Contacts SET FName = ?, LName = ?, Phone = ?, Email = ?, Street = ?, City = ?, State = ?, Zip_Code = ?, DOB = ? WHERE User_Id = ?");
		$stmt1->bind_param("sssssssssi", $contact->firstname, $contact->lastname, $contact->phone, $contact->email, $contact->street, $contact->city, $contact->state, $contact->zip, $contact->dob, $id);
		$stmt1->execute();
		$result = $stmt1->get_result();
    
			if ($result)
			{
				returnWithInfo($contact, $id);
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
		$retValue = '{"User_Id":"","FName":"","LName":"","Phone":"","Email":"","Street":"","City":"","State":"","Zip_Code":"","DOB":"","Date_Created":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

	function returnWithInfo($contact, $id)
	{
		$retValue = '{"User_Id":"' . $id . '","FName":"' . $contact->firstname . '","LName":"' . $contact->lastname . '","Phone":"' . $contact->phone . '","Email":"' . $contact->email . '","Street":"' . $contact->street . '","City":"' . $contact->city . '","State":"' . $contact->state . '","Zip_Code":"' . $contact->zip . '","DOB":"' . $contact->dob . '","Date_Created":"' . $contact->datecreated . '","error":"", "success":"Successfully updated contact."}';
    sendResultInfoAsJson( $retValue );
  }

?>

		sendResultInfoAsJson( $retValue );
	}

?>
