<?php
include "./partials/db_conn.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['getSwitchState'])) {
        $device_code = isset($_POST['deviceCode']) ? $_POST['deviceCode'] : '';
        
        if (!empty($device_code)) {
            $mac_sanitized = str_replace(':', '_', $device_code);
            $tableName = "device_manual_" . $mac_sanitized;

            // Fetch last saved state
            $stmt = $conn->prepare("SELECT manual_override FROM $tableName ORDER BY id DESC LIMIT 1");
            $stmt->execute();
            $stmt->bind_result($switchState);
            $stmt->fetch();
            $stmt->close();

            // Return the last saved state
            echo $switchState;
        } else {
            echo "Invalid device code.";
        }
    } elseif (isset($_POST['switchState'], $_POST['deviceCode'])) {
        $switchState = isset($_POST['switchState']) ? (int)$_POST['switchState'] : 0;
        $device_code = isset($_POST['deviceCode']) ? $_POST['deviceCode'] : '';

        if (!empty($device_code)) {
            $mac_sanitized = str_replace(':', '_', $device_code);
            $tableName = "device_manual_" . $mac_sanitized;

            // Prepare and bind
            $stmt = $conn->prepare("INSERT INTO $tableName (manual_override) VALUES (?)");
            $stmt->bind_param("i", $switchState);

            // Execute the statement
            if ($stmt->execute() === TRUE) {
                echo "Record updated successfully";
            } else {
                echo "Error updating record: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Invalid device code.";
        }
    }
}

$conn->close();
?>
