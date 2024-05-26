<?php
include "partials/db_conn.php";
session_start();

// Check if searchdatetime is set
$datetimecheck = isset($_POST["searchdatetime"]) ? $_POST["searchdatetime"] : '';

if ($datetimecheck) {
    // If datetime is passed, filter the data based on the provided datetime
    $sql = "SELECT humidity, temperature, timestamp FROM a WHERE timestamp >= '$datetimecheck'";
} else {
    // If no datetime is passed, fetch all data
    $sql = "SELECT humidity, temperature, timestamp FROM a";
}

$result = $conn->query($sql);

$data = array(); // Initialize an array to store the data

// Loop through the result set and fetch data
while ($row = $result->fetch_assoc()) {
    $humidity = (int)$row['humidity']; // Convert humidity to integer
    $temperature = (int)$row['temperature']; // Convert temperature to integer
    $timestamp = $row['timestamp']; // Use the timestamp as is
    $data[] = array($timestamp, $humidity, $temperature); // Add timestamp, humidity, and temperature to the data array
}

$conn->close(); // Close the database connection

header('Content-Type: application/json'); // Ensure the correct content type is set
echo json_encode($data); // Encode the data array into JSON format and output it
?>
