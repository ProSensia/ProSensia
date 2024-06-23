<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location:login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="src/style/dashboard.css">
    <title>Set Time</title>
</head>
<body>
<main class="dashboard_container">
    <aside class="option_container">
        <div class="logo">
            <img src="assets/images/3 1.png" alt="Logo">
        </div>

        <ul class="device_options" id="nav-menu">
            <li class="the_options" id="todashboard"><img src="src/images/dashboard.png" alt=""><span>Dashboard</span></li>
            <li class="the_options" id="devices"><img src="src/images/devices.png" alt=""><span>Devices</span></li>
            <li class="the_options" id="timetable"><img src="src/images/devices.png" alt=""><span>Timetable</span></li>
            <li class="the_options" id="settime"><img src="src/images/devices.png" alt=""><span>Set Time</span></li>
            <li class="the_options"><img src="src/images/profile.png" alt=""><span>Profile</span></li>
        </ul>
        <div class="prolog">
            <a href="logout.php" id="logoutbtn"><img src="src/images/logout.png" alt=""><span>Logout</span></a>
        </div>
    </aside>

    <section class="device_container">

        <div class="toppart">
            <div class="welcome">
                <h3>Dashboard <br>
                    Welcome <?php echo $_SESSION['username'] ?>
                </h3>
            </div>
            <div class="adddevice">
                <button id="add_device_button" onclick="to_add_device()">
                    <img src="src/images/plus.png" alt="" class="add_button_img">
                    <span>Add Device</span>
                </button>
            </div>
        </div>

        <div class="lowerpart">
            <div class="lower_part_0">
                <label class="switch">
                    <input type="checkbox" id="toggleSwitch" checked>
                    <span class="slider round"></span>
                </label>

                <form class="getdata_for_date" id="deviceForm" method="post">
                    <?php
                    $user_id = $_SESSION['user_id'];
                    include "./partials/db_conn.php";
                    $sql = "SELECT device_add_id, device_code FROM deviceslist WHERE `user_id`='$user_id'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        echo '<select id="device_select" name="my_select">';
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row["device_code"] . '">' . $row["device_code"] . '</option>';
                        }
                        echo '</select>';
                    } else {
                        echo "0 results";
                    }
                    $conn->close();
                    ?>
                </form>
            </div>

            <script>
               $(document).ready(function() {
    // Function to update switch state
    function updateSwitchState() {
        var selectedDevice = $('#device_select').val();
        $.ajax({
            url: 'update_switch.php',
            method: 'POST',
            data: {
                getSwitchState: true, // Signal to get current switch state
                deviceCode: selectedDevice
            },
            success: function(response) {
                var isChecked = response.trim() === '1'; // Check if response is '1'
                $('#toggleSwitch').prop('checked', isChecked);
            },
            error: function(xhr, status, error) {
                console.error("Error fetching switch state:", error);
            }
        });
    }

    // Initial update when document is ready
    updateSwitchState();

    // Change event for toggle switch
    $('#toggleSwitch').change(function() {
        var isChecked = $(this).is(':checked') ? 1 : 0;
        var selectedDevice = $('#device_select').val();
        $.ajax({
            url: 'update_switch.php',
            method: 'POST',
            data: {
                switchState: isChecked,
                deviceCode: selectedDevice
            },
            success: function(response) {
                console.log(response);
            },
            error: function(xhr, status, error) {
                console.error("Error updating switch state:", error);
            }
        });
    });
});

            </script>
        </div>

        <form action="setrelaytime.php" id="timersetting" method="post" class="timer_set">
        <label for="startdaterealy">Start Time</label>  
        <input type="datetime-local" name="startrealytime" id="startdaterealy">
        <label for="enddaterelay">End Time</label>  
        <input type="datetime-local" name="endrelaytime" id="enddaterelay">

        <?php
        
        $user_id = $_SESSION['user_id'];
        include "./partials/db_conn.php";
        $sql = "SELECT device_add_id, device_code FROM deviceslist WHERE `user_id`='$user_id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo '<select name="my_select">';
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . htmlspecialchars($row["device_code"]) . '">' . htmlspecialchars($row["device_code"]) . '</option>';
            }
            echo '</select>';
        } else {
            echo "0 results";
        }
        $conn->close();
        ?>

        <input type="submit" style="background-color: #FECE00; border:none;" value="Set">
    </form>

    <div id="response"></div>
    <div id="userList"></div>

    <script>
        $(document).ready(function() {
            $('#timersetting').on('submit', function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: 'setrelaytime.php',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#response').html(response);
                        loaddatatime(); // Display the response from the PHP script
                    },
                    error: function(xhr, status, error) {
                        $('#response').html('An error occurred: ' + error); // Display error message
                    }
                });
            });

            function loaddatatime() {
                $.ajax({
                    url: 'display_timer.php',
                    type: 'GET',
                    success: function(response){
                        $('#userList').html(response); // Display the list of users
                    },
                    error: function(xhr, status, error){
                        $('#userList').html('An error occurred: ' + error); // Display error message
                    }
                });
            }

            // Load timer data on page load
            loaddatatime();
        });
    </script>

    <script>
$(document).ready(function() {
    $(document).on('click', '.deleteBtn', function() {
        var timerId = $(this).data('id');
        var device_name_code=$(this).data('name');
        var listItem = $(this).closest('li');
        $.ajax({
            url: 'delete_timer.php',
            type: 'POST',
            data: { id: timerId, name:device_name_code },
            success: function(response) {
                if (response == 'success') {
                    listItem.remove();
                } else {
                    alert('Failed to delete timer.');
                }
            }
        });
    });
});
    
</script>
</section>
</main>
</body>
</html>
