<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tracker_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to fetch student tracking data
function fetchStudentTrackingData($studentId) {
    global $conn;

    // Prepare SQL statement to get tracking details
    $sql = "SELECT 
                student_id, 
                time_in, 
                time_out, 
                building_name, 
                latitude, 
                longitude
            FROM student_tracking_log
            WHERE student_id = ?
            ORDER BY time_in DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $studentId);
    $stmt->execute();
    $result = $stmt->get_result();

    $trackingData = [];
    while ($row = $result->fetch_assoc()) {
        $trackingData[] = $row;
    }

    $stmt->close();
    return $trackingData;
}

// Function to insert tracking data
function insertTrackingData($studentId, $timeIn, $timeOut, $buildingName, $latitude, $longitude) {
    global $conn;

    $sql = "INSERT INTO student_tracking_log 
            (student_id, time_in, time_out, building_name, latitude, longitude) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssdd", $studentId, $timeIn, $timeOut, $buildingName, $latitude, $longitude);
    $result = $stmt->execute();

    $stmt->close();
    return $result;
}

// Example usage
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentId = $_POST['student_id'];
    $action = $_POST['action'];

    if ($action == 'fetch') {
        $trackingHistory = fetchStudentTrackingData($studentId);
        echo json_encode($trackingHistory);
    } elseif ($action == 'insert') {
        $timeIn = $_POST['time_in'];
        $timeOut = $_POST['time_out'] ?? null;
        $buildingName = $_POST['building_name'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];

        $insertResult = insertTrackingData($studentId, $timeIn, $timeOut, $buildingName, $latitude, $longitude);
        echo json_encode(['success' => $insertResult]);
    }
}

$conn->close();
?>