<?php
session_start();


if(!isset( $_SESSION['loggedin'])||$_SESSION['loggedin']!=true){
header("location:login.php");

}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="src/style/dashboard.css">
</head>

<body>
    <main class="dashboard_container">
    <aside class="option_container">
        <div class="logo">
            <img src="assets/images/3 1.png" alt="Logo">
        </div>

        <ul class="device_options" id="nav-menu">
            <li class="the_options" id="todashboard" ><img src="src/images/dashboard.png" alt=""><span>Dashboard</span></li>
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
                <h3>DashBoard <br>
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
            
            <!-- event listerners for side options -->
            

<script>
document.addEventListener("DOMContentLoaded", function() {
    let todashboard = document.getElementById("todashboard");
    todashboard.addEventListener("click", () => {
        window.location.href = "dashboard.php";
    });

    let timetable = document.getElementById("timetable");
    timetable.addEventListener("click", () => {
        window.location.href = "aitimetable.php";
    });

    let devices = document.getElementById("devices");
    devices.addEventListener("click", () => {
        window.location.href = "multidevices.php";
    });

let settime=document.getElementById("settime");
settime.addEventListener("click",()=>{
    window.location.href="settime.php";
})

});


function to_add_device()
{
     window.location.href = "multidevices.php";
}
</script>
            



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
                    echo '<option value="' . $row["device_code"] . '">' . $row["device_code"]  . '</option>';
                }
                echo '</select>';
            } else {
                echo "0 results";
            }
            $conn->close();
            ?>
        </form>
    </div>




 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Function to update switch state
        function updateSwitchState() {
            var selectedDevice = $('#device_select').val();
            $.ajax({
                url: 'update_switch.php',
                method: 'POST',
                data: {
                    getSwitchState: true,
                    deviceCode: selectedDevice
                },
                success: function(response) {
                    var isChecked = response.trim() === '1';
                    $('#toggleSwitch').prop('checked', isChecked);

                    // Store switch state in localStorage
                    localStorage.setItem('switchState', isChecked ? '1' : '0');
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

                    // Store switch state in localStorage
                    localStorage.setItem('switchState', isChecked ? '1' : '0');
                },
                error: function(xhr, status, error) {
                    console.error("Error updating switch state:", error);
                }
            });
        });

        // Retrieve and set switch state from localStorage on page load
        var storedSwitchState = localStorage.getItem('switchState');
        if (storedSwitchState !== null) {
            $('#toggleSwitch').prop('checked', storedSwitchState === '1');
        }
    });
</script>


                <div class="lower_part_1">

              
  <form action="setrelaytime.php" method="post" class="timer_set">
        <label for="startdaterealy">Start Time</label>  
        <input type="datetime-local" name="startrealytime" id="startdaterealy">
        <label for="enddaterelay">End Time</label>  
        <input type="datetime-local" name="endrelaytime" id="enddaterelay">

<?php

$user_id=$_SESSION['user_id'];

include "./partials/db_conn.php";
$sql = "SELECT device_add_id, device_code FROM deviceslist WHERE `user_id`='$user_id' ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // Start the select tag
        echo '<select name="my_select" >';

        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo '<option value="' . $row["device_code"] . '">' . $row["device_code"]  . '</option>';
        }

        // End the select tag
        echo '</select>';
    } else {
        echo "0 results";
    }

    // Close the connection
    $conn->close();
?>

        <input type="submit" style="background-color: #FECE00; border:none;" value="Set">
    </form>










<!-- voltage display -->
<!--<div class="meter">-->

<!--<h3 id="voltage_display"></h3>-->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>-->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->
<!--<script>-->
<!--    $(document).ready(function() {-->
<!--        setInterval(function() {-->
            <!--// Make AJAX request to fetch data-->
<!--            $.ajax({-->
<!--                url: 'get_live_voltage.php',-->
<!--                dataType: 'json',-->
<!--                success:function(data) {-->
<!--    if (typeof data === 'object' && 'voltage' in data) {-->
<!--        $('#voltage_display').text('Voltage: ' + data.voltage + 'V');-->
<!--        console.log("Voltage: " + data.voltage);-->
<!--    } else {-->
<!--        console.error("Unexpected response format:", data);-->
<!--    }-->
<!--    }-->
<!--    ,-->
<!--                error: function(xhr, status, error) {-->
<!--                    console.error("Error fetching voltage data:", error);-->
<!--                }-->
<!--            });-->
        <!--}, 1000); // Fetch data every 1 second (adjust as needed)-->
<!--    });-->
<!--</script>-->






