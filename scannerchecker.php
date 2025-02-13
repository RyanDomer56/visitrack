<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Default username for XAMPP/WAMP
$password = ""; // Default password for XAMPP/WAMP
$dbname = "tracker_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the JSON data from the request
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Extract the user data
$studentId = $data['studentId'];
$name = $data['name'];
$course = $data['course'];
$accessType = $data['accessType'];

// Prepare and execute the SQL query
$sql = "SELECT * FROM qrcodescanner WHERE studentId = ? AND name = ? AND course = ? AND accessType = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $studentId, $name, $course, $accessType);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists
if ($result->num_rows > 0) {
    $response = [
        'status' => 'success',
        'message' => 'User found in the database.',
        'user' => $result->fetch_assoc()
    ];
} else {
    $response = [
        'status' => 'error',
        'message' => 'User not found in the database.'
    ];
}

// Close the connection
$stmt->close();
$conn->close();

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>