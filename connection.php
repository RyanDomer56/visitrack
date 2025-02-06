<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vlts.db";

try{
    $conn = new mysqli($servername, $username, $password, $dbname);
    if($conn->connect_error){
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
}

catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn->close();
