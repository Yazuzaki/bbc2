<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Declined Reservations</title>
    <style>

    </style>
</head>
<body>
    <br>
    <br>
    <?php if (!empty($declined)) : ?>
        <?php
        usort($declined, function ($a, $b) {
            return strtotime($a->reserved_datetime) - strtotime($b->reserved_datetime);
        });
        ?>
        <table class="table-hover" width="600" border="0" cellspacing="5" cellpadding="5">
            <tr style="background:#CCC">
                <th>Reserve ID</th>
                <th>Reserved Datetime</th>
                <th>Created on</th>
                <th>Status</th>
            </tr>
            <?php foreach ($declined as $row) : ?>
                <tr>
                    <td><?= $row->id ?></td>
                    <td><?= $row->reserved_datetime ?></td>
                    <td><?= $row->created_at ?></td>
                    <td><?= $row->status ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else : ?>
        <p>No declined reservations available.</p>
    <?php endif; ?>
</body>
</html>
