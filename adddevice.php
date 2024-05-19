<?php
include "./partials/db_conn.php";
$device_code=$_POST['devicecode'];

$sql="INSERT INTO DEVICEsLIST (device_code) VALUES ('$device_code') ";

if ($conn->query($sql) === TRUE) {
    echo "Data saved successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>