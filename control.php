<?php
include "./partials/db_conn.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('Asia/Karachi');

$mac = $_GET['mac'];
$mac_sanitized = str_replace(':', '_', $mac);
$tableName = "device_control_" . $mac_sanitized;

$sql = "SELECT starttime, endtime, manual_override FROM $tableName";
$result = $conn->query($sql);

$response = array();
$relayStatus = 0;




if ($result->num_rows > 0) {
    $currentTime = new DateTime('now', new DateTimeZone('Asia/Karachi'));
    while($row = $result->fetch_assoc()) {
        $startTime = new DateTime($row['starttime']);
        $endTime = new DateTime($row['endtime']);
        $manualOverride = $row['manual_override'];

        if ($manualOverride == 0) {
            $relayStatus = 0;
            break;
        } elseif ($currentTime >= $startTime && $currentTime <= $endTime) {
            $relayStatus = 1;
        }
    }
}

$response['relay'] = $relayStatus;

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>