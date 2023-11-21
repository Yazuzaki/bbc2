<!-- application/views/reserve_court.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Court Reservation</title>
</head>
<body>

<h2>Reserve a Court</h2>

<?php echo form_open('reservation/process_reservation'); ?>

    <label for="court_id">Court:</label>
    <select name="court_id" required>
        <!-- Populate this dropdown with available courts from your database -->
        <?php foreach ($courts as $court): ?>
            <?php if ($court['status'] == 'available'): ?>
                <option value="<?php echo $court['court_id']; ?>"><?php echo $court['court_number']; ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>

    <br>

    <label for="start_time">Start Time:</label>
    <input type="datetime-local" name="start_time" required>

    <br>

    <label for="duration">Duration (in hours):</label>
    <input type="number" name="duration" required>

    <br>

    <button type="submit">Reserve Court</button>

<?php echo form_close(); ?>

</body>
</html>
