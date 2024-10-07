<?php
include('config.php');
session_start();
if(!isset($_SESSION["username"])){
    header("Location:../index.php");
}
$edit_access = ' <div class="button-group">
                                            <button type="button" id="delete_day">Delete Day</button>
                                            <button type="button" id="delete_Event">Delete Event</button>
                                            <!-- <button type="button" id="update_Event">Edit Event</button> -->
                                            <button type="button" id="update_form">Edit Day</button>
                                        </div>';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Time based Unit</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Favicon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" />
    <link rel="shortcut icon" href="https://templates.iqonic.design/calendify/html./assets/images/favicon.ico" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/backend.minf700.css?v=1.0.1">
    <link rel="stylesheet" href="./assets/vendor/%40fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="./assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="./assets/vendor/remixicon/fonts/remixicon.css"> <!-- Fullcalender CSS -->
    <link rel='stylesheet' href='./assets/vendor/fullcalendar/core/main.css' />
    <link rel='stylesheet' href='./assets/vendor/fullcalendar/daygrid/main.css' />
    <link rel='stylesheet' href='./assets/vendor/fullcalendar/timegrid/main.css' />
    <link rel='stylesheet' href='./assets/vendor/fullcalendar/list/main.css' />
    <link rel='stylesheet' href='./assets/css/custom.css' />
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css' />


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <style>
        
        /* Modal Centering */
        .modal-dialog-centered {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        /* Modal Content Styling */
        .modal-content {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        /* Form Input Fields */
        .form-control {
            width: 100%;
            padding: 8px 12px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        /* Form Labels */
        .form-label {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        /* Button Styles */
        button {
            padding: 8px 16px;
            border-radius: 5px;
            border: none;
                       color: white;
            font-size: 14px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
            color: #fff;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .modal-dialog-centered {
                margin: 20px;
            }

            .modal-content {
                width: 100%;
            }
        }

        /* Wrapper for the navbar */
        .wrapper {
            position: relative; /* Ensure positioning context for child elements */
            background-color: #ffffff;
            border-bottom: 1px solid #eaeaea;
            padding: 10px 0;
        }

        /* Container styling */
        .iq-top-navbar .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* Navbar styling */
        .iq-navbar-custom {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Logo Styling */
        .iq-navbar-logo img {
            height: 50px;
            margin-right: 8px;
        }

        /* Dark mode toggle switch */
        .change-mode .custom-control-label {
            display: flex;
            align-items: center;
            cursor: pointer;
            font-size: 14px;
        }

        /* Buttons container */
        .navi {
            display: flex;
            gap: 10px; /* Space between buttons */
            position: absolute;
            right: 20px; /* Fix the buttons at the right side */
            top: 15px;
        }
           /* Buttons container */
           .change-mode {
            display: flex;
           
            gap: 10px; /* Space between buttons */
            position: absolute;
            right: 300px; /* Fix the buttons at the right side */
            top: 15px;
        }

        /* Button styles */
        #h-btn, #l-btn, #btn1, #btn2 {
            padding: 6px 20px;
                       color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        /* Button hover effect */
        #h-btn:hover, #l-btn:hover, #btn1:hover, #btn2:hover {
            background-color: #0056b3;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .iq-navbar-custom {
                flex-direction: column;
                align-items: flex-start;
            }

            .navi {
                position: static;
                margin-top: 10px;
                flex-wrap: wrap;
            }
        }
    </style>

</head>


<body class="fixed-top-navbar top-nav  ">
    <script>
        var calendar1
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar1');

            calendar1 = new FullCalendar.Calendar(calendarEl, {
                selectable: true,
                plugins: ["timeGrid", "dayGrid", "interaction"],
                timeZone: "UTC",
                defaultView: "dayGridMonth",
                contentHeight: "auto",
                eventLimit: true,
                dayMaxEvents: 4,
                header: {
                    left: "prev,next today",
                    center: "title",
                    right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek"
                },
                eventClick: function(info) {
                    //var event_id=$('#event_id').val();
                    $('#schedule-start-sss').prop('disabled', true);
                    $('#schedule-end-sss').prop('disabled', true);
                    $('#schedule-Notallowed-sss').prop('disabled', true);
                    $('#audioFile_edit').prop('disabled', true);
                    var eventid = {
                        "id": info.event.id
                    };
                    console.log(eventid);
                    $.ajax({
                        type: 'POST',
                        url: "popup.php",
                        data: eventid,  //show the data in the popup default is json
                        success: function(response) {
                            //console.log(response);
                            const jsonObject = JSON.parse(response);
                            console.log(jsonObject);
                            const id = jsonObject[0].id;
                            const event_id = jsonObject[0].event_id;
                            const mes = jsonObject[0].message;
                            const startdate = jsonObject[0].startdate;
                            const enddate = jsonObject[0].enddate;
                            const notallowed = jsonObject[0].notallowed;
                            const times = jsonObject[0].timing;
                            const colour = jsonObject[0].colour;
                            const audioName = jsonObject[0].audioname;
                            const bellid     = jsonObject[0].bellid;
                            const paulid     = jsonObject[0].paulid;
                            const adhikaramid     = jsonObject[0].adhikaramid;
                            const thirukkuralid     = jsonObject[0].thirukkuralid;
                            const audio = jsonObject[0].audio;
                            const min_date = jsonObject[1].min_startdate;
                
                            $('#date-event1 #schedule-title-sss').val(mes);
                            $('#date-event1 #schedule-start-sss').val(min_date); //--fecth data from database show the min_date limit
                            $('#date-event1 #schedule-end-sss').val(enddate);
                            $('#date-event1 #schedule-Notallowed-sss').val(notallowed);
                            $('#date-event1 #schedule-timinigs-sss').val(times);
                            $('#date-event1 #schedule-color-sss').val(colour);
                            $('#date-event1 #audioPath').val(audio);
                            $('#edit_id').val(id);
                            //$('#mindate_id').val(min_date);
                            const data = {
                    bellid: bellid,
                    paulid: paulid,
                    adhikaramid: adhikaramid,
                    thirukkuralid: thirukkuralid
                };
                // Send data to iframe once it's loaded
                sendDataToIframe(data);
                            $('#event_id').val(event_id)
                            $('#showaudio').attr('href', audio);
                            console.log("check the data",bellid,paulid,adhikaramid,thirukkuralid);
                            document.getElementById('showaudio').textContent = audioName;
                        },
                    });
                    $('#date-event1').modal('show')
                },
                dateClick: function(info) {
                    $('#schedule-start-date').val(info.dateStr)
                    $('#schedule-end-date').val(info.dateStr)
                    $('#date-event').modal('show')
                },
                events: [
                    <?php
                    $sql = "SELECT * FROM taskmanager";
                    $result = mysqli_query($conn, $sql);
                    $events = array();
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $events[] = $row;
                        }
                    }
                    // Output the JavaScript code
                    foreach ($events as $event) {
                        $startDate = date('m/d/Y', strtotime($event['startdate']));
                        echo "{\n";
                        echo "    id: '" . $event['id'] . "',";
                        echo "    title: '" . $event['message'] . "',";
                        echo "    start: '" . $event['startdate'] . 'T' . $event['timing'] . '.000Z' . "',";  //--start date for default 
                        echo "    end: '" . $event['startdate'] . 'T' . $event['timing'] . '.000Z' . "',";
                        echo "    color: '" . $event['colour'] . "',";
                        echo "    notallowed: '" . $event['notallowed'] . "',";
                        echo "    timing: '" . $event['timing'] . "',";
                        echo "},\n";
                    }

                    mysqli_close($conn);
                    ?>
                ]
            });
            calendar1.render();
        });
        function sendDataToIframe(data) {
            const iframe = document.getElementById('data-iframe');
            iframe.contentWindow.postMessage(data, '*');
        }
        $(document).on("submit", "#submit-schedule", function(e) {
            $('.js-example-basic-single').select2();
            e.preventDefault()
            const title = $(this).find('#schedule-title').val() //schedule title message
            const timing = $(this).find('#schedule-timinigs').val() //schedule time acc
            const startDate = moment(new Date($(this).find('#schedule-start-date').val()), 'YYYY-MM-DD').format('YYYY-MM-DD') + "T" + $(this).find('#schedule-timinigs').val() + ':00.000Z'
            const endDate = moment(new Date($(this).find('#schedule-end-date').val()), 'YYYY-MM-DD').format('YYYY-MM-DD') + "T" + $(this).find('#schedule-timinigs').val() + ':00.000Z'
            const color = $('#schedule-color').val() //message colour
            const notallowed = $(this).find('#NotAllowedDate').val() //not allowed date from user
            const formDataArray = [];
            var startDatecheck = new Date(startDate);
            var endDatecheck = new Date(endDate);
            // console.log("sumbit check", $('#schedule-color').val());
            if (!(notallowed.trim() === "")) {
                const splitarray = notallowed.split(',');
                for (i = 0; i < splitarray.length; i++) { //check array have vaild date within startdate and endate.
                    try {
                        var notallowedcheck = new Date(splitarray[i].trim());
                        if (notallowedcheck >= startDatecheck && notallowedcheck <= endDatecheck) {
                            formDataArray.push(splitarray[i]);
                        } else {
                            alert("Invaild Date Enter: Format is [dd/mm/yyyy] ex:[06/11/2024,08/12/2024]");
                            return;
                        }
                    } catch (e) {
                        alert("Invaild Date Enter: Format is [dd/mm/yyyy] ex:[12/11/2024,08/12/2024]");
                        return;
                    }
                }
            }
            console.log("formdata:", formDataArray);
            var checkboxes = document.querySelectorAll('.form-check-input');
            var checkedValues = [];
            checkboxes.forEach(function(checkbox) {
                // Check if the checkbox is checked
                if (checkbox.checked) {
                    checkedValues.push(checkbox.value);
                }
            });
            var checksat = document.querySelectorAll('.form-check-sat');
            var checksatvalue = [];
            checksat.forEach(function(checksatdata) {
                if (checksatdata.checked) {
                    checksatvalue.push(checksatdata.value);
                }
            })
            const event = {
                title: title,
                start: startDate,
                end: endDate,
                color: color || '#7858d7',
                time: timing,
                notallowed: notallowed
            }
            $(this).closest('#date-event').modal('hide')
            // calendar1.addEvent(event)
            var formData = new FormData();
            formData.append("title", title);
            formData.append("start", $(this).find('#schedule-start-date').val());
            formData.append("end", $(this).find('#schedule-end-date').val());
            formData.append("colour", color); //["notallowed"]=notallowed; 
            formData.append("notalloweddate", formDataArray);
            formData.append("timing", timing);
            formData.append("audioFile", $("#audioFile_pop")[0].files[0]);
            formData.append("days", checkedValues);
            formData.append("sat_day", JSON.stringify(checksatvalue));
            // alert("Checked values: " + checkedValues.join(', '));
            if (startDatecheck <= endDatecheck) {
                $.ajax({
                    type: "POST",
                    url: "backphp.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Handle the successful response
                        alert(response);
                        location.reload();
                        $('#date-event #schedule-title').val('');
                        $('#date-event #schedule-end-date').val('');
                        $('#date-event #schedule-Notallowed').val('');
                        $('#date-event #schedule-timinigs').val('');
                    },
                });
            } else {
                alert("Invaild Date Enter. Please Check Start Date and End Date");
            }
        })
    </script>



    <div id="loading">
        <div id="loading-center">
        </div>
    </div>	

