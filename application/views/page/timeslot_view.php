<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timeslot Calendar</title>
</head>
<body>

    <h2>Timeslot Calendar</h2>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Start Time</th>
            <th>End Time</th>
        </tr>
        <?php foreach ($timeslots as $slot): ?>
        <tr>
            <td><?= $slot->id ?></td>
            <td><?= $slot->start_time ?></td>
            <td><?= $slot->end_time ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>
