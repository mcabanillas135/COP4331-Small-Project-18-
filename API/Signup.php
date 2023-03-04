<?php

    $host = 'cop4332.xyz';
    $user = 'contactmanager';
    $password = 'COP4331';
    $database = 'COP4331';

    // Create connection
    $conn = new mysqli($host, $user, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    echo "Connected to the database\n";

    function handleSignup($req, $res) {
        global $conn;
        $id = $req['id'];
        $user = $req['user'];
        $password = $req['password'];

        // Check if user already exists
        $sqlSelect = "SELECT * FROM Contact_User WHERE User_Id = '$id'";
        $result = $conn->query($sqlSelect);
        if (!$result) {
            die("Query failed: " . $conn->error);
        }
        if ($result->num_rows > 0) {
            return $res->json(array('message' => 'User already exists'), 409);
        }

        // Add new user
        $sqlInsert = "INSERT INTO Contact_User VALUES ('$id', '$user', '$password')";
        $result = $conn->query($sqlInsert);
        if (!$result) {
            die("Query failed: " . $conn->error);
        }
        $newUser = array('id' => $conn->insert_id, 'user' => $user);
        return $res->json(array('message' => 'User created', 'user' => $newUser), 201);
    }

?>
