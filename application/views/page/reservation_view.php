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

        <?php if (empty($available_times)): ?>
            <div class="alert alert-warning">
                No more available timeslots. Please choose a different date or time.
            </div>
        <?php else: ?>
            <?php echo form_open('Page/reservationviewprocess'); ?>

            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" class="form-control" id="date" name="date" required
                    min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>"
                    max="<?php echo date('Y-m-d', strtotime('+1 year')); ?>">
                <div class="invalid-feedback">Please select a date.</div>
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
                <label for="court">Court:</label>
                <select class="form-control" id="court" name="court" required>
                    <?php foreach ($court_categories as $key => $category): ?>
                        <option value="<?php echo $category['start_court']; ?>">
                            <?php echo ucfirst($key); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">Please select a court.</div>
            </div>

            <button type="submit" class="btn btn-primary">Submit Reservation</button>

            <?php echo form_close(); ?>
        <?php endif; ?>
    </div>

    <!-- Include full version of jQuery -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

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
    </script>

</body>

</html>