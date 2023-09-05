<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Today's Reservations</title>
    <style>
 body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #007BFF;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .no-reservations {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <br>
    <br>
    <?php if (!empty($today)) : ?>
        <?php
        usort($today, function ($a, $b) {
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
            <?php foreach ($today as $row) : ?>
                <tr>
                    <td><?= $row->id ?></td>
                    <td><?= $row->reserved_datetime ?></td>
                    <td><?= $row->created_at ?></td>
                    <td><?= $row->status ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else : ?>
        <p>No today's reservations available.</p>
    <?php endif; ?>
</body>
</html>