<!--Csv Upload pop up -->
<!-- CSV Upload Pop-up -->
<div id="csv-upload">
    <fieldset>
        <form action="./csv_upload.php" enctype="multipart/form-data" method="post">
        <a href="./csv_template/template.csv" download="test.csv"> (example csv template) </a>
        <br>
           <h5>Csv Upload</h5><br>
            <input type="file" name="csv_file" accept=".csv">
            <center>
            <div style="display: inline-block; ">
            <button type="submit" name="upload" >Upload</button>
            <label id="close-popup">Cancel</lable>
            </center>    
        </div>
        </form>
       
    </fieldset>
</div>

<!-- Overlay background -->
<div id="popup-overlay"></div>

    <!-- loader END -->
<!-- Wrapper Start -->
<div class="wrapper">
    <div class="iq-top-navbar">
        <div class="container">
            <div class="iq-navbar-custom">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="iq-navbar-logo d-flex align-items-center justify-content-between">
                        <img src="./assets/images/logo.png" class="img-fluid rounded-normal light-logo" alt="logo">
                        <img src="./assets/images/logo-white.png" class="img-fluid rounded-normal darkmode-logo" alt="logo">
                    </div>
                    <nav class="navbar navbar-expand-lg navbar-light p-0">
                        <div class="change-mode">
                            <div class="custom-control custom-switch custom-switch-icon custom-control-indivne">
                                <div class="custom-switch-inner">   
                                    <input type="checkbox" class="custom-control-input" id="dark-mode" data-active="true">
                                    <label  class="custom-control-label" for="dark-mode" data-mode="toggle">
                                        <span class="switch-icon-left"><i class="a-left ri-moon-clear-line"></i></span>
                                        <span class="switch-icon-right"><i class="a-right ri-sun-line"></i></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="navi">
                            <form action="../index.php">
                                <button id="h-btn" type="submit">Home</button>
                            </form>
                            <form action="./Audio_Manager/callbacks/logout.php">
                                <button id="l-btn" type="submit">Logout</button>
                            </form>
                         
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>






    <div class="content-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="py-4 border-bottom">
                        <div class="form-title text-center">
                            <h3>My Schedule</h3>
                        </div>
                    </div>
                </div>
                <div class="content-page1">
                    <div class="col-lg-12">

                        <div class="d-flex flex-wrap align-items-center justify-content-between my-schedule mb-2 " style="margin-top: 6rem">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="form-group mb-0">

                                </div>
                                <div class="select-dropdown input-prepend input-append">
                                    <div class="btn-group">

                                        <ul class="dropdown-menu w-100 border-none p-3">
                                            <li>
                                                <div class="item mb-2"><i class="ri-pencil-line mr-3"></i>Edit</div>
                                            </li>
                                            <li>
                                                <div class="item"><i class="ri-delete-bin-6-line mr-3"></i>Delete</div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="create-workform">
                                <button class="calendar-settings-btn" onclick="$('#date-event3').modal('show')">Push Button Settings</button>
                                <a href="#" data-toggle="modal" data-target="#date-event" class="btn btn-primary pr-5 position-relative">New Schedule<span class="add-btn"><i class="ri-add-line"></i></span></a>
                                <button id="upload"   class="btn btn-primary pr-5 position-relative"> Csv Upload   <span><i id="ri-add-line" class="fa-solid fa-file-csv fa-bounce"></i></span></button>
                            
