<?php
include "./partials/db_conn.php";

$mac = $_GET['mac'];  // Get the MAC address from the request

// Sanitize MAC address to use it as a table name
$mac_sanitized = str_replace(':', '_', $mac);
$tableName = "device_control_" . $mac_sanitized;

$sql = "SELECT starttime, endtime FROM $tableName";
$result = $conn->query($sql);

$response = array();
if ($result->num_rows > 0) {
  // Get current time
  $currentTime = new DateTime();

  // Fetch the row
  while($row = $result->fetch_assoc()) {
    $startTime = new DateTime($row['starttime']);
    $endTime = new DateTime($row['endtime']);

    // Check if current time is within start and end time
    if ($currentTime >= $startTime && $currentTime <= $endTime) {
      $response['relay'] = 0;  // Turn on the relay
    } else {
      $response['relay'] = 1;  // Turn off the relay
    }
  }
} else {
  $response['relay'] = 1;  // Default to off if no data
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
