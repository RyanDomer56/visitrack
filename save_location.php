<?php
$conn = new mysqli("localhost", "root", "", "tracking_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$timestamp = date("Y-m-d H:i:s");

$sql = "INSERT INTO gps_tracking (latitude, longitude, timestamp) VALUES ('$latitude', '$longitude', '$timestamp')";

if ($conn->query($sql) === TRUE) {
    echo "Location saved";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>