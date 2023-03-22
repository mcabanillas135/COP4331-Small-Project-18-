<?php
	// Error Testing
	//error_reporting(E_ALL);
	//ini_set('display_errors', 'on');

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

	$inData = getRequestInfo();
	$contact = new Contact();

	$contact->userid = $inData["User_Id"];
	$contact->contactid = $inData["Contact_Id"];
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

	$conn = new mysqli( "localhost", "contactmanager", "COP4331", "COP4331" );

	if( $conn->connect_error )
	{
		returnWithError( $conn->connect_error );
	}
	else
	{
		$stmt = $conn->prepare( "SELECT * FROM Contact_database WHERE Contact_Id = ?" );
		$stmt->bind_param( "i", $contact->contactid );
		$stmt->execute();
		$result = $stmt->get_result();
		
		if ( $row = $result->fetch_assoc() )
		{
			$stmt2 = $conn->prepare( "UPDATE Contact_database SET FName = ?, LName = ?, Email = ?, Phone = ?, Street = ?, City = ?, State = ?, Zip_Code = ?, DOB = ? WHERE Contact_Id = ?" );
			$stmt2->bind_param( "sssssssisi", $contact->firstname, $contact->lastname, $contact->email, $contact->phone, $contact->street, $contact->city, $contact->state, $contact->zip, $contact->dob, $contact->contactid);
			$stmt2->execute();
			$affectedRows = $stmt2->affected_rows;

			if ($affectedRows > 0)
			{
				returnWithInfo($contact);
			} 
			else
			{
				returnWithError("Failed to update contact.");
			}

			$stmt2->close();		
		}
		else
		{
			returnWithError( "Contact not found" );	
		}
		
		
		$stmt->close();
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
   		$retValue = '{"User_Id":"","Contact_Id":"","FName":"","LName":"","Phone":"","Email":"","Street":"","City":"","State":"","Zip_Code":"","DOB":"","Date_Created":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

	function returnWithInfo( $contact )
	{
    		$retValue = '{"User_Id":"' . $contact->userid . '","Contact_Id":"' . $contact->contactid . '","FName":"' . $contact->firstname . '","LName":"' . $contact->lastname . '","Phone":"' . $contact->phone . '","Email":"' . $contact->email . '","Street":"' . $contact->street . '","City":"' . $contact->city . '","State":"' . $contact->state . '","Zip_Code":"' . $contact->zip . '","DOB":"' . $contact->dob . '","Date_Created":"' . $contact->datecreated . '","error":"", "success":"Successfully updated contact."}';
		sendResultInfoAsJson( $retValue );
	}

?>
