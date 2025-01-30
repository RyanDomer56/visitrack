<?php
$conn = new mysqli("localhost", "root", "", "tracking_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT latitude, longitude FROM gps_tracking ORDER BY timestamp DESC LIMIT 1";
$result = $conn->query($sql);

if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(["latitude" => 0, "longitude" => 0]);
}

$conn->close();
?>