<?php
session_start();
include "partials/db_conn.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$recieve_data = "SELECT * FROM `deviceslist`";
$result = mysqli_query($conn, $recieve_data);
$devices_listed = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = $result->fetch_assoc()) {
        $device_id = $row["device_add_id"];
        $devices_listed[$device_id] = array(
            'device_add_id' => $row["device_add_id"],
            'device_code' => $row["device_code"],
            'location' => $row["location"]
        );
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="src/style/dashboard.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multiple Devices</title>
</head>
<body>
<main class="dashboard_container">
    <aside class="option_container">
        <div class="logo">
            <img src="assets/images/3 1.png" alt="">
        </div>
        <div class="device_options">
            <li class="the_options" id="todashboard">
                <img src="assets/logos/dashboard.webp" alt="">
                <span>Dashboard</span>
            </li>
            <li class="the_options" id="devices">
                <img src="assets/logos/settings.webp" alt="">
                <span>Devices</span>
            </li>
            <li class="the_options">
                <img src="assets/logos/user.webp" alt="">
                <span>Profile</span>
            </li>
        </div>

        <script>
            let todashboard = document.getElementById("todashboard");
            todashboard.addEventListener("click", () => {
                window.location.href = "dashboard.php";
            });

            let devices = document.getElementById("devices");
            devices.addEventListener("click", () => {
                window.location.href = "multidevices.php";
            });
        </script>

        <div class="prolog">
            <a href="logout.php" id="logoutbtn">
                <img src="assets/logos/018_128_arrow_exit_logout-512.webp" alt="">
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <section class="device_container">
        <div class="toppart">
            <div class="welcome">
                <h3>Dashboard <br>
                    Welcome <?php echo $_SESSION['username']; ?>
                </h3>
            </div>

            <div class="adddevice">
                <form id="add_form" action="data.php" method="post">
                    <input type="text" placeholder="MAC Address" name="mac" id="add_device_input" required>
                    <input type="text" placeholder="Location" name="location" id="device_location_input" required>
                    <input type="submit" value="Add" id="add_device_submit">
                </form>
            </div>
        </div>

        <div class="deviceslist">
            <?php foreach ($devices_listed as $device) : ?>
                <div class="devices_card">
                    <h3>MAC: <?php echo $device['device_code']; ?></h3>
                    <h3>Location: <?php echo $device['location']; ?></h3>
                    <a href="#">View Details</a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>
</body>
</html>
