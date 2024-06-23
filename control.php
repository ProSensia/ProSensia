<?php
// Include database connection file
include "./partials/db_conn.php";

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set the timezone to Pakistan time
date_default_timezone_set('Asia/Karachi');

// Get MAC address from the request
$mac = $_GET['mac'];

// Sanitize MAC address (replace ':' with '_')
$mac_sanitized = str_replace(':', '_', $mac);

// Construct table names based on sanitized MAC address
$tableNameManual = "device_manual_" . $mac_sanitized;
$tableNameTimer = "device_control_" . $mac_sanitized;

// Initialize response array
$response = array();

// Default relay status
$relayStatus = 0;

// Check manual override status in the database
$sqlManual = "SELECT manual_override FROM $tableNameManual ORDER BY `manual_id` DESC LIMIT 1";
$resultManual = $conn->query($sqlManual);

// Check if manual override query executed successfully
if (!$resultManual) {
    // Handle query error
    die("Manual override query error: " . $conn->error);
}

// Check if there are rows returned for manual override
if ($resultManual->num_rows > 0) {
    // Fetch the manual override status
    $rowManual = $resultManual->fetch_assoc();
    $manualOverride = $rowManual['manual_override'];

    // Determine relay status based on manual control status
    if ($manualOverride == 1) {
        $relayStatus = 1; // Turn on the relay
    }
}

// If manual override is not set (manual relay off), check timer-based control
if ($relayStatus === 0) {
    // Fetch timer settings from the database
    $sqlTimer = "SELECT starttime, endtime FROM $tableNameTimer";
    $resultTimer = $conn->query($sqlTimer);

    // Check if timer query executed successfully
    if (!$resultTimer) {
        // Handle query error
        die("Timer query error: " . $conn->error);
    }

    // Get current time in Pakistan timezone
    $currentTime = new DateTime('now', new DateTimeZone('Asia/Karachi'));

    // Check if there are rows returned for timer settings
    if ($resultTimer->num_rows > 0) {
        $timerSet = true;

        // Fetch the timer settings
        while ($rowTimer = $resultTimer->fetch_assoc()) {
            $startTime = $rowTimer['starttime'] ? new DateTime($rowTimer['starttime']) : null;
            $endTime = $rowTimer['endtime'] ? new DateTime($rowTimer['endtime']) : null;

            // Check if current time is within start and end time
            if ($startTime && $endTime && $currentTime >= $startTime && $currentTime <= $endTime) {
                $relayStatus = 1; // Turn on the relay if within timer range
                break; // No need to check further if any condition is met
            }
        }
    } else {
        // No timer set, use default button-based relay status (0 in this case)
        $timerSet = false;
    }
}

// Add relay status and timer status to response array
$response['relay'] = $relayStatus;
$response['timer_set'] = isset($timerSet) ? $timerSet : false;

// Close database connection
$conn->close();

// Set response header to JSON
header('Content-Type: application/json');

// Output JSON response
echo json_encode($response);
?>
