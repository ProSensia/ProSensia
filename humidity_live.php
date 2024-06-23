<?php

session_start();
include "partials/db_conn.php";

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    http_response_code(401); // Unauthorized
    echo json_encode(array("error" => "Unauthorized"));
    exit;
}

// Check if searchdatetime is set
$datetimecheck = isset($_POST["searchdatetime"]) ? $_POST["searchdatetime"] : '';
$device = isset($_POST["device"]) ? $_POST["device"] : '';

$mac_sanitized = str_replace(':', '_', $device);
    $tableName_data = "device_data_" . $mac_sanitized;

if (empty($device)) {
    http_response_code(400); // Bad Request
    echo json_encode(array("error" => "Device not specified"));
    exit;
}
// Convert datetime to date if provided
$searchdate = '';
if ($datetimecheck) {
    $searchdate = date('Y-m-d', strtotime($datetimecheck));
} else {
    $searchdate = date('Y-m-d'); // Current date if no datetime is provided
}

try {
    if ($datetimecheck) {
        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT humidity, temperature, timestamp FROM `$tableName_data` WHERE DATE(timestamp) = ?");
        $stmt->bind_param("s", $searchdate);
    } else {
        // Fetch data for the current day
        $stmt = $conn->prepare("SELECT humidity, temperature, timestamp FROM `$tableName_data` WHERE DATE(timestamp) = CURDATE()");
    }

    // Execute the query
    if (!$stmt->execute()) {
        throw new Exception("Database query execution failed: " . $stmt->error);
    }

    $result = $stmt->get_result();

    $data = array(); // Initialize an array to store the data

    // Loop through the result set and fetch data
    while ($row = $result->fetch_assoc()) {
        $humidity = (int)$row['humidity']; // Convert humidity to integer
        $temperature = (int)$row['temperature']; // Convert temperature to integer
        $timestamp = $row['timestamp']; // Use the timestamp as is
        $data[] = array($timestamp, $humidity, $temperature); // Add timestamp, humidity, and temperature to the data array
    }

    $stmt->close(); // Close the statement
    $conn->close(); // Close the database connection

    header('Content-Type: application/json'); // Ensure the correct content type is set
    echo json_encode($data); // Encode the data array into JSON format and output it
} catch (Exception $e) {
    // Log the error message
    error_log($e->getMessage());
    // Send a 500 response with an error message
    http_response_code(500);
    echo json_encode(array("error" => "Internal Server Error", "message" => $e->getMessage()));
}
?>