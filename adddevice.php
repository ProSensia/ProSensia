<?php
include "./partials/db_conn.php";
include "./partials/getmac.php";


$device_code=$mac;

$sql="INSERT INTO DEVICEsLIST (device_code) VALUES ('$device_code') ";

if ($conn->query($sql) === TRUE) {
    echo "Data saved successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$table_name = str_replace(":", "_", $mac);

    // Create a table for the device if it does not exist
    $create_table_sql = "CREATE TABLE IF NOT EXISTS `$table_name` (
        data_id INT AUTO_INCREMENT PRIMARY KEY,
        data_time DATETIME NOT NULL
    );";
    
    if ($conn->query($create_table_sql) === TRUE) {
        echo "Table $table_name created successfully<br>";
    } else {
        echo "Error creating table: " . $conn->error . "<br>";
    }



$conn->close();

?>