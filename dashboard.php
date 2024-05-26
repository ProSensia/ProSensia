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

                        Welcome <?php 
                        echo $_SESSION['username']  ?> 
                        </h3>
                </div>
                <div class="adddevice">
                    
                    <button id="add_device_button" onclick="to_add_device()"><img src="assets/logos/pngtree-vector-plus-icon-png-image_515260-removebg-preview.webp" alt="" class="add_button_img">
                    <span>Add Device</span>
                    </button>

<script>

function to_add_device() {
window.location.href="multidevices.php";
}

</script>





                </div>
            </div> 


            



            <div class="lowerpart">
                <div class="lower_part_1">




<!-- voltage display -->
<div class="meter">

<h3 id="voltage_display"></h3>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        setInterval(function() {
            // Make AJAX request to fetch data
            $.ajax({
                url: 'get_live_voltage.php',
                dataType: 'json',
                success:function(data) {
    if (typeof data === 'object' && 'voltage' in data) {
        $('#voltage_display').text('Voltage: ' + data.voltage + 'V');
        console.log("Voltage: " + data.voltage);
    } else {
        console.error("Unexpected response format:", data);
    }
    }
    ,
                error: function(xhr, status, error) {
                    console.error("Error fetching voltage data:", error);
                }
            });
        }, 1000); // Fetch data every 1 second (adjust as needed)
    });
</script>






</div>
                </div>

                <div class="lower_part_2">


<!-- humidity -->
<form class="getdata_for_date" action="javascript:void(0);" onsubmit="drawChart()" method="post">
    <input type="datetime-local" id="thedate" name="searchdatetime">
    <input type="submit" id="showdatasub" value="Search">
</form>
<div id="humidity"></div>


<script>
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    // Global variable to maintain the existing data
    var existingData = [];

    function drawChart() {
        $.ajax({
            url: 'humidity_live.php',
            type: 'POST',
            data: {
                searchdatetime: $('#thedate').val() // Send the datetime if provided
            },
            dataType: 'json',
            success: function(data) {
                console.log("Data fetched from PHP:", data); // Log data to verify it is fetched correctly
                existingData = data; // Initialize existingData with fetched data
                drawChartWithData(existingData);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Failed to fetch data:", textStatus, errorThrown);
            }
        });
    }

    function drawChartWithData(jsonData) {
        var data2 = new google.visualization.DataTable();
        data2.addColumn('datetime', 'Time'); // Use 'datetime' for the time column
        data2.addColumn('number', 'Humidity');
        data2.addColumn('number', 'Temperature');

        // Convert the timestamp from string to JavaScript Date objects
        var rows = jsonData.map(function(row) {
            return [new Date(row[0]), row[1], row[2]];
        });

        data2.addRows(rows);

        var options = {
            hAxis: {
                title: 'Time',
                format: 'MMM dd, HH:mm', // Display date and time in a readable format
                gridlines: { count: 15 }
            },
            vAxis: {
                title: 'Values',
            },
            colors: ['#3366CC', '#DC3912'],
            vAxes: {
                0: { title: 'Humidity (%) & Temperature (C)' },
                1: { title: 'Temperature (C)', format: 'decimal' } // Separate y-axis for temperature if needed
            },
            series: {
                0: { targetAxisIndex: 0 },
                // 1: { targetAxisIndex: 1 }
            },
            interpolateNulls: true
        };

        var chart = new google.visualization.LineChart(document.getElementById('humidity'));
        chart.draw(data2, options);

        // Periodically update the chart every 5 seconds (adjust as needed)
        setInterval(function() {
            $.ajax({
                url: 'humidity_live.php',
                type: 'POST',
                data: {
                    searchdatetime: $('#thedate').val() // Send the datetime if provided
                },
                dataType: 'json',
                success: function(newData) {
                    console.log("Data fetched from PHP (update):", newData); // Log data to verify it is fetched correctly

                    // Append new data to the existing data
                    newData.forEach(function(row) {
                        var timestamp = new Date(row[0]).getTime();
                        if (!existingData.some(function(existingRow) { return new Date(existingRow[0]).getTime() === timestamp; })) {
                            existingData.push(row);
                        }
                    });

                    // Convert the timestamp from string to JavaScript Date objects
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
        }, 5000); // Update interval in milliseconds
    }
</script>


                </div>

            </div> 
         
        </section>
    </main>
</body>

</html>