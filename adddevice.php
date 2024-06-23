<?php
include "./partials/db_conn.php";

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$mac=$_POST['mac'];
$user_id=$_SESSION['user_id'];
$location=$_POST['location'];


$sql="INSERT INTO deviceslist (`user_id`,`device_code`,`location`) VALUES ('$user_id','$mac','$location') ";

if ($conn->query($sql) === TRUE) {
    echo "Data saved successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$mac_sanitized = str_replace(':', '_', $mac);
    $tableName_data = "device_data_" . $mac_sanitized;
    $tableName_control = "device_control_" . $mac_sanitized;

    // Create a table for the device if it does not exist
    $create_table_sql = "CREATE TABLE IF NOT EXISTS `$tableName_data` (
       id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        voltage FLOAT NOT NULL,
        current FLOAT NOT NULL,
        temperature FLOAT NOT NULL,
        humidity FLOAT NOT NULL,
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );";
      // Create control table query
      $sql_control_table = "CREATE TABLE IF NOT EXISTS $tableName_control (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        starttime TIMESTAMP NULL,
        endtime TIMESTAMP NULL,
       manual_override BOOLEAN NOT NULL,
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

if ($conn->query($create_table_sql) === TRUE && $conn->query($sql_control_table) === TRUE) {
    echo "Tables created successfully";
    header("location:multidevices.php");
} else {
    echo "Error creating tables: " . $conn->error;
}



$conn->close();

?>