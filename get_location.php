<?php
$conn = new mysqli("localhost", "root", "", "vlts");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT latitude, longitude FROM location ORDER BY time_stamp DESC LIMIT 1";
$result = $conn->query($sql);

if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(["latitude" => 0, "longitude" => 0]);
}

$conn->close();
?>