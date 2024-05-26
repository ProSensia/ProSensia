<?php
session_start();





if($_SERVER["REQUEST_METHOD"] == "POST")
{$user_id=$_SESSION['user_id'];
    $macadd = $_POST['mac_address'];
    $location = $_POST['location'];
    // $mac = $_POST['mac'];

include "./partials/db_conn.php";

$query  = "SELECT `device_code` FROM `deviceslist` WHERE  `device_code`='$macadd'"; // to select username from table

$check = mysqli_query($conn, $query);

if ($check->num_rows > 0) // checks if user name already exists or not
{

    echo "already exsisits";
    header("location:multidevices.php");
}
else
{

    if(!empty($macadd) || !empty($location) )
    {
        $insert_into_device_table=$conn->prepare("INSERT INTO `deviceslist` (`userid`,`device_code`,`location`) VALUES  (?,?,?) ");
        $insert_into_device_table->bind_param("sss", $user_id,$macadd,$location);
        if ($insert_into_device_table->execute()) {
    echo "data saved";
          } else {
            echo $conn->error;
          }
      
          $insert_into_device_table->close();
    
    
    
    // Sanitize MAC address to use it as a table name
    // $mac_sanitized = str_replace(':', '_', $macadd);
    // $tableName =   $mac_sanitized;
    
    // Create table query with starttime and endtime columns
    $sql = "CREATE TABLE IF NOT EXISTS $macadd (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        voltage FLOAT NOT NULL,
        current FLOAT NOT NULL,
        temperature FLOAT NOT NULL,
        humidity FLOAT NOT NULL,
        relay BOOLEAN NOT NULL,
        starttime DATETIME DEFAULT NULL,
        endtime DATETIME DEFAULT NULL,
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "Table $macadd created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
    
    // if(!empty($mac))
    // {
    //     $voltage = $_POST['voltage'];
    // $current = $_POST['current'];
    // $temperature = $_POST['temperature'];
    // $humidity = $_POST['humidity'];
    // $relay = $_POST['relay'];
    
    //     $sql = "INSERT INTO $tableName (voltage, current, temperature, humidity, relay)
    //     VALUES ('$voltage', '$current', '$temperature', '$humidity', '$relay')";
        
    //     if ($conn->query($sql) === TRUE) {
    //         echo "New record created successfully";
    //     } else {
    //         echo "Error: " . $sql . "<br>" . $conn->error;
    //     }
    // }
    // Insert data into table
    
    
    
          
          $conn->close();
    
    
    
    
    
    header("location:multidevices.php");
    
    }
    else
    {
        echo "enter data";
    }
    
}


}









// $conn->close();
?>