<!--</div>-->
                </div>

                <div class="lower_part_2">


                    <form class="getdata_for_date" action="javascript:void(0);" onsubmit="drawChart()" method="post">
    <input type="datetime-local" id="thedate" name="searchdatetime">
    <?php
    $user_id=$_SESSION['user_id'];
    include "./partials/db_conn.php";
    $sql = "SELECT device_add_id, device_code FROM deviceslist WHERE `user_id`='$user_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo '<select id="device_select" name="my_select">';
        while($row = $result->fetch_assoc()) {
            echo '<option value="' . $row["device_code"] . '">' . $row["device_code"]  . '</option>';
        }
        echo '</select>';
    } else {
        echo "0 results";
    }
    $conn->close();
    ?>
    <input type="submit" id="showdatasub" value="Search">
</form>
<div id="humidity"></div>

                    
                          
                    
                    
<!-- humidity -->


<div id="humidity"></div>

<script>
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    var existingData = [];

    function drawChart() {
        var dateValue = $('#thedate').val();
        var deviceValue = $('#device_select').val(); // Get the selected device value

        if (!dateValue) {
            var currentDate = new Date();
            dateValue = currentDate.toISOString().slice(0, 10) + "T00:00";
        }

        $.ajax({
            url: 'humidity_live.php',
            type: 'POST',
            data: {
                searchdatetime: dateValue,
                device: deviceValue // Include the device value
            },
            dataType: 'json',
            success: function(data) {
                console.log("Data fetched from PHP:", data);
                existingData = data;
                drawChartWithData(existingData);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Failed to fetch data:", textStatus, errorThrown);
            }
        });
    }

    function drawChartWithData(jsonData) {
        var data2 = new google.visualization.DataTable();
        data2.addColumn('datetime', 'Time');
        data2.addColumn('number', 'Humidity');
        data2.addColumn('number', 'Temperature');

        var rows = jsonData.map(function(row) {
            return [new Date(row[0]), row[1], row[2]];
        });

        data2.addRows(rows);

        var options = {
            hAxis: {
                title: 'Time',
                format: 'MMM dd, HH:mm',
                gridlines: { count: 15 }
            },
            vAxis: {
                title: 'Values',
            },
            colors: ['#3366CC', '#DC3912'],
            vAxes: {
                0: { title: 'Humidity (%) & Temperature (C)' },
                1: { title: 'Temperature (C)', format: 'decimal' }
            },
            series: {
                0: { targetAxisIndex: 0 }
            },
            interpolateNulls: true
        };

        var chart = new google.visualization.LineChart(document.getElementById('humidity'));
        chart.draw(data2, options);

        setInterval(function() {
            var dateValue = $('#thedate').val();
            var deviceValue = $('#device_select').val(); // Get the selected device value

            $.ajax({
                url: 'humidity_live.php',
                type: 'POST',
                data: {
                    searchdatetime: dateValue,
                    device: deviceValue // Include the device value
                },
                dataType: 'json',
                success: function(newData) {
                    console.log("Data fetched from PHP (update):", newData);

                    newData.forEach(function(row) {
                        var timestamp = new Date(row[0]).getTime();
                        if (!existingData.some(function(existingRow) {
                            return new Date(existingRow[0]).getTime() === timestamp;
                        })) {
                            existingData.push(row);
                        }
                    });

                    var newRows = existingData.map(function(row) {
                        return [new Date(row[0]), row[1], row[2]];
                    });

                    data2.removeRows(0, data2.getNumberOfRows());
                    data2.addRows(newRows);
                    chart.draw(data2, options);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Failed to fetch data (update):", textStatus, errorThrown);
                }
            });
        }, 1000);
    }
</script>



                </div>

            </div> 
         
        </section>
    </main>
</body>

</html>