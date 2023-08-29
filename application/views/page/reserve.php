<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="images\BBCLOGO.jpg">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/flatpickr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/flatpickr.min.css">
    <title>Reservation</title>
    <style>
        .reserved-slot {
            background-color: #FFCCCC;
        }
        #calendar {
            max-width: 70%;
            margin: 40px auto;
            padding: 0 10px;
        }

        .fc-day {
            cursor: pointer;
        }
        #top {
            background: #eee;
            border-bottom: 1px solid #ddd;
            padding: 0 10px;
            line-height: 40px;
            font-size: 12px;
        }

        #loading {
            display: none;
        }

        #calendar {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 10px;
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
        .modal-dialog {
            max-width: 75%;
        }
        .fc-day:hover {
        background-color: #eee;
        cursor: pointer;
        }
        
    </style>
</head>
<body>

<div class="container mt-5">
    <div id="calendar"></div>
</div>
</body>
<script>
  document.addEventListener('DOMContentLoaded', function () {
  var calendarEl = document.getElementById('calendar');

  var calendar = new FullCalendar.Calendar(calendarEl, {
    timeZone: 'UTC',
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right:''
    },
    events: '<?php echo site_url("Page/get_reservations"); ?>',
    eventTimeFormat: {
            hour: 'numeric',
            minute: '2-digit',
            meridiem: 'short'
    },
    
    dateClick: function(info) {
      var selectedDate = info.date;
      var currentDate = new Date();
      currentDate.setHours(0, 0, 0, 0);
      selectedDate.setHours(0, 0, 0, 0);

      if (selectedDate.getTime() < currentDate.getTime()) {
        alert('You clicked on a past date.');
      } else {
        selectedDate.setHours(selectedDate.getHours() + 8); 
        var formattedDate = selectedDate.toISOString().split('T')[0];

        var formModal = new bootstrap.Modal(document.getElementById('reservationFormModal'));
        formModal.show();

        var datetimePicker = document.getElementById('datetimePicker');
        datetimePicker.value = formattedDate;
      }
    },
    dayCellClassNames: function(e) {
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

  calendar.render();
});


</script>

<div class="modal fade" id="reservationFormModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Make Reservation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="reservationForm">
                    <div class="mb-3">
                        <label for="datetimePicker" class="form-label">Select Date:</label>
                        <input type="text" id="datetimePicker" name="datetime" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="timePicker" class="form-label">Select Time:</label>
                        <input type="time" id="timePicker" name="time" class="form-control" required>
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

<script>
    var datetimePicker = document.getElementById('datetimePicker');
    var timePicker = document.getElementById('timePicker');
    var submitButton = document.getElementById('submitReservation');


    submitButton.addEventListener('click', function() {
    var selectedDate = datetimePicker.value;
    var selectedTime = timePicker.value;

    // Fetch reservations for the selected date
    $.ajax({
        type: 'POST',
        url: 'get_reservations_for_date',
        data: { date: selectedDate },
        success: function(reservations) {
            var isTimeSlotAvailable = checkTimeSlotAvailability(reservations, selectedTime);

            if (!isTimeSlotAvailable) {
                alert('Selected time slot is already reserved.');
                return;
            }

            var reservationData = {
                datetime: selectedDate + ' ' + selectedTime
            };

            $.ajax({
                type: 'POST',
                url: 'submit_reserve', 
                data: reservationData,
                success: function(response) {
                    alert('Reservation pending for ' + selectedDate + ' At ' + selectedTime );
                    $('#reservationFormModal').modal('hide');
                    $('#calendar').fullCalendar('refetchEvents');
                },
                error: function() {
                    alert('Error creating reservation');
                }
            });
        },
        error: function() {
            alert('Error fetching reservations');
        }
    });
});

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

</script>
</html>
