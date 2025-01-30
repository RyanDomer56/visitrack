function getLocation() {
  if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(sendLocation);
  } else {
      alert("Geolocation is not supported by this browser.");
  }
}

function sendLocation(position) {
  let lat = position.coords.latitude;
  let lon = position.coords.longitude;

  fetch("save_location.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `latitude=${lat}&longitude=${lon}`
  });
}

// Call the function to get location
getLocation();