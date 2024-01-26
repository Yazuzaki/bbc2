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
        <h2 class="mb-4">Reservation Form</h2>

        <?php echo validation_errors(); ?>

        <?php
        // Check if reservation success flash data exists
        $reservation_success = $this->session->flashdata('reservation_success');

        if ($reservation_success) {
            echo '<div class="alert alert-success">' . $reservation_success . '</div>';
        }
        ?>

        <!--  <?php if (empty($available_times)): ?>
            <div class="alert alert-warning">
                No more available timeslots. Please choose a different date or time.
            </div>
        <?php else: ?> -->
            <?php echo form_open('Page/reservationviewprocess', array('enctype' => 'multipart/form-data')); ?>


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
                    <?php foreach ($sports as $sport): ?>
                        <option value="<?php echo $sport['id']; ?>">
                            <?php echo $sport['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">Please select a sport.</div>
            </div>

            <div class="form-group">
                <label for="court">Court: Price per Hour <br>Special: 250PHP Regular 210PHP Beginner 180PHP</label>
                <select class="form-control" id="court" name="court" required>
                    <?php foreach ($court_categories as $key => $category): ?>
                        <option value="<?php echo $category['start_court']; ?>">
                            <?php echo ucfirst($key); ?>
                        </option>
                    <?php endforeach; ?>
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
                <label for="proof_of_payment">Proof of Payment Gcash Payment Only (Screenshot) Gcash 09060886262:</label>
                <input type="file" id="referenceNum" name="referenceNum" class="form-control" required>
                <div class="invalid-feedback">Please upload a valid image file.</div>
            </div>

            <button type="submit" class="btn btn-primary">Submit Reservation</button>

            <?php echo form_close(); ?>
        <?php endif; ?>
    </div>

    <!-- Include full version of jQuery -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tesseract.js"></script>

    <script>
        $(document).ready(function () {
            // Function to update dropdowns
            function updateDropdowns(availableTimes) {
                $('#start_time, #end_time').empty();
                $.each(availableTimes, function (index, time) {
                    $('#start_time, #end_time').append('<option value="' + time + '">' + time + '</option>');
                });
            }

            // Attach a change event handler to the date input
            $('#date').on('change', function () {
                var selectedDate = $(this).val();

                // AJAX request to get available times for the selected date
                $.ajax({
                    url: '<?php echo base_url('Page/date_click'); ?>',
                    type: 'POST',
                    data: { date: selectedDate },
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
        function scanAndSubmit() {
            var fileInput = document.getElementById('referenceNum');
            var scannedTextElement = document.getElementById('scannedText');
            var extractedReferenceNumberElement = document.getElementById('extractedReferenceNumber');

            var file = fileInput.files[0];

            if (file) {
                Tesseract.recognize(
                    file,
                    'eng',
                    { logger: info => console.log(info) }
                ).then(({ data: { text } }) => {
                    scannedTextElement.textContent = text;

                    // Define a regular expression for matching reference numbers
                    var referenceNumberRegex = /\b(?:Ref(?:\.|:)?\s*No(?:\.|:)?|Reference\s*Number)\s*([\d\s]+)\b/g;

                    // Extract reference numbers from the scanned text
                    var matches = referenceNumberRegex.exec(text);

                    if (matches && matches[1]) {
                        var referenceNumber = matches[1];
                        extractedReferenceNumberElement.innerHTML = referenceNumber;

                        // Attach the extracted reference number to the form data
                        var hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'scanned_reference_number';
                        hiddenInput.value = referenceNumber;
                        document.getElementById('imageForm').appendChild(hiddenInput);

                        // Continue with form submission
                        return true;
                    } else {
                        extractedReferenceNumberElement.innerHTML = 'No reference numbers found.';
                        return false; // Cancel form submission
                    }
                });
            } else {
                alert('Please select an image before submitting.');
                return false; // Cancel form submission
            }
            $.ajax({
                        type: 'GET',
                        url: '<?php echo site_url("Page/get_court_choices"); ?>',
                        dataType: 'json',
                        success: function (courts) {
                            var courtSelect = document.getElementById('court');


                            courts.forEach(function (court) {
                                var option = document.createElement('option');
                                option.value = court.court_id;
                                option.text = court.court_id;
                                courtSelect.appendChild(option);
                            });
                        },
                        error: function () {
                            alert('Error fetching court choices');
                        }
                    });
        }


    </script>

</body>

</html>