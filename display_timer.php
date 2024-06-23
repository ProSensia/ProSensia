<?php
session_start();
include "partials/db_conn.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$sql = "SELECT * FROM timer WHERE userid='$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>";
        echo "Device ID: " . htmlspecialchars($row["device_id"]) . ", Start Time: " . htmlspecialchars($row["start_time"]) . ", End Time: " . htmlspecialchars($row["end_time"]);
        echo " <button class='deleteBtn' data-id='" . htmlspecialchars($row["timer_id"]) . "' data-name='" . htmlspecialchars($row["device_id"]) . "'>Delete</button>";
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "No timers found.";
}

$conn->close();
?>
