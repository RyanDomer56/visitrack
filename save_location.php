<?php

require_once __DIR__ . "/backend/Database.php";
require_once __DIR__ . "/backend/DatabaseFactory.php";

function fetchStudentTrackingData($studentId) 
{
    try {
        $config = require 'config.php';

        $db = DatabaseFactory::create($config);

        $pdo = $db->getConnection();

        $stmt = $pdo->prepare("SELECT 
                    student_id, 
                    time_in, 
                    time_out, 
                    building_name, 
                latitude, 
                longitude
            FROM student_tracking_log
            WHERE student_id = ?
            ORDER BY time_in DESC");

    $stmt->bindValue(1, $studentId);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $trackingData = $result;

    return $trackingData;
    
    } catch (PDOException $e) {
        // Handle PDO exceptions (database errors) - for now, just echo the message
        echo "Database Error: " . $e->getMessage();
        return false; // Or handle error in a way appropriate for your application (e.g., log, throw exception)
    } catch (InvalidArgumentException $e) {
        // Handle configuration errors
        echo "Configuration Error: " . $e->getMessage();
        return false; // Or handle config errors as needed
    }
}

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// function fetchStudentTrackingData($studentId) {
//     global $conn;
// // Function to fetch student tracking data


//     // Prepare SQL statement to get tracking details
//     $sql = "SELECT 
//                 student_id, 
//                 time_in, 
//                 time_out, 
//                 building_name, 
//                 latitude, 
//                 longitude
//             FROM student_tracking_log
//             WHERE student_id = ?
//             ORDER BY time_in DESC";

//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("s", $studentId);
//     $stmt->execute();
//     $result = $stmt->get_result();
// }

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