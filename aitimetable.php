<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TimeTable Detection</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/luxon/2.3.0/luxon.min.js"></script>
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
        <li class="the_options" id="todashboard"><img src="src/images/dashboard.png" alt=""><span>Dashboard</span></li>
        <li class="the_options" id="devices"><img src="src/images/devices.png" alt=""><span>Devices</span></li>
        <li class="the_options" id="timetable"><img src="src/images/timetable.png" alt=""><span>Timetable</span></li>
        <li class="the_options"><img src="src/images/profile.png" alt=""><span>Profile</span></li>
    </div>
    <div class="prolog">
        <a href="logout.php" id="logoutbtn"><img src="assets/logos/018_128_arrow_exit_logout-512.webp" alt=""><span>Logout</span></a>
    </div>
</aside>  


        <section class="device_container">

            <div class="toppart">
                <div class="welcome">
                    <h3>DashBoard <br>

                        Welcome <?php 
                        echo $_SESSION['username']   ?> 
                        </h3>
                </div>
                <div class="adddevice">
                    
                    <button id="add_device_button" onclick="to_add_device()"><img src="src/images/plus.png" alt="" class="add_button_img">
                    <span>Add Device</span>
                    </button>

<script>

function to_add_device() {
window.location.href="multidevices.php";
}

</script>





                </div>
            </div> 


            



         
         
        </section>
    </main>
    <div class="container mt-5">
        <h1>TimeTable Detection</h1>
        <p>Click on the "Choose File" button to upload a file:</p>
        <input type="file" id="fileInput" class="form-control">
        <button id="processButton" class="btn btn-primary mt-3">Process File</button>
        <div id="results" class="mt-5"></div>
    </div>

    <script>
        document.getElementById('processButton').addEventListener('click', () => {
            const fileInput = document.getElementById('fileInput');
            if (fileInput.files.length === 0) {
                alert("Please choose a file first.");
                return;
            }

            const file = fileInput.files[0];
            const reader = new FileReader();
            reader.onload = (event) => {
                const data = new Uint8Array(event.target.result);
                const workbook = XLSX.read(data, { type: 'array' });
                const sheetName = workbook.SheetNames[0];
                const sheet = workbook.Sheets[sheetName];
                const jsonData = XLSX.utils.sheet_to_json(sheet);

                processSchedule(jsonData);
            };
            reader.readAsArrayBuffer(file);
        });

        function parseTime(timeStr) {
            return luxon.DateTime.fromFormat(timeStr.toUpperCase(), 'h:mma');
        }

        function isACNeededForRoom(schedule, currentTime) {
            const currentDay = currentTime.toFormat('cccc');
            const currentTimeStr = currentTime.toFormat('h:mma').toUpperCase();

            if (schedule[currentDay]) {
                for (let slot of schedule[currentDay]) {
                    const [startTimeStr, endTimeStr] = slot.split(' to ');
                    const startTime = parseTime(startTimeStr);
                    const endTime = parseTime(endTimeStr);

                    if (currentTime >= startTime && currentTime < endTime) {
                        return true;
                    }
                }
            }
            return false;
        }

        function processSchedule(data) {
            const schedule = {};
            for (let row of data) {
                const day = row['Day'];
                const startEvent = row['Start Event'];
                const endEvent = row['End Event'];
                const room = row['Room'];
                const mac = String(row['Mac']);

                if (!day || !startEvent || !endEvent || !room || !mac) {
                    console.error('Missing data in row:', row);
                    continue;
                }

                const roomKey = `${room}, ${mac}`;
                const slot = `${startEvent.toUpperCase()} to ${endEvent.toUpperCase()}`;

                if (!schedule[roomKey]) {
                    schedule[roomKey] = {};
                }
                if (!schedule[roomKey][day]) {
                    schedule[roomKey][day] = [];
                }
                schedule[roomKey][day].push(slot);
            }

            const pakistanTime = luxon.DateTime.now().setZone('Asia/Karachi');
            const results = [];
            const dataToSend = [];
            for (let roomKey in schedule) {
                const acStatus = isACNeededForRoom(schedule[roomKey], pakistanTime) ? 'Turn ON' : 'Turn OFF';
                results.push(`${roomKey} AC - ${acStatus}`);

                const [room, mac] = roomKey.split(', ');
                const onoff = acStatus === 'Turn ON' ? 1 : 0;
                dataToSend.push({ room, mac, onoff });
            }
            displayResults(results);
            sendDataToServer(dataToSend);
        }

        function displayResults(results) {
            const resultsContainer = document.getElementById('results');
            resultsContainer.innerHTML = '';
            for (let result of results) {
                const p = document.createElement('p');
                p.textContent = result;
                resultsContainer.appendChild(p);
            }
        }

        
        function sendDataToServer(data) {
            $.ajax({
                url: 'process_data.php',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function(response) {
                    console.log("Data sent to server successfully.", response);
                },
                error: function(xhr, status, error) {
                    console.error("Failed to send data to server.", error);
                }
            });
        }
    </script>


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
});
</script>

</body>
</html>
