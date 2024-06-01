<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);


    $user_id = $_SESSION['user_id'];
    $mac = $_POST['mac'];

    include "./partials/db_conn.php";

// Check if POST variables are set
if (isset($_POST['mac'], $_POST['voltage'], $_POST['current'], $_POST['temperature'], $_POST['humidity'])) {
    $mac = $_POST['mac'];
    $voltage = $_POST['voltage'];
    $current = $_POST['current'];
    $temperature = $_POST['temperature'];
    $humidity = $_POST['humidity'];

    // Sanitize MAC address to use it as a table name
    $mac_sanitized = str_replace(':', '_', $mac);
    $tableName_data = "device_data_" . $mac_sanitized;
    $tableName_control = "device_control_" . $mac_sanitized;

    // Create data table query
    $sql_data_table = "CREATE TABLE IF NOT EXISTS $tableName_data (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        voltage FLOAT NOT NULL,
        current FLOAT NOT NULL,
        temperature FLOAT NOT NULL,
        humidity FLOAT NOT NULL,
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    // Create control table query
    $sql_control_table = "CREATE TABLE IF NOT EXISTS $tableName_control (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        starttime TIMESTAMP NULL,
        endtime TIMESTAMP NULL,
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if ($conn->query($sql_data_table) === TRUE && $conn->query($sql_control_table) === TRUE) {
        echo "Tables created successfully";
    } else {
        echo "Error creating tables: " . $conn->error;
    }

    // Insert data into data table
    $sql_insert = "INSERT INTO $tableName_data (voltage, current, temperature, humidity)
    VALUES ('$voltage', '$current', '$temperature', '$humidity')";

    if ($conn->query($sql_insert) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }

} else {
    echo "Error: POST data is missing.";
}

$conn->close();
?>
