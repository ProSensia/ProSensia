<?php
include "./partials/headers.php";

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
                <img src="assets/images/3 1.png" alt="">
            </div>
            <div class="device_options">

                <li class="the_options"><img src="assets/logos/dashboard.webp" alt=""><span>Dashboard</span></li>
                <li class="the_options" id="devices" > <img src="assets/logos/settings.webp" alt=""> <span>  Devices</span></li>
                <li class="the_options"> <img src="assets/logos/user.webp" alt=""><span> Profile</span></li>

            </div>

<script>
    let devices=document.getElementById("devices");
    devices.addEventListener("click",()=>{
window.location.href="multidevices.php";
    })
</script>

            <div class="prolog">
              
                <a href="logout.php" id="logoutbtn"><img src="assets/logos/018_128_arrow_exit_logout-512.webp" alt=""> <span> Logout</span></a>
            </div>
        </aside>


        <section class="device_container">

            <div class="toppart">
                <div class="welcome">
                    <h3>DashBoard <br>

                        Welcome </h3>
                </div>
                <div class="adddevice">
                    
                    <button id="add_device_button"><img src="assets/logos/pngtree-vector-plus-icon-png-image_515260-removebg-preview.webp" alt="" class="add_button_img">
                    <span>Add Device</span>
                    </button>
<form  id="add_form" method="post" action="">
                    <input id="add_device_input" type="text" name="devicecode" id="">
                    <input id="add_device_submit" type="submit"  value="Add">
                    </form>
                </div>
            </div> 

            <script>
    let add_device_button = document.getElementById("add_device_button");
    let add_form = document.getElementById("add_form");

    add_device_button.addEventListener("click", () => {
        add_device_button.style.display = "none";
        add_form.style.display = "flex";
    });

    add_form.addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent the form from submitting normally

        let add_form_data = new FormData(add_form); // Create FormData object with form data

        $.ajax({
            url: "adddevice.php",
            type: "POST",
            data: add_form_data,
            processData: false,
            contentType: false,
            success: function(data) {
                // console.log("success");
                alert("device added successfully");
            },
            error: function(xhr, status, error) {
                console.error("Error saving data:", error);
            }
        });

        
    });
</script>


            <div class="lowerpart">
                <div class="lower_part_1">



<!-- vibration graph -->

                      <?php 
                   include "partials/db_conn.php";
                    $sql = "SELECT vibration, time FROM sensor_data"; // Assuming your table has columns for vibration values and time in milliseconds
                    $result = $conn->query($sql);

                    $data = array();
                    while ($row = $result->fetch_assoc()) {
                        $vibration = (float)$row['vibration'];
                        $timeMilliseconds = (int)$row['time'];
                        $data[] = array($timeMilliseconds, $vibration);
                    }

                    $conn->close();
                    ?> 

                    <div id="chart_div_vibration"></div>

                    <script type='text/javascript'>
                        google.charts.load('current', {
                            'packages': ['corechart']
                        });
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                            var data = new google.visualization.DataTable();
                            data.addColumn('number', 'Time');
                            data.addColumn('number', 'Vibration Value');

                            var chartData = <?php echo json_encode($data); ?>;
                            data.addRows(chartData);

                            var options = {
                                title: 'Vibration Data',
                                hAxis: {
                                    title: 'Time',
                                    titleTextStyle: {
                                        color: '#333'
                                    }
                                },
                                vAxis: {
                                    title: 'Vibration Value',
                                    minValue: 0
                                }
                            };

                            var chart = new google.visualization.AreaChart(document.getElementById('chart_div_vibration'));
                            chart.draw(data, options);
                        }
                    </script>
<!-- voltage display -->
<div class="meter">

<h3 id="voltage_display"></h3>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        setInterval(function() {
            // Make AJAX request to fetch data
            $.ajax({
                url: 'get_live_voltage.php',
                dataType: 'json',
                success: function(data) {
                    if ('voltage' in data) {
                        $('#voltage_display').text('Voltage: ' + data.voltage + 'V');
                        // console.log("Voltage: " + data.voltage);
                    } else {
                        console.error("Unexpected response format: " + JSON.stringify(data));
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching voltage data:", error);
                }
            });
        }, 500); // Fetch data every 1 second (adjust as needed)
    });
</script>





</div>
                </div>

                <div class="lower_part_2">


<!-- humidity -->

<div id="humidity"></div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var jsonData;
        $.ajax({
            url: 'humidity_live.php', // Change this to the PHP file that fetches data
            dataType: 'json',
            success: function(data) {
                jsonData = data;
                drawChartWithData(jsonData);
                console.log(jsonData)
            }
        });
    }
    function drawChartWithData(jsonData) {
    var data2 = new google.visualization.DataTable();
    data2.addColumn('number', 'Time');
    data2.addColumn('number', 'Humidity');
    data2.addColumn('number', 'Temperature');
    data2.addRows(jsonData);

    var options = {
        hAxis: {
            title: 'Time'
        },
        vAxis: {
            title: 'Humidity ',
            
        },
        colors: ['#3366CC', '#DC3912'],
        vAxes: {
                0: {title: 'Humidity (%) & Temperature (°C)'}, // Label y-axis 0 for humidity
              
            },
            
    };

    var chart = new google.visualization.LineChart(document.getElementById('humidity'));
    chart.draw(data2, options);

    // Periodically update the chart every 5 seconds (adjust as needed)
    setInterval(function() {
        $.ajax({
            url: 'humidity_live.php',
            dataType: 'json',
            success: function(newData) {
                jsonData = newData;
                data2.removeRows(0, data2.getNumberOfRows());
                data2.addRows(jsonData);
                chart.draw(data2, options);
            }
        });
    }, 500); // Update interval in milliseconds
}
</script>
                </div>

            </div> 
         
        </section>
    </main>
</body>

</html>