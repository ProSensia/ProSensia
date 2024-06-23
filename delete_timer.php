<?php
session_start();
include "partials/db_conn.php";

if (!isset($_SESSION["user_id"])) {
    echo 'error';
    exit;
}

if (isset($_POST["id"])) {
    $timer_id = $_POST["id"];
    $user_id = $_SESSION["user_id"];
    $device_name = $_POST["name"];
    // Ensure the timer belongs to the logged-in user
    $sql = "DELETE FROM timer WHERE timer_id=? AND userid=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $timer_id, $user_id);
    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
} else {
    echo 'error';
}




$conn->close();
?>
