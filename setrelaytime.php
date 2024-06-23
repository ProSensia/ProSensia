<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

include "./partials/db_conn.php";
include "./partials/headers.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $starttime = $conn->real_escape_string($_POST['startrealytime']);
    $endtime = $conn->real_escape_string($_POST['endrelaytime']);
    $device = $conn->real_escape_string($_POST['my_select']);

    $mac_sanitized = str_replace(':', '_', $device);
    $tableName_control = "device_control_" . $mac_sanitized;

    // Inserting into device control table
    $sql_insert = "INSERT INTO $tableName_control (STARTTIME, endtime) VALUES ('$starttime', '$endtime')";

    if ($conn->query($sql_insert) === TRUE) {
       
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }

    // Inserting into timer table
    $sql_timer = "INSERT INTO timer (userid, device_id, start_time, end_time) VALUES ('$user_id', '$device', '$starttime', '$endtime')";

    if ($conn->query($sql_timer) === TRUE) {
      
    } else {
        echo "Error: " . $sql_timer . "<br>" . $conn->error;
    }
}

$conn->close();
?>
