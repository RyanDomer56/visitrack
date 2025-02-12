
        let map, marker, watchId, polyline, coordinates = [];
        let visitStart = null;
        let currentBuilding = null;
        let buildingEntryTime = null;
        let visitHistory = [];

        // Define buildings and their coordinates
        const buildings = {
    'Belmonte Building': {
        coords: [
            [14.70084780751153, 121.0330828674236],
            [14.70094780751153, 121.0331828674236]
        ],
        departments: ['IC Building']
    },
    'Auditorium/IK Building': {
        coords: [
            [14.700738477702336, 121.03239124936754],
            [14.700838477702336, 121.03249124936754]
        ],
        departments: ['Auditorium', 'IK Facilities']
    },
    'Academic Building': {
        coords: [
            [14.70099035734959, 121.03282099687829],
            [14.70109035734959, 121.03292099687829]
        ],
        departments: ['Academic Departments']
    },
    'Administration Building': {
        coords: [
            [14.700387598929176, 121.033049682769],
            [14.700487598929176, 121.033149682769]
        ],
        departments: ['Administrative Offices']
    },
    'Yellow Building': {
        coords: [
            [14.700528654335658, 121.03338784791353],
            [14.700628654335658, 121.03348784791353]
        ],
        departments: ['NSTP Building']
    },
    'Gymnasium': {
        coords: [
            [14.700269204359872, 121.03365510773064],
            [14.700369204359872, 121.03375510773064]
        ],
        departments: ['Sports Facilities']
    }
};

        function initMap() {
            const centerLat = 14.7007;
            const centerLng = 121.0349;
            
            map = L.map('map', {
                center: [centerLat, centerLng],
                zoom: 17,
                minZoom: 16,
                maxZoom: 19,
                maxBounds: [
                    [centerLat - 0.01, centerLng - 0.01],
                    [centerLat + 0.01, centerLng + 0.01]
                ],
                maxBoundsViscosity: 1.0
            });

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            polyline = L.polyline([], {
                color: 'blue',
                weight: 3,
                opacity: 0.7
            }).addTo(map);

            // Add buildings to map
            for (let buildingName in buildings) {
                const building = buildings[buildingName];
                L.rectangle(building.coords, {
                    color: 'green',
                    fillOpacity: 0.3
                }).bindPopup(buildingName + '<br>Departments: ' + building.departments.join(', ')).addTo(map);
            }
        }

        function checkBuilding(lat, lng) {
            for (let buildingName in buildings) {
                const building = buildings[buildingName];
                const [[minLat, minLng], [maxLat, maxLng]] = building.coords;
                
                if (lat >= minLat && lat <= maxLat && lng >= minLng && lng <= maxLng) {
                    if (currentBuilding !== buildingName) {
                        if (currentBuilding) {
                            recordVisit(currentBuilding);
                        }
                        currentBuilding = buildingName;
                        buildingEntryTime = new Date();
                        document.getElementById('currentBuilding').textContent = `Current location: ${buildingName}`;
                    }
                    return buildingName;
                }
            }
            if (currentBuilding) {
                recordVisit(currentBuilding);
                currentBuilding = null;
                buildingEntryTime = null;
                document.getElementById('currentBuilding').textContent = 'Not in any building';
            }
            return null;
        }

        function recordVisit(buildingName) {
            const duration = Math.round((new Date() - buildingEntryTime) / 1000 / 60); // in minutes
            const visitorId = document.getElementById('visitorId').value || 'Unknown';
            
            const visit = {
                visitorId: visitorId,
                building: buildingName,
                duration: duration,
                timestamp: new Date().toLocaleString()
            };
            
            visitHistory.unshift(visit);
            updateVisitHistory();
            
            // Check for long duration alert (over 60 minutes)
            if (duration >= 60) {
                createAlert(`Alert: Visitor ${visitorId} spent ${duration} minutes in ${buildingName}`);
            }
        }

        function updateVisitHistory() {
            const historyHtml = visitHistory.map(visit => `
                <div style="border-bottom: 1px solid #ccc; padding: 5px;">
                    Visitor ${visit.visitorId} visited ${visit.building}<br>
                    Duration: ${visit.duration} minutes<br>
                    Time: ${visit.timestamp}
                </div>
            `).join('');
            document.getElementById('visitHistory').innerHTML = historyHtml;
        }

        function createAlert(message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert';
            alertDiv.textContent = message;
            document.body.appendChild(alertDiv);
            setTimeout(() => alertDiv.remove(), 5000);
        }

        function updateLocation(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            const accuracy = position.coords.accuracy;

            document.getElementById('latitude').textContent = lat.toFixed(6);
            document.getElementById('longitude').textContent = lng.toFixed(6);
            document.getElementById('accuracy').textContent = accuracy.toFixed(1);

            if (!marker) {
                marker = L.marker([lat, lng]).addTo(map);
            } else {
                marker.setLatLng([lat, lng]);
            }

            coordinates.push([lat, lng]);
            polyline.setLatLngs(coordinates);

            checkBuilding(lat, lng);

            if (buildingEntryTime) {
                const timeSpent = Math.round((new Date() - buildingEntryTime) / 1000 / 60);
                document.getElementById('timeSpent').textContent = `Time spent: ${timeSpent} minutes`;
            }

            map.setView([lat, lng], 17, {
                animate: true,
                pan: { duration: 1 }
            });
        }

        function handleLocationError(error) {
            console.error('Error getting location:', error);
            alert(`Location error: ${error.message}`);
        }

        function startTracking() {
            const visitorId = document.getElementById('visitorId').value;
            if (!visitorId) {
                alert('Please enter a Visitor ID before starting tracking');
                return;
            }

            visitStart = new Date();
            if ("geolocation" in navigator) {
                watchId = navigator.geolocation.watchPosition(
                    updateLocation,
                    handleLocationError,
                    {
                        enableHighAccuracy: true,
                        maximumAge: 0,
                        timeout: 5000
                    }
                );
            } else {
                alert("Geolocation is not supported by your browser");
            }
        }

        function stopTracking() {
            if (watchId) {
                if (currentBuilding) {
                    recordVisit(currentBuilding);
                }
                
                // Generate tracking summary
                const trackingEnd = new Date();
                const totalTrackingTime = Math.round((trackingEnd - visitStart) / 1000 / 60);
                const summaryHtml = `
                    <strong>Tracking Summary:</strong><br>
                    Start Time: ${visitStart.toLocaleString()}<br>
                    End Time: ${trackingEnd.toLocaleString()}<br>
                    Total Tracking Duration: ${totalTrackingTime} minutes
                `;
                document.getElementById('trackingSummary').innerHTML = summaryHtml;

                navigator.geolocation.clearWatch(watchId);
                watchId = null;
                visitStart = null;
                currentBuilding = null;
                buildingEntryTime = null;
                coordinates = [];
                polyline.setLatLngs([]);
            }
        }

        window.onload = initMap;

        // Add a function to send tracking data to PHP script
