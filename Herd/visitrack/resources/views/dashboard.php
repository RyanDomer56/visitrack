<?php
// Database connection

require_once __DIR__ . "/backend/Database.php";
require_once __DIR__ . "/backend/DatabaseFactory.php";

try {
    // **Load the configuration array from config.php**
    $config = require 'config.php';

    // **Create a Database object using the Factory and the configuration**
    $db = DatabaseFactory::create($config);

    // **Get the PDO connection**
    $pdo = $db->getConnection();

    // **Now you can use $pdo to make SQL requests (as we showed before)**
    // Example: Fetch users (same example as before)
    $stmt = $pdo->prepare("SELECT * FROM student_tracking_log ORDER BY created_at DESC");
    $stmt->execute();
    $records = $stmt->fetchAll();
    
    // $db = new Database($dsn, $username, $password);
    // $pdo = $db->getConnection();
    // $stmt = $pdo->prepare("SELECT * FROM student_tracking_log ORDER BY created_at DESC");
    // $stmt->execute();
    // $records = $stmt->fetchAll();
    // $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // // Fetch data from student_tracking_log table
    // $query = "SELECT * FROM student_tracking_log ORDER BY created_at DESC";
    // $stmt = $conn->query($query);
    // $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    echo "Connection Failed: " . $e->getMessage();
} catch(InvalidArgumentException $e) {
    echo "Configuration Error: " . $e->getMessage(); // Catch configuration errors
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Tracking Log Dashboard</title>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="styles/dashboard.css">


    <script>
    // Auto refresh the page every 5 minutes
    setTimeout(function() {
        window.location.reload();
    }, 300000);

    // Update the "Last updated" timestamp
    function updateLastUpdated() {
        document.getElementById('last-update').textContent =
            'Last updated: ' + new Date().toLocaleString();
    }

    // Call when page loads
    window.onload = updateLastUpdated;
    </script>
</head>

<body>
    <div class="container">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Student Tracking Log Dashboard</h1>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="refresh-btn">Refresh Data</a>
        </div>

        <!-- Add Map Container -->
        <div class="map-container">
            <div id="map"></div>
        </div>

        <!-- Existing Table Container -->
        <div class="data-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Building Name</th>
                        <th>Location (Lat, Long)</th>
                        <th>Duration (mins)</th>
                        <th>Tracking Accuracy</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $record): ?>
                    <tr>
                        <td><?= htmlspecialchars($record['student_id']); ?></td>
                        <td class="timestamp">
                            <?= htmlspecialchars($record['time_in']); ?>
                        </td>
                        <td class="timestamp">
                            <?= htmlspecialchars($record['time_out']); ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($record['building_name']); ?>
                        </td>
                        <td class="location-data">
                            <?= htmlspecialchars($record['latitude']) . ', ' . 
                                  htmlspecialchars($record['longitude']); ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($record['duration_minutes']); ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($record['tracking_accuracy']); ?>
                        </td>
                        <td class="timestamp">
                            <?= htmlspecialchars($record['created_at']); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div id="last-update"></div>
        </div>
    </div>

    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
    // Initialize the map
    var map = L.map('map').setView([0, 0], 2);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // PHP array to JavaScript array
    var students = <?php echo json_encode($records); ?>;
    var bounds = [];

    // Add markers for each student
    students.forEach(function(student) {
        var lat = parseFloat(student.latitude);
        var lng = parseFloat(student.longitude);

        if (!isNaN(lat) && !isNaN(lng)) {
            bounds.push([lat, lng]);

            // Create marker
            var marker = L.marker([lat, lng]).addTo(map);

            // Create popup content
            var popupContent = `
                    <div class="student-info">
                        <h3>Student ID: ${student.student_id}</h3>
                        <p><strong>Building:</strong> ${student.building_name}</p>
                        <p><strong>Time In:</strong> ${student.time_in}</p>
                        <p><strong>Time Out:</strong> ${student.time_out}</p>
                        <p><strong>Duration:</strong> ${student.duration_minutes} minutes</p>
                        <p><strong>Accuracy:</strong> ${student.tracking_accuracy}</p>
                    </div>
                `;

            // Add popup to marker
            marker.bindPopup(popupContent);
        }
    });

    // Fit map to show all markers
    if (bounds.length > 0) {
        map.fitBounds(bounds);
    }

    // Add legend
    var legend = L.control({
        position: 'bottomright'
    });
    legend.onAdd = function(map) {
        var div = L.DomUtil.create('div', 'info legend');
        div.innerHTML = '<strong>Student Locations</strong><br>Click markers for details';
        div.style.backgroundColor = 'white';
        div.style.padding = '10px';
        div.style.borderRadius = '5px';
        return div;
    };
    legend.addTo(map);
    </script>
</body>

</html>