<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Form</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">Reservation Form</h2>
            </div>
            <div class="card-body">
                <?php echo validation_errors(); ?>

                <?php
                // Check if reservation success flash data exists
                $reservation_success = $this->session->flashdata('reservation_success');

                if ($reservation_success) {
                    echo '<div class="alert alert-success">' . $reservation_success . '</div>';
                }
                ?>

                <?php echo form_open('Page/reservationviewprocess', array('enctype' => 'multipart/form-data', 'id' => 'reservationForm')); ?>

                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" class="form-control" id="date" name="date" required
                        min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>"
                        max="<?php echo date('Y-m-d', strtotime('+1 year')); ?>">
                    <div class="invalid-feedback">Please select a date.</div>
                </div>
                <div class="form-group">
                    <label for="sport">Sport:</label>
                    <select class="form-control" id="sport" name="sport" required>
                        <option value="Badminton">Badminton</option>
                        <option value="Pickleball">Pickleball</option>
                        <option value="Tabletennis">Tabletennis</option>
                        <option value="Darts">Darts</option>
                    </select>
                    <div class="invalid-feedback">Please select a sport.</div>
                </div>

                <div class="form-group">
                    <label for="court">Court: Price per Hour <br>Special: 250PHP Regular 210PHP Beginner 180PHP</label>
                    <select class="form-control" id="court" name="court" required>
                        <option value="">Select Court</option>
                        <option value="1">Court 1</option>
                        <option value="2">Court 2</option>
                        <option value="3">Court 3</option>
                        <option value="4">Court 4</option>
                        <option value="5">Court 5</option>
                        <option value="6">Court 6</option>
                        <option value="7">Court 7</option>
                        <option value="8">Court 8</option>
                        <option value="9">Court 9</option>
                        <option value="10">Court 10</option>
                        <option value="11">Court 11</option>
                    </select>
                    <div class="invalid-feedback">Please select a court.</div>
                </div>


                <div class="form-group">
                    <label for="start_time">Start Time:</label>
                    <select class="form-control" id="start_time" name="start_time" required>
                        <?php foreach ($available_times as $time): ?>
                            <option value="<?php echo $time; ?>">
                                <?php echo $time; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Please select a start time.</div>
                </div>

                <div class="form-group">
                    <label for="end_time">End Time:</label>
                    <select class="form-control" id="end_time" name="end_time" required>
                        <?php foreach ($available_times as $time): ?>
                            <option value="<?php echo $time; ?>">
                                <?php echo $time; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Please select an end time.</div>
                </div>

                <div class="form-group">
                    <label for="proof_of_payment">Proof of Payment Gcash Payment Only (Screenshot) Gcash
                        09060886262:</label>
                    <input type="file" id="referenceNum" name="referenceNum" class="form-control" accept="image/*"
                        required onchange="scanImage()">
                    <div class="invalid-feedback">Please upload a valid image file.</div>
                </div>

                <div id="loadingContainer" style="display: none;">
                    <p>Upoading...</p>
                </div>

                <div id="resultContainer" style="display: none;">
                    <h3>Scanned Text:</h3>
                    <pre id="scannedText" class="border p-3"></pre>
                    <h3 class="mt-3">Extracted Reference Number:</h3>
                    <div id="extractedReferenceNumber" class="border p-3"></div>
                    <!-- Add this inside the form -->
                    <input type="text" id="extractedReferenceNumberInput" name="extractedReferenceNumber">

                </div>


                <button type="submit" class="btn btn-primary mt-3">Submit Reservation</button>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <!-- Include full version of jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> <!-- Add jQuery library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tesseract.js"></script>


    <script>
        function scanImage() {
            var fileInput = document.getElementById('referenceNum');
            var resultContainer = document.getElementById('resultContainer');
            var scannedTextElement = document.getElementById('scannedText');
            var extractedReferenceNumberElement = document.getElementById('extractedReferenceNumber');
            var loadingContainer = document.getElementById('loadingContainer');

            var file = fileInput.files[0];

            if (file) {

                loadingContainer.style.display = 'block';

                Tesseract.recognize(
                    file,
                    'eng',
                    { logger: info => console.log(info) }
                ).then(({ data: { text } }) => {
                    resultContainer.style.display = 'block';
                    scannedTextElement.textContent = text;

                    // Define a regular expression for matching reference numbers
                    var referenceNumberRegex = /\b(?:Ref(?:\.|:)?\s*No(?:\.|:)?|Reference\s*Number)\s*([\d\s]+)\b/g;


                    // Extract reference numbers from the scanned text
                    var matches = referenceNumberRegex.exec(text);

                    if (matches && matches[1]) {
                        var referenceNumber = matches[1];
                        extractedReferenceNumberElement.innerHTML = referenceNumber;

                        extractedReferenceNumberInput.value = referenceNumber;
                        // Send the extracted reference number to the backend for insertion
                        /*  sendReferenceNumberToBackend(referenceNumber.toString()); */

                    } else {
                        extractedReferenceNumberElement.innerHTML = 'No reference numbers found.';
                    }

                    resultContainer.style.display = 'none';
                    loadingContainer.innerHTML = 'Loading completed!';
                });
            } else {
                alert('Please select an image before scanning.');
            }
        }
        function sendReferenceNumberToBackend(referenceNumber) {
            // AJAX request to check if the reference number exists
            $.ajax({
                url: '<?php echo base_url('Page/check_reference_number'); ?>',
                type: 'POST',
                data: { extractedReferenceNumber: referenceNumber },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'exists') {
                        // Show a message that the reference number already exists
                        alert(response.message);
                        // Optionally, you can prevent the form submission here
                    } else {
                        // Continue with the form submission or any other actions
                        $('#reservationForm').submit();
                    }
                },
                error: function () {
                    console.log('Error checking reference number.');
                }
            });
        }



        $(document).ready(function () {
            // Function to update dropdowns
            function updateDropdowns(availableTimes) {
                $('#start_time, #end_time').empty();
                $.each(availableTimes, function (index, time) {
                    $('#start_time, #end_time').append('<option value="' + time + '">' + time + '</option>');
                });
            }
            function updateCourtDropdown(availableCourts) {
                var courtSelect = $('#court');
                courtSelect.empty();

                $.each(availableCourts, function (index, court) {
                    courtSelect.append('<option value="' + court.court_id + '">' + court.court_number + '</option>');
                });
            }
            function updateSportDropdown(sports) {
                var sportSelect = $('#sport');
                sportSelect.empty();

                $.each(sports, function (index, sport) {
                    sportSelect.append('<option value="' + sport.sport_name + '">' + sport.sport_name + '</option>');
                });
            }

            // Attach change event handlers to both date and court inputs
            $('#date, #court').on('change', function () {
                var selectedDate = $('#date').val();
                var selectedCourt = $('#court').val();

                // AJAX request to get available times for the selected date and court
                $.ajax({
                    url: '<?php echo base_url('Page/date_and_court_click'); ?>',
                    type: 'POST',
                    data: { date: selectedDate, court: selectedCourt },
                    dataType: 'json',
                    success: function (response) {
                        // Update the start and end time dropdowns with the new available times
                        updateDropdowns(response);
                    },
                    error: function () {
                        console.log('Error fetching available times.');
                    }
                });
            });
        });
    </script>

</body>

</html>