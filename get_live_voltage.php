<?php
include "partials/db_conn.php";

$sql = "SELECT voltage FROM c8_f0_9e_f4_35_b0 ORDER BY timestamp DESC LIMIT 1"; // Fetch the latest voltage entry
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $voltage = $row['voltage'];
    echo json_encode(array('voltage' => $voltage));
} else {
    echo json_encode(array('error' => 'No voltage data found'));
}

$conn->close();
?>
