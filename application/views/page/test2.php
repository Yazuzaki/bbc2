<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="images\BBCLOGO.jpg">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/flatpickr.min.css">
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.13.1/css/all.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <title>Reservation</title>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
            font-size: 14px;
        }




        .table-responsive {
            overflow: auto;
        }


        @media (max-width: 768px) {

            #calendar {
                font-size: 14px;
            }
        }

        .reserved-slot {
            background-color: #FFCCCC;
        }

        /* Base calendar styles */
        #calendar {
            max-width: 100%;
            margin: 20px 0;
            padding: 0 20px;
        }

        /* Responsive styles */
        @media (max-width: 767px) {

            /* Adjust calendar styles for screens smaller than 768px (e.g., mobile phones) */
            #calendar {
                padding: 0 10px;
                /* Decrease horizontal padding */
            }
        }

        @media (max-width: 992px) {

            /* Adjust calendar styles for screens smaller than 992px (e.g., tablets) */
            #calendar {
                padding: 0 15px;
                /* Decrease horizontal padding */
            }
        }


        .modal-dialog {
            max-width: 90%;
        }

        .modal-content {
            background-color: #fff;
            color: #333;
            border-radius: 10px;
        }

        .fc-day {
            cursor: pointer;
        }

        .past-date {
            color: #000000;
            background-color: #ffcccb;
        }

        .present-date {
            color: #000000;
            background-color: #90EE90;
        }

        .future-date {
            color: #000000;
            background-color: #DAF7A6;
        }

        .fc-day:hover {
            background-color: #eee;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #007BFF;
            border-color: #007BFF;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="table-responsive">
            <div id="calendar"></div>
        </div>
    </div>

    <div class="modal fade" id="reservationFormModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Make Reservation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="reservationForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="datetimePicker" class="form-label">Selected Date:</label>
                            <input type="text" id="datetimePicker" name="datetime" class="form-control" readonly>
                        </div>
                        <input type="time" id="timePicker" name="timePicker" class="form-select" required step="3600">

                        <div class="mb-3">
                            <label for="sport" class="form-label">Select Sport:</label>
                            <select id="sport" name="sport" class="form-select" required>
                                <?php foreach ($sports as $sport): ?>
                                    <option value="<?php echo $sport['sport_id']; ?>">
                                        <?php echo $sport['sport_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>


                            <div class="mb-3">
                                <label for="hours" class="form-label">Input Hours:</label>
                                <input type="number" name="hours" id="hours" class="form-control" min="1" max="12"
                                    required>
                            </div>

                        </div>
                        <div class="mb-3">
                            <label for="court" class="form-label">Select Court:</label>
                            <select id="court" name="court" class="form-select" required>
                                <?php foreach ($courts as $court): ?>
                                    <option value="<?php echo $court['court_id']; ?>">
                                        <?php echo $court['court_number']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div id="price-category"></div>
                        </div>

                        <div class="mb-3">
                            <label for="referenceNum" class="form-label">Reference Number Gcash 09060886262:</label>
                            <input type="file" id="referenceNum" name="referenceNum" class="form-control" required>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitReservation">Make Reservation</button>

                </div>
            </div>
        </div>
    </div>
    <!-- ... -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var timePicker = document.getElementById('timePicker');
            var hours = document.getElementById('hours');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                timeZone: 'UTC',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: ''
                },
                events: '<?php echo site_url("Page/get_reservations"); ?>',
                eventTimeFormat: {
                    hour: 'numeric',
                    minute: '2-digit',
                    meridiem: 'short'
                },
                initialView: 'dayGridMonth',
                views: {
                    timeGridDay: {
                        type: 'timeGrid',
                        dayHeaderFormat: { weekday: 'long' }
                    },
                    timeGridWeek: {
                        type: 'timeGrid',
                        dayHeaderFormat: { weekday: 'long' }
                    }
                },
                dateClick: function (info) {
                    var selectedDate = info.date;
                    var currentDate = new Date();
                    currentDate.setHours(0, 0, 0, 0);
                    selectedDate.setHours(0, 0, 0, 0);

                    if (selectedDate.getTime() < currentDate.getTime()) {
                        alert('You clicked on a past date.');
                    } else if (selectedDate.getTime() === currentDate.getTime()) {
                        alert('Reservations for the same day are not permitted.');
                    } else {
                        selectedDate.setHours(selectedDate.getHours() + 8);
                        var formattedDate = selectedDate.toISOString().split('T')[0];

                        var formModal = new bootstrap.Modal(document.getElementById('reservationFormModal'));
                        formModal.show();

                        var datetimePicker = document.getElementById('datetimePicker');
                        datetimePicker.value = formattedDate;
                        var selectedTime = timePicker.value;
                        var selectedHours = hours.value;

                        // Fetch reservations for the selected date
                        $.ajax({
                            type: 'POST',
                            url: 'get_reservations_for_date',
                            data: { date: selectedDate },
                            success: function (reservations) {
                                // Check if the selected time slot is available
                                var isTimeSlotAvailable = checkTimeSlotAvailability(reservations, selectedTime, selectedHours);

                                if (!isTimeSlotAvailable) {
                                    alert('Selected time slot is already reserved.');
                                    return;
                                }
                            },
                        });
                    }
                },
                dayCellClassNames: function (e) {
                    var today = new Date();
                    today.setHours(0, 0, 0, 0);
                    var cellDate = e.date;
                    cellDate.setHours(0, 0, 0, 0);

                    if (cellDate.getTime() < today.getTime()) {
                        return ['past-date'];
                    } else if (cellDate.getTime() === today.getTime()) {
                        return ['present-date'];
                    } else {
                        return ['future-date'];
                    }
                }
            });
            console.log('FullCalendar initialized successfully');

            calendar.render();
        });


    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/flatpickr.min.js"></script>



    </script>



    <script>

        var datetimePicker = document.getElementById('datetimePicker');
        var timePicker = document.getElementById('timePicker');
        var submitButton = document.getElementById('submitReservation');
        var courtElement = document.getElementById('court');
        var sportElement = document.getElementById('sport');
        var referenceNum = document.getElementById('referenceNum');
        var imageInput = document.getElementById('image');






        submitButton.addEventListener('click', function () {
            var selectedDate = datetimePicker.value;
            var selectedTime = timePicker.value;
            var selectedCourtId = courtElement.value;
            var selectedSportId = sportElement.value;
            var referenceNumInputId = referenceNum.value;
            console.log('Selected Court ID:', selectedCourtId);
            console.log('Selected Sport ID:', selectedSportId);
            console.log('Button clicked');

            // Check if any of the form fields are empty
            if (
                selectedDate === '' ||
                selectedTime === '' ||
                selectedCourtId === '' ||
                selectedSportId === '' ||
                referenceNum === ''

            ) {
                alert('Please fill in all the required fields.');
                return;
            }



            var selectedMinutes = new Date('2023-08-23 ' + selectedTime).getMinutes();
            if (selectedMinutes !== 0) {
                alert('Please select a reservation time at the exact hour (e.g., 8:00, 9:00).');
                return;
            }
            // Fetch reservations for the selected date and time
            $.ajax({
                type: 'POST',
                url: 'get_reservations_for_date',
                data: { date: selectedDate },
                success: function (reservations) {
                    var isTimeSlotAvailable = checkTimeSlotAvailability(reservations, selectedTime);

                    if (!isTimeSlotAvailable) {
                        alert('Selected time slot is already reserved.');
                        return;
                    }

                    function updateReservationDetails() {
                        var selectedDate = $('#datetimePicker').val();
                        var selectedTime = $('#timePicker').val();
                        var selectedHours = $('#hours').val();
                        var selectedCourtId = $('#court').val();
                        var selectedSportId = $('#sport').val();


                        var calculatedHours = selectedHours;
                        var calculatedTotalPrice = calculatedHours * 200;


                        $('#displayHours').html('Hours: ' + calculatedHours);
                        $('#displayTotalPrice').html('Total Price: ₱' + calculatedTotalPrice);
                    }


                    $('#datetimePicker, #timePicker, #hours, #court, #sport').on('change', function () {
                        updateReservationDetails();
                    });


                    updateReservationDetails();


                    $.ajax({
                        type: 'POST',
                        url: 'check_court_sport_availability',
                        data: {
                            court: selectedCourtId,
                            sport: selectedSportId,
                            date: selectedDate,
                            time: selectedTime
                        },
                        success: function (availability) {
                            if (availability === 'available') {
                                var reservationData = {
                                    datetime: selectedDate + ' ' + selectedTime,
                                    court: selectedCourtId,
                                    sport: selectedSportId,
                                };

                                $.ajax({
                                    type: 'POST',
                                    url: 'submit_reserve',
                                    data: new FormData($('#reservationForm')[0]),
                                    contentType: false,
                                    processData: false,
                                    success: function (response) {
                                        alert('Reservation pending for ' + selectedDate + ' At ' + selectedTime);
                                        $('#reservationFormModal').modal('hide');
                                        $('#calendar').fullCalendar('refetchEvents');
                                    },
                                    error: function (xhr, status, error) {
                                        console.log('XHR status: ' + status);
                                        console.log('Error: ' + error);
                                        alert('Error creating reservation');
                                    }
                                });

                            } else {
                                alert('Reservation is not available for the selected court and sport combination. Please choose another court or sport.');
                            }
                        },
                        error: function () {
                            alert('Error checking court and sport availability');
                        }
                    });
                },
                error: function () {
                    alert('Error fetching reservations');
                }
            });
        });

        function triggerReservation() {

            $('#submitReservation').click();


            $.ajax({
                type: 'POST',
                url: 'Page/upload_reference_num',
                data: new FormData($('#reservationForm')[0]),
                processData: false,
                contentType: false,
                success: function (response) {

                    console.log(response);
                },
                error: function (xhr, status, error) {

                    console.log('XHR status: ' + status);
                    console.log('Error: ' + error);
                }
            });
        }


        document.addEventListener('DOMContentLoaded', function () {
            var timePicker = document.getElementById('timePicker');
            var datetimePicker = document.getElementById('datetimePicker');

            // Function to generate sharp time options based on the selected date
            function generateSharpTimeOptions() {
    var select = timePicker;
    select.innerHTML = ''; // Clear existing options

    // Get the selected date from the datetimePicker input
    var selectedDate = new Date(datetimePicker.value);

    if (!isNaN(selectedDate.getTime())) {
        // If a valid date is selected
        // Fetch reservations for the selected date
        $.ajax({
            type: 'POST',
            url: 'get_reservations_for_date',
            data: { date: selectedDate },
            success: function (reservations) {
                // Generate sharp time options for the available time slots
                for (var hour = 8; hour <= 22; hour++) { // 8 am to 10 pm
                    var hourString = hour < 10 ? '0' + hour : hour.toString();
                    var sharpTime = hourString + ':00';

                    // Check if the time slot is reserved
                    var isReserved = checkTimeSlotAvailability(reservations, sharpTime);

                    if (!isReserved) {
                        var option = document.createElement('option');
                        option.value = sharpTime;
                        option.text = sharpTime;
                        select.appendChild(option);
                    }
                }
            },
            error: function () {
                alert('Error fetching reservations for the selected date');
            }
        });
    }
}




        function checkTimeSlotAvailability(reservations, selectedTime) {
            var selectedDateTime = new Date('2023-08-23 ' + selectedTime);

            for (var i = 0; i < reservations.length; i++) {
                var reservationTime = new Date('2023-08-23 ' + reservations[i].time);

                var timeDifference = selectedDateTime - reservationTime;

                if (Math.abs(timeDifference) < 60 * 60 * 1000) {
                    return false;
                }
            }

            return true;
        }
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url("Page/get_court_choices"); ?>',
            dataType: 'json',
            success: function (courts) {
                var courtSelect = document.getElementById('court');


                courts.forEach(function (court) {
                    var option = document.createElement('option');
                    option.value = court.court_number;
                    option.text = court.court_number;
                    courtSelect.appendChild(option);
                });
            },
            error: function () {
                alert('Error fetching court choices');
            }
        });
        function categoryprice() {
            var courtSelect = document.getElementById('court');
            var priceCategoryDiv = document.getElementById('price-category');
            var selectedCourtId = courtSelect.value;

            $.ajax({
                type: 'POST',
                url: '<?php echo site_url("Page/get_category_and_price"); ?>',
                dataType: 'json',
                data: { court_id: selectedCourtId },
                success: function (data) {
                    var priceCategoryText = document.createTextNode(
                        'Court Price: ' + data.price + ', Court Category: ' + data.category
                    );
                    var priceCategoryP = document.createElement('p');
                    priceCategoryP.appendChild(priceCategoryText);
                    priceCategoryDiv.innerHTML = '';
                    priceCategoryDiv.appendChild(priceCategoryP);
                },
                error: function () {
                    alert('Error fetching court information');
                }
            });
        }


        $.ajax({
            type: 'GET',
            url: '<?php echo site_url("Page/get_sport_choices"); ?>',
            dataType: 'json',
            success: function (sports) {
                var sportSelect = document.getElementById('sport');

                sports.forEach(function (sport) {
                    var option = document.createElement('option');
                    option.value = sport.sport_name;
                    option.text = sport.sport_name;
                    sportSelect.appendChild(option);
                });
            },
            error: function () {
                alert('Error fetching sport choices');
            }
        });
        sportElement.addEventListener('change', function () {
            var selectedSport = sportElement.value;
            var courtSelect = document.getElementById('court');

            if (selectedSport === 'dart' || selectedSport === 'pickleball') {
                // If Dart or Pickleball is selected, set the court to "Court1"
                courtSelect.value = 'Court1';
                courtSelect.disabled = true; // Disable court selection
            } else {
                // If any other sport is selected, enable the court selection
                courtSelect.disabled = false;
            }
        });



    </script>
</body>

</html>