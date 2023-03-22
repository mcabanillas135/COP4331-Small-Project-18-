<?php
  // Error Testing
  // error_reporting(E_ALL);
  // ini_set('display_errors', 'on');
  class User
  {
    public $id;
    public $user;
    public $pass;
  }

  $inData = getRequestInfo();

  $conn = new mysqli( "localhost", "contactmanager", "COP4331", "COP4331" );

  if( $conn->connect_error )
  {
    returnWithError( $conn->connect_error );
  }
  else
  {
    $stmt = $conn->prepare( "SELECT * FROM Contact_user" );
    $stmt->execute();
    $result = $stmt->get_result();

    $users = array();

    while( $row = $result->fetch_assoc() )
    {
      $user = new User();
      $user->id = $row["User_Id"];
      $user->user = $row["User_Name"];
      $user->pass = $row["Password"];
      $users[] = $user;
    }

    if( count($users) == 0 )
    {
      returnWithError("No users found.");
    }
    else
    {
      returnWithInfo( $users );  
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
		$retValue = '{"User_Id":"","User_Name":"","Password":"","error":"' . $err . '"}';
    sendResultInfoAsJson( $retValue );
  }

  function returnWithInfo( $users )
  {
    $retValue = array();
    $retValue['success'] = 'Found ' . count($users) . ' user(s).';
    $retValue['users'] = array();
    
    foreach ($users as $user) {
      $retValue['contacts'][] = array(
        'User_Id' => $user->id,
        'User_Name' => $user->user,
        'Password' => $user->pass,
      );
    }
    
    sendResultInfoAsJson( json_encode($retValue) );
  }

?>
