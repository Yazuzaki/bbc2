<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Other CSS styles and meta tags -->
    
    <title>Reservation</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Reservation Form</h1>
        <form id="reservationForm" enctype="multipart/form-data">
            <!-- Other form fields -->
            
            <div class="mb-3">
                <label for="timePicker" class="form-label">Select Time:</label>
                <select id="timePicker" name="time" class="form-select" required>
                    <!-- Add your time slots here as options -->
                    <option value="08:00">08:00 AM</option>
                    <option value="09:00">09:00 AM</option>
                    <!-- Add more time slots here -->
                </select>
            </div>
            
            <div class="mb-3">
                <label for="timeSlotAvailability">Time Slot Availability:</label>
                <!-- Checkboxes for enabling/disabling time slots -->
                <div class="form-check">
                    <input type="checkbox" class="form-check-input time-slot-checkbox" id="08:00">
                    <label class="form-check-label" for="08:00">08:00 AM</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input time-slot-checkbox" id="09:00">
                    <label class="form-check-label" for="09:00">09:00 AM</label>
                </div>
                <!-- Add more checkboxes for other time slots -->
            </div>
            <button type="button" class="btn btn-primary" id="submitReservation">Make Reservation</button>
        </form>
    </div>
    
    <!-- Include Bootstrap JavaScript (jQuery and Popper.js are required by Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js"></script>
    
    <!-- Other JavaScript code -->
</body>
</html>
