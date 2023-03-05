<?php

	$inData = getRequestInfo();

	require_once('db_connection.php');
	
	if( !$conn->connect_error )
	{
		$user_info = getUserInfo($conn, $inData['User_Name'], $inData['Password']);

		if ($user_info) {
			returnWithInfo($user_info['user_name'], $user_info['password'], $user_info['user_id']);
		} else {
			returnWithError("No Records Found");
		}
		
		$conn->close();
	}

	function getUserInfo($conn, $username, $password) {
		$stmt = $conn->prepare("SELECT * FROM Contact_User WHERE User_Name = ? AND Password = ?");
		$stmt->bind_param("ss", $username, $password);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($row = $result->fetch_assoc()) {
			return [
				'user_name' => $row['User_Name'],
				'password' => $row['Password'],
				'user_id' => $row['User_Id']
			];
		} else {
			return null;
		}

		$stmt->close();
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
		$retValue = '{"User_Id":0,"User_Name":"","Password":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
	function returnWithInfo( $user_name, $password, $id )
	{
		$retValue = '{"User_Id":' . $id . ',"User_Name":"' . $user_name . '","Password":"' . $password . '","error":""}';
		sendResultInfoAsJson( $retValue );
	}
	
?>
