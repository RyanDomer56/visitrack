<?php
$conn = new mysqli("localhost", "root", "", "vlts.db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$time_stamp = date("Y-m-d H:i:s");

$sql = "INSERT INTO location (latitude, longitude, time_stamp) VALUES ('$latitude', '$longitude', '$time_stamp')";

if ($conn->query($sql) === TRUE) {
    echo "Location saved";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>