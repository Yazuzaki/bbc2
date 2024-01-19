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
            <label for="start_time">Start Time:</label>
            <select class="form-control" name="start_time" required>
                <?php foreach ($available_times as $time): ?>
                    <option value="<?php echo $time; ?>"><?php echo $time; ?></option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">Please select a start time.</div>
        </div>

        <div class="form-group">
            <label for="end_time">End Time:</label>
            <select class="form-control" name="end_time" required>
                <?php foreach ($available_times as $time): ?>
                    <option value="<?php echo $time; ?>"><?php echo $time; ?></option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">Please select an end time.</div>
        </div>

        <button type="submit" class="btn btn-primary">Submit Reservation</button>

        <?php echo form_close(); ?>
    <?php endif; ?>
</div>

<!-- Include Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>
