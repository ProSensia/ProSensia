<?php
include "partials/db_conn.php";

$sql = "SELECT voltage FROM sensor_data ORDER BY time DESC LIMIT 1"; // Fetch the latest voltage entry
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $voltage = (int)$row['voltage'];
    echo json_encode(array('voltage' => $voltage));
} else {
    echo json_encode(array('error' => 'No voltage data found'));
}

$conn->close();
?>
