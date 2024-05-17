


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

    <link rel="stylesheet" href="src/style/dashboard.css">
</head>

<body>
    <main class="dashboard_container">
        <aside class="option_container">
            <div class="logo">
                <img src="assets/images/3 1.png" alt="">
            </div>
            <div class="device_options">

                <li class="the_options"><img src="assets/logos/dashboard.png" alt="">Dashboard</li>
                <li class="the_options"> <img src="assets/logos/responsive.png" alt=""> Device</li>
                <li class="the_options"> <img src="assets/logos/settings.png" alt=""> Device Setting</li>

            </div>



            <div class="prolog">
                <a href="myprofile.php"> <img src="assets/logos/user.png" alt=""> My Profile</a>
                <a href="logout.php" id="logoutbtn">Logout</a>
            </div>
        </aside>


        <section class="device_container">

            <div class="toppart">
                <div class="welcome">
                    <h3>DashBoard <br>

                        Welcome <?php
// echo $_SESSION['username'];
?></h3>
                </div>
                <div class="adddevice">
                    <button>Add Device</button>
                </div>
            </div>
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
                    ?> -

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
            title: 'Humidity'
        },
        colors: ['#3366CC', '#DC3912'],
        vAxes: {
                0: {title: 'Humidity (%)'}, // Label y-axis 0 for humidity
                1: {title: 'Temperature (°C)'} // Label y-axis 1 for temperature
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