</div>
                        </div>
                        <h4 class="mb-3">Click Any Date to Set Schedule</h4>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-block card-stretch">
                                    <div class="card-body">
                                        <div id="calendar1" class="calendar-s"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="date-event" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <!-- <div class="popup text-left"> -->
                            <h4 class="mb-3">Add Schedule Date</h4>
                            <form action="https://templates.iqonic.design/" id="submit-schedule">
                                <!-- <div class="content create-workform row"> -->

                                <div class="form-group">
                                    <label class="form-label" for="schedule-title">Schedule Message For</label>
                                    <input class="form-control" placeholder="Enter Title Ex:National Day,Birthday.." type="text" name="message" id="schedule-title" required />
                                </div>
                                <!-- <div class="col-md-12"> -->
                                <div class="form-group">
                                    <label class="form-label" for="schedule-start-date">Start Date</label>
                                    <input type="date" type="text" name="startdate" id="schedule-start-date" required />
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="schedule-end-date">End Date</label>
                                    <input type="date" type="text" name="enddate" id="schedule-end-date" required />
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="schedule-timinigs">Schedule Timing</label>
                                    <input type="Time" span class="fc-time" name="timing" id="schedule-timinigs" required />
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="audio-file_pop">Schedule Audio For Announce</label><br>
                                    <input type="file" name="audioFile_pop" id="audioFile_pop" accept=".mp3,audio/*" required />
                                 
                                </div>

                                <div class="form-group">
                                    <div class="form-check" style="padding: 0px;">
                                        <label>Not Applicable Day: </label>
                                        <span><label class="form-check-label " style="margin-right: 20px;">
                                                ╿ Sun <input class="form-check-input" style="margin-left: 10px;" type="checkbox" value="Sun" id="flexCheck1">
                                            </label> ╿ </span>
                                        <span><label class="form-check-label" style="margin-right: 20px;">
                                                Mon <input class="form-check-input" style="margin-left: 10px;" type="checkbox" value="Mon" id="flexCheck2">
                                            </label> ╿ </span>
                                        <span> <label class="form-check-label " style="margin-right: 20px;">
                                                Tue <input class="form-check-input" style="margin-left: 10px;" type="checkbox" value="Tue" id="flexCheck3">
                                            </label> ╿ </span>
                                        <span><label class="form-check-label " style="margin-right: 20px;">
                                                Wed <input class="form-check-input" style="margin-left: 10px;" type="checkbox" value="Wed" id="flexCheck4">
                                            </label> ╿ </span>
                                        <span><label class="form-check-label" style="margin-right: 20px;">
                                                Thu <input class="form-check-input" style="margin-left: 10px;" type="checkbox" value="Thu" id="flexCheck5">
                                            </label> ╿ </span>
                                        <span><label class="form-check-label" style="margin-right: 20px;">
                                                Fri <input class="form-check-input" style="margin-left: 10px;" type="checkbox" value="Fri" id="flexCheck6">
                                            </label> ╿ </span>
                                        <span><label class="form-check-label " style="margin-right: 20px;">
                                                Sat <input class="form-check-input" style="margin-left: 10px;" type="checkbox" value="Sat" id="flexCheck7">
                                            </label> </span>
                                    </div>
                                </div>
                                <div class="form-group" id="notApplicableSat">
                                    <div class="form-check" style="padding: 0px;">
                                        <label>Not Applicable Sat: </label>
                                        <span class='box'><label class="form-check-label">
                                                ╿ 1 Sat <input class="form-check-sat" type="checkbox" value="1" id="flexCheck9">
                                            </label> ╿ </span>
                                        <span class='box'><label class="form-check-label">
                                                2 Sat <input class="form-check-sat" type="checkbox" value="2" id="flexCheck10">
                                            </label> ╿ </span>
                                        <span class='box'><label class="form-check-label">
                                                3 Sat <input class="form-check-sat" type="checkbox" value="3" id="flexCheck11">
                                            </label> ╿ </span>
                                        <span class='box'><label class="form-check-label">
                                                4 Sat <input class="form-check-sat" type="checkbox" value="4" id="flexCheck12">
                                            </label> ╿ </span>
                                        <span class='box'><label class="form-check-label">
                                                5 Sat <input class="form-check-sat" type="checkbox" value="5" id="flexCheck13">
                                            </label> </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="schedule-title">Please Enter Date (Audio Disabled)</label>
                                    <input class="form-control" placeholder="Enter Date. Do Not Play Audio Date (Ex- dd/mm/yyyy) - 24/12/2023,08/12/2024 .(Optional)." type="text" name="message" id="NotAllowedDate" />
                                </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Select Colour Unique Identification</label>
                                <input class="form-control" type="color" name="title" id="schedule-color" />
                            </div>
                        </div>

                        <div class="col-md-12 mt-4">
                            <div class="d-flex flex-wrap align-items-ceter justify-content-center">
                            <button class="btn btn-outline-primary mr-4" type="submit">Save</button>
                                <button class="btn btn-primary mr-4" data-dismiss="modal">Cancel</button>
                                <!-- <button class="btn btn-primary mr-4" data-dismiss="modal">Delete</button> -->
                                <!-- <button class="btn btn-primary mr-4" id="editButton" data-dismiss="modal">Edit</button> -->
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>


    <!-- popup one -->
    <div class="modal fade" id="date-event1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="popup text-left">
                        <h4 class="mb-3">Edit Message</h4>
                        <input type="hidden" id="edit_id">
                        <input type="hidden" id="event_id">
                        <input type="hidden" id="audioPath">
                        <input type="hidden" id="mindate_id">
                        <form action="https://templates.iqonic.design/" id="edit-schedule">
                            <div class="content create-workform row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="schedule-title">Schedule Message For</label>
                                        <input class="form-control" placeholder="Enter Title Ex:National Day,Birthday.." type="text" name="message" id="schedule-title-sss" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="schedule-start-sss">Start Date</label>
                                        <input type="date" value="09/10/2023" type="text" name="startdate" id="schedule-start-sss" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="schedule-end-sss">End Date</label>
                                        <input type="date" value="2023-011-20" type="text" name="enddate" id="schedule-end-sss" required />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="schedule-timinigs">Schedule Timing</label><br>
                                        <input type="Time" span class="fc-time" name="timing" id="schedule-timinigs-sss" required />
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="audio-file">Audio File</label><br>
                                        <input type="file" name="audioFile_edit" id="audioFile_edit" accept=".mp3,audio/*" /><br>
                                        <br>
                                       <!-- <div style="display: flex; justify-content:space-around;">
                                         
                                            <p id="bellid" ></p>
                                            <p id="paulid" ></p>
                                            <p id="adhikaramid" ></p>
                                            <p id="thirukkuralid" ></p> prasanna
                                     
                                            </div> -->
                                            <iframe id="data-iframe" src="iframe-content.html" title="Data Iframe" style="width: 100%; height: 60px; border: none;"></iframe> 
                                    </div>
                                    <div>
                                        <div class="form-group">
                                            <a href="" id="showaudio"></a>
                                        </div>

                                       
                                    <div class="form-group">
                                        <label class="form-label" for="schedule-title">Please Enter Date (Audio Disabled)</label>
                                        <input class="form-control" placeholder="Enter Date Don't to Want Play Audio" type="text" name="message" id="schedule-Notallowed-sss" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input class="form-control" type="color" name="title" id="schedule-color-sss" />
                                    </div>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <!-- <div class="d-flex flex-wrap align-items-ceter justify-content-center"> -->
                                    <div class="button">
                                        <!-- <button class="btn btn-primary mr-4" data-dismiss="modal">Cancel</button> -->
                                         <?php
                                         if(isset($_SESSION["usertype"])){
                                            if($_SESSION['usertype'] == 0){
                                                echo $edit_access;
                                            }else{
                                                echo '';
                                            }
                                         }else{
                                            echo '';
                                         }
                                         ?>
                                       
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>


    <!--Push button setting html-->

    <div class="modal fade" id="date-event3" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="popup text-left">
                        <h4 class="mb-3">Push Button Setting</h4>
                        <form id="submit-schedule-gpio">
                            <div class="content create-workform row"></div>
                            <div class="form-group">
                                <label for="audioUpload1">Audio Plays On First Push Button Press:</label>
                                <input type="file" id="audioUpload1" accept=".mp3,audio/*" required/> <!-- required -->
                                <a href="" id="gpiostartaudio"></a>
                            </div>
                            <div class="form-group">
                                <div>
                                    <label>Time Interval Between Two Audio:</label>
                                    <button type="button" id="minusButton" class="button">-</button>
                                    <span id="counter">0</span>
                                    <button type="button" id="plusButton" class="button">+</button>
                                    <label>Minutes</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <span>Every 30 Second Play the Sound</span>
                                    <label class="switch">
                                        <input type="checkbox" id="playOnce" checked>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group" id="audioDiv">
                                <label for="audioUpload1">Audio for Every 30 Second: </label>
                                <input type="file" id="audioUpload3" accept=".mp3,audio/*"/>
                                <a href="" id="gpiomiddleaudio"></a>
                            </div>
                            <div class="form-group">
                              <label for="audioUpload2">Audio Play After Button Press</label>
                              <input type="file" id="audioUpload2" accept=".mp3,audio/*" required/> <!--  -->
                              <a href="" id="gpioendaudio"></a>
                            </div>
                            <div class="form-group">
                                <div>
                                    <div class="form-group">
                                        <label> Self Test : </label>
                                        <button type="button" id="selfTest">Test</button>
                                    </div>
                                    <div class="form-group">
                                        <div class="button-container" style="justify-content: center;">
                                        <button class="btn btn-outline-primary mr-4" type="submit">Submit</button>
                                            <button class="btn btn-primary mr-4" data-dismiss="modal">Cancel</button>
                                           
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Gpio Pop-->


    <script src="./assets/js/backend-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js"></script>
    <!-- Chart Custom JavaScript -->
    <script src="./assets/js/customizer.js"></script>

    <!-- Fullcalender Javascript -->
    <script src='./assets/vendor/fullcalendar/core/main.js'></script>
    <script src='./assets/vendor/fullcalendar/daygrid/main.js'></script>
    <script src='./assets/vendor/fullcalendar/timegrid/main.js'></script>
    <script src='./assets/vendor/fullcalendar/list/main.js'></script>
    <script src='./assets/vendor/fullcalendar/interaction/main.js'></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js">             </script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <!-- app JavaScript -->
    <script src="./assets/js/app.js"></script>
    <script>

 document.addEventListener('DOMContentLoaded', function () {
        const popup = document.getElementById('csv-upload');
        const overlay = document.getElementById('popup-overlay');
        const openButton = document.getElementById('upload'); // Changed to 'upload'
        const closeButton = document.getElementById('close-popup');

        // Function to open the pop-up
        function openPopup(event) {
            event.preventDefault(); // Prevents the default anchor action
            popup.classList.add('active');
            overlay.classList.add('active');
        }

        // Function to close the pop-up
        function closePopup() {
            popup.classList.remove('active');
            overlay.classList.remove('active');
        }

        // Open pop-up when clicking the "Upload CSV" button
        openButton.addEventListener('click', openPopup);

        // Close pop-up when clicking the "Cancel" button
        closeButton.addEventListener('click', closePopup);

        // Close pop-up when clicking outside of the pop-up
        overlay.addEventListener('click', closePopup);
    });


        document.getElementById('flexCheck7').addEventListener('change', function() {
            var notApplicableSatDiv = document.getElementById('notApplicableSat');
            if (this.checked) {
                notApplicableSatDiv.style.display = 'none';
            } else {
                notApplicableSatDiv.style.display = 'block';
            }
        });
        let count = 0;
        var  toggleValue = 0;
        $(document).ready(function() {
            $.ajax({
                url: "gpio_api.php",
                dataType: "json",
                success: function(data) {
                    const gpioData = data[0]; // Assuming data is an array and we need the first object
                    const gpio_startaudio = gpioData.start_audio; // Correct key based on your API response
                    const gpio_endaudio = gpioData.end_audio;
                    const gpio_twicestatus = gpioData.button_status;
                    const gpio_middleaudio = gpioData.middle_audio;
                    const gpio_timeinterval = gpioData.time_interval;
                    toggleValue = gpioData.button_status;
                    count = gpio_timeinterval;
                    $("#gpioendaudio").attr("href", gpio_endaudio).text(gpio_endaudio);
                    $("#gpiostartaudio").attr("href", gpio_startaudio).text(gpio_startaudio);
                    $("#gpiomiddleaudio").attr("href", gpio_startaudio).text(gpio_middleaudio);
                    $("#playOnce").prop("checked", gpio_twicestatus === "1");
                    if(gpio_twicestatus == 0){
                    $('#audioDiv').hide();
                    }
                    else{
                        $('#audioDiv').show();
                    }
                    $("#counter").text(gpio_timeinterval);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error fetching data:", textStatus, errorThrown);
                }
            });
        });
        $(document).ready(function() {
            $("#playOnce").change(function() {
                toggleValue = $(this).prop("checked") ? 1 : 0;
                if(toggleValue == 0){
                    $('#audioDiv').hide();
                }
                else{
                    $('#audioDiv').show();
                }
                console.log("Toggle value:", toggleValue);
            });
        });
        $('#minusButton').click(function() {
            if (count > 0) {
                count--;
                $('#counter').text(count);
            }
        });
        $('#plusButton').click(function() {
            count++;
            $('#counter').text(count);
        });
        $(document).on("submit", "#submit-schedule-gpio", function(e) {
            var checktoggle = 0;
            e.preventDefault(); // Prevent the default form submission
            const formData = new FormData();
            if (toggleValue){
                formData.append('isToggled', 1);
            } 
            else{
                formData.append('isToggled', 0);
            }
            formData.append('count', count);
            const audioUpload1 = $('#audioUpload1')[0].files[0];
            const audioUpload2 = $('#audioUpload2')[0].files[0];
            if(toggleValue){
                const audioUpload3 = $("#audioUpload3")[0].files[0]
                formData.append('middleaudio', audioUpload3);
            }
            else{
                formData.append('middleaudio',"");
                console.log("no third audio");
            }
            formData.append('startaudio', audioUpload1);
            formData.append('endaudio', audioUpload2);
            if (audioUpload1) {
                formData.append('startaudio', audioUpload1);
            }
            if (audioUpload2) {
                formData.append('endaudio', audioUpload2);
            }

            console.log("data", formData);
            $.ajax({
                url: 'gpio.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    alert(response);
                    location.reload();
                },
                error: function() {
                    console.error('An error occurred while sending the data');
                }
            });
    });
        $(document).ready(function() {
            $("#selfTest").click(function() {
                const formData = new FormData();
                formData.append('selftest', 1);
                $.ajax({
                    url: 'gpio.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log("First Ajax call")
                    },
                    error: function() {
                        console.error('An error occurred while sending the data');
                    }
                });
                setTimeout(function() {
                    const formData1 = new FormData();
                    formData1.append('selftest', 0);
                    $.ajax({
                        url: 'gpio.php',
                        type: 'POST',
                        data: formData1,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            alert(response);
                        },
                        error: function() {
                            console.error('An error occurred while sending the data');
                        }
                    });
                }, 500);
            });
        });

        $('#update_Event').on('click', function() {
            var audioFile = $("#audioFile_edit")[0].files[0];

            var formData = new FormData();

            formData.append("id", $('#edit_id').val());
            formData.append("event_id", $('#event_id').val());
            formData.append("startdate", $('#schedule-start-sss').val());
            formData.append("enddate", $('#schedule-end-sss').val());
            formData.append("notallowed", $('#schedule-Notallowed-sss').val());
            formData.append("exitpath", $('#audioPath').val());
            formData.append("message", $('#schedule-title-sss').val());
            formData.append("colour", $('#schedule-color-sss').val());
            formData.append("times", $('#schedule-timinigs-sss').val()); //showaudio
            formData.append("audioname", document.getElementById('showaudio').textContent);
            if (audioFile) {
                formData.append("audioFile", audioFile);
            } else {
                formData.append("audioFile", "");
            }
            $(this).closest('#date-event1').modal('hide')

            $.ajax({
                type: "POST",
                url: "updatefull_event.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    alert(response);
                    location.reload();
                },
            });
        });
        $('#update_form').on('click', function() {
            var message = $('#schedule-title-sss').val();
            var startdate = $('#schedule-start-sss').val();
            var times = $('#schedule-timinigs-sss').val();
            var edit_id = $('#edit_id').val();
            var colour_edit = $('#schedule-color-sss').val();
            var exit_path = $('#audioPath').val();
            console.log(exit_path);

            //         
            var formData = new FormData();
            formData.append("id", edit_id);
            formData.append("message", message);
            formData.append("colour", colour_edit); //["notallowed"]=notallowed; 
            formData.append("times", times);


            var audioFile = $("#audioFile_edit")[0].files[0];
            if (audioFile) {
                formData.append("audioFile", audioFile);
            } else {
                formData.append("audioFile", "");
            }
            $(this).closest('#date-event1').modal('hide')
            $.ajax({
                type: "POST",
                url: "update_event.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    location.reload();
                    alert(response);
                },
            });

        });
        $('#delete_day').on('click', function() {
            var edit_id = $('#edit_id').val();
            var deletedata = {
                "id": edit_id
            };
            $.ajax({
                type: "POST",
                url: "delete.php",
                data: deletedata,
                success: function(response) {
                    // Handle the response from the server
                    alert(response);
                    $(this).closest('#date-event1').modal('hide')
                    location.reload();
                }
            });
        });
        $('#delete_Event').on('click', function() {
            var delete_id = $('#edit_id').val();
            var delete_eventid = $('#event_id').val();
            var exitfile = $('#audioPath').val();
            // var delete_event={"id":delete_id};
            // var delete_whole={"event_id":delete_eventid};
            console.log(exitfile);
            var jsondelete = {
                eventid: delete_id,
                delete_event_id: delete_eventid,
                exitpath: exitfile
            }
            $.ajax({
                type: "POST",
                url: "delete.php",
                data: jsondelete,
                success: function(response) {
                    // Handle the response from the server
                    alert(response);
                    $(this).closest('#date-event1').modal('hide')
                    location.reload();
                }
            });
        });





    </script>
</body>

</html>