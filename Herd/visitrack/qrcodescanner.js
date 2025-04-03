class QRScanner {
  constructor() {
      this.html5QrCode = null;
      this.cameraId = null;
  }

  async initializeScanner() {
      try {
          // Get available cameras
          const devices = await Html5Qrcode.getCameras();
          if (devices && devices.length) {
              // Prefer back camera if available
              this.cameraId = devices.find(device => device.label.toLowerCase().includes('back'))?.id || devices[0].id;
              
              // Initialize scanner
              this.html5QrCode = new Html5Qrcode("qr-reader");
              
              // Start scanning
              await this.startScanning();
          } else {
              throw new Error("No cameras found");
          }
      } catch (error) {
          this.showError("Camera initialization failed: " + error.message);
      }
  }

  async startScanning() {
      try {
          const config = {
              fps: 10,
              qrbox: { width: 250, height: 250 },
              aspectRatio: 1.0
          };

          await this.html5QrCode.start(
              this.cameraId,
              config,
              this.onScanSuccess.bind(this),
              this.onScanFailure.bind(this)
          );

          // Show scanning indicator
          document.getElementById('scan-status').textContent = "Scanning...";
      } catch (error) {
          this.showError("Scanning failed to start: " + error.message);
      }
  }

  async stopScanning() {
      if (this.html5QrCode && this.html5QrCode.isScanning) {
          try {
              await this.html5QrCode.stop();
              document.getElementById('scan-status').textContent = "Scanner stopped";
          } catch (error) {
              this.showError("Failed to stop scanner: " + error.message);
          }
      }
  }

  onScanSuccess(decodedText, decodedResult) {
      // Play success sound
      document.getElementById('scan-sound').play();

      // Stop scanning after successful scan
      this.stopScanning();

      try {
          // Parse the QR code data
          const userData = JSON.parse(decodedText);
          
          // Display the data
          this.displayScanResult(userData);
          
          // Save to scan history
          this.saveToHistory(userData);
          
          // Update scan status
          document.getElementById('scan-status').textContent = "Scan successful!";
      } catch (error) {
          this.showError("Invalid QR code format");
      }
  }

  onScanFailure(error) {
      // Don't show errors for routine scanning failures
      console.log(`QR Code scanning failure: ${error}`);
  }

  displayScanResult(data) {
      const resultDiv = document.getElementById('scan-result');
      resultDiv.innerHTML = `
          <div class="scan-data">
              <h3>Scanned Data</h3>
              <div class="data-item">
                  <span class="label">Student ID:</span>
                  <span class="value">${data.studentId || 'N/A'}</span>
              </div>
              <div class="data-item">
                  <span class="label">Name:</span>
                  <span class="value">${data.name || 'N/A'}</span>
              </div>
              <div class="data-item">
                  <span class="label">Course:</span>
                  <span class="value">${data.course || 'N/A'}</span>
              </div>
              <div class="data-item">
                  <span class="label">Access Type:</span>
                  <span class="value">${data.accessType || 'N/A'}</span>
              </div>
              <div class="data-item">
                  <span class="label">Timestamp:</span>
                  <span class="value">${new Date().toLocaleString()}</span>
              </div>
          </div>
      `;
  }

  saveToHistory(data) {
      const history = JSON.parse(localStorage.getItem('scanHistory') || '[]');
      history.unshift({
          ...data,
          timestamp: new Date().toISOString()
      });
      // Keep only last 50 scans
      if (history.length > 50) history.pop();
      localStorage.setItem('scanHistory', JSON.stringify(history));
      this.updateHistoryDisplay();
  }

  updateHistoryDisplay() {
      const history = JSON.parse(localStorage.getItem('scanHistory') || '[]');
      const historyDiv = document.getElementById('scan-history');
      historyDiv.innerHTML = history.map(entry => `
          <div class="history-item">
              <div class="history-time">${new Date(entry.timestamp).toLocaleString()}</div>
              <div class="history-data">
                  ${entry.studentId} - ${entry.name}
              </div>
          </div>
      `).join('');
  }

  showError(message) {
      const errorDiv = document.getElementById('error-message');
      errorDiv.textContent = message;
      errorDiv.style.display = 'block';
      setTimeout(() => {
          errorDiv.style.display = 'none';
      }, 3000);
  }
}

// Initialize scanner when page loads
document.addEventListener('DOMContentLoaded', () => {
  const scanner = new QRScanner();
  
  // Add button event listeners
  document.getElementById('start-scan').addEventListener('click', () => scanner.initializeScanner());
  document.getElementById('stop-scan').addEventListener('click', () => scanner.stopScanning());
});