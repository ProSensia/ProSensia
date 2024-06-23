<?php
// Database connection parameters
$hostname = "localhost";  // Change this to your MySQL server hostname
$username = "root";  // Change this to your MySQL username
$password = "";  // Change this to your MySQL password
$database = "prosensia";  // Change this to your database name

// Connect to MySQL database
$conn = new mysqli($hostname, $username, $password, $database);

// Check for database connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve JSON data sent from the JavaScript and decode it
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    foreach ($data as $item) {
        $class = $item['room'];
        $mac = $item['mac'];
        $onoff = $item['onoff'];

        // Prepare SQL query to insert data into the database
        $query = "INSERT INTO timetabledetection (Class, Mac, onoff) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);

        // Check if the statement was prepared successfully
        if ($stmt) {
            // Bind parameters to the prepared statement
            $stmt->bind_param("sss", $class, $mac, $onoff);

            // Execute the prepared statement
            if (!$stmt->execute()) {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Error preparing statement: " . $conn->error;
        }

        // Close the statement
        $stmt->close();
    }

    echo "Data inserted successfully.";
} else {
    echo "No data received or data format is incorrect.";
}

// Close the database connection
$conn->close();
?>
