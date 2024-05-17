<?php
include "partials/db_conn.php";
$sql = "SELECT humidity, temperature, time FROM sensor_data"; // Assuming your table has columns for humidity, temperature, and timestamps
$result = $conn->query($sql);

$data = array();
while ($row = $result->fetch_assoc()) {
    $humidity = (int)$row['humidity'];
    $temperature = (int)$row['temperature'];
    $timestamp = (int)$row['time']; // Assuming timestamp is already in milliseconds
    $data[] = array($timestamp, $humidity, $temperature); // Adding both humidity and temperature to the data array
}

$conn->close();

echo json_encode($data);
?>
