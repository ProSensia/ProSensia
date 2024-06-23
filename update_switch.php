<?php
include "./partials/db_conn.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update or insert the switch state
    if (isset($_POST['switchState']) && isset($_POST['deviceCode'])) {
        $switchState = (int)$_POST['switchState'];
        $device_code = $_POST['deviceCode'];

        $mac_sanitized = str_replace(':', '_', $device_code);
        $tableName = "device_control_" . $mac_sanitized;

        // Update or insert the switch state
        $stmt = $conn->prepare("INSERT INTO $tableName (`manual_override`) VALUES (?) ON DUPLICATE KEY UPDATE `manual_override` = ?");
        $stmt->bind_param("ii", $switchState, $switchState);

        if ($stmt->execute() === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $stmt->error;
        }

        $stmt->close();
    } elseif (isset($_POST['getSwitchState']) && isset($_POST['deviceCode'])) {
        // Fetch the current state after update
        $device_code = $_POST['deviceCode'];
        $mac_sanitized = str_replace(':', '_', $device_code);
        $tableName = "device_control_" . $mac_sanitized;

        $result = $conn->query("SELECT `manual_override` FROM $tableName LIMIT 1");
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo $row['manual_override'];
        } else {
            echo "0"; // Default if no rows found
        }
    } else {
        echo "Invalid request";
    }
}

$conn->close();
?>