function sendTrackingData(action, data) {
    fetch('save_location.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            ...data,
            action: action
        })
    })
    .then(response => response.json())
    .then(result => {
        console.log('Tracking data response:', result);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Modify startTracking function to send initial data
function startTracking() {
    const visitorId = document.getElementById('visitorId').value;
    if (!visitorId) {
        alert('Please enter a Visitor ID before starting tracking');
        return;
    }

    visitStart = new Date();
    sendTrackingData('insert', {
        student_id: visitorId,
        time_in: visitStart.toISOString().slice(0, 19).replace('T', ' '),
        building_name: currentBuilding || 'Unknown',
        latitude: coordinates.length > 0 ? coordinates[0][0] : null,
        longitude: coordinates.length > 0 ? coordinates[0][1] : null
    });

    // Original tracking start code remains the same
    if ("geolocation" in navigator) {
        watchId = navigator.geolocation.watchPosition(
            updateLocation,
            handleLocationError,
            {
                enableHighAccuracy: true,
                maximumAge: 0,
                timeout: 5000
            }
        );
    } else {
        alert("Geolocation is not supported by your browser");
    }
}

// Modify stopTracking to send final tracking data
function stopTracking() {
    if (watchId) {
        const trackingEnd = new Date();
        const visitorId = document.getElementById('visitorId').value;

        // Send final tracking data
        sendTrackingData('insert', {
            student_id: visitorId,
            time_in: visitStart.toISOString().slice(0, 19).replace('T', ' '),
            time_out: trackingEnd.toISOString().slice(0, 19).replace('T', ' '),
            building_name: currentBuilding || 'Unknown',
            latitude: coordinates[coordinates.length - 1][0],
            longitude: coordinates[coordinates.length - 1][1]
        });

        // Original stop tracking code remains the same
        navigator.geolocation.clearWatch(watchId);
        watchId = null;
        visitStart = null;
        currentBuilding = null;
        buildingEntryTime = null;
        coordinates = [];
        polyline.setLatLngs([]);
    }
}

// Modify recordVisit to send building visit data
function recordVisit(buildingName) {
    const duration = Math.round((new Date() - buildingEntryTime) / 1000 / 60); // in minutes
    const visitorId = document.getElementById('visitorId').value || 'Unknown';
    
    sendTrackingData('insert', {
        student_id: visitorId,
        time_in: buildingEntryTime.toISOString().slice(0, 19).replace('T', ' '),
        time_out: new Date().toISOString().slice(0, 19).replace('T', ' '),
        building_name: buildingName,
        latitude: coordinates[coordinates.length - 1][0],
        longitude: coordinates[coordinates.length - 1][1]
    });

    // Rest of the original recordVisit code remains the same
    const visit = {
        visitorId: visitorId,
        building: buildingName,
        duration: duration,
        timestamp: new Date().toLocaleString()
    };
    
    visitHistory.unshift(visit);
    updateVisitHistory();
    
    // Check for long duration alert (over 60 minutes)
    if (duration >= 60) {
        createAlert(`Alert: Visitor ${visitorId} spent ${duration} minutes in ${buildingName}`);
    }
            // Add this code to tracker.js or create a new mobile-view.js file

        // Function to detect mobile device
        function isMobileDevice() {
            return (window.innerWidth <= 768) || 
                (navigator.maxTouchPoints > 0) ||
                (navigator.msMaxTouchPoints > 0);
        }

        // Function to initialize mobile view
        function initializeMobileView() {
            if (isMobileDevice()) {
                // Add mobile class to body
                document.body.classList.add('mobile-view');
                
                // Create and append mobile navigation
                const mobileNav = `
                    <nav class="mobile-nav">
                        <button class="nav-button active" data-view="map">
                            <span class="nav-icon">🗺️</span>
                            <span>Map</span>
                        </button>
                        <button class="nav-button" data-view="info">
                            <span class="nav-icon">📍</span>
                            <span>Location</span>
                        </button>
                        <button class="nav-button" data-view="history">
                            <span class="nav-icon">📋</span>
                            <span>History</span>
                        </button>
                    </nav>
                `;
                document.body.insertAdjacentHTML('beforeend', mobileNav);

                // Initialize mobile navigation handlers
                initMobileNavigation();
            }
        }

        // Function to handle mobile navigation
        function initMobileNavigation() {
            const navButtons = document.querySelectorAll('.nav-button');
            const sidebar = document.querySelector('.sidebar');
            const mapCard = document.querySelector('#map').parentElement;

            navButtons.forEach(button => {
                button.addEventListener('click', () => {
                    // Remove active class from all buttons
                    navButtons.forEach(btn => btn.classList.remove('active'));
                    // Add active class to clicked button
                    button.classList.add('active');

                    // Handle view switching
                    const view = button.dataset.view;
                    switch(view) {
                        case 'map':
                            mapCard.style.display = 'block';
                            sidebar.style.display = 'none';
                            break;
                        case 'info':
                            mapCard.style.display = 'none';
                            sidebar.style.display = 'block';
                            document.querySelector('.history-panel').parentElement.parentElement.style.display = 'none';
                            break;
                        case 'history':
                            mapCard.style.display = 'none';
                            sidebar.style.display = 'block';
                            document.querySelector('.history-panel').parentElement.parentElement.style.display = 'block';
                            break;
                    }
                });
            });
        }

        // Initialize mobile view when DOM is loaded
        document.addEventListener('DOMContentLoaded', initializeMobileView);

        // Handle orientation changes
        window.addEventListener('orientationchange', () => {
            setTimeout(adjustMobileLayout, 100);
        });

        // Function to adjust layout on orientation change
        function adjustMobileLayout() {
            if (isMobileDevice()) {
                const map = document.querySelector('#map');
                map.style.height = window.innerHeight * 0.6 + 'px';
            }
        }
}
