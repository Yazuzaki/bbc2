<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reservation</title>
</head>

<body>
<?php echo form_open('Page/update_reservation/' . $reservation->id); ?>
<input type="hidden" name="reservation_id" value="<?= $reservation->id ?>">
<div class="form-group">
        <label for="reserved_datetime">Reserved Datetime:</label>
        <input type="datetime-local" id="reserved_datetime" name="reserved_datetime"
            value="<?= set_value('reserved_datetime', $reservation->reserved_datetime) ?>" class="form-control"
            required>
    </div>
    <div class="form-group">
        <label for="status">Status:</label>
        <select id="status" name="status" class="form-control" required>
            <option value="pending" <?= ($reservation->status == 'pending') ? 'selected' : '' ?>>Pending</option>
            <option value="approved" <?= ($reservation->status == 'approved') ? 'selected' : '' ?>>Approved</option>
            <option value="declined" <?= ($reservation->status == 'declined') ? 'selected' : '' ?>>Declined</option>
        </select>
    </div>
    <div class="form-group">
        <label for="sport">Sport:</label>
        <input type="text" id="sport" name="sport" value="<?= set_value('sport', $reservation->sport) ?>"
            class="form-control" required>
    </div>
    <div class="form-group">
        <label for="court">Court:</label>
        <input type="text" id="court" name="court" value="<?= set_value('court', $reservation->court) ?>"
            class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Update Reservation</button>
    <?php echo form_close(); ?>

</body>

</html>
