<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        /* Add your custom styles here */
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Reservation Receipt</h2>
        <p><strong>User Name:</strong> <?= $userName ?></p>
        <p><strong>Court Number:</strong> <?= $courtNumber ?></p>
        <p><strong>Reservation Fee per Hour:</strong> $<?= $price ?></p>
        <p><strong>Reserved Datetime:</strong> <?= $reservation->reserved_datetime ?></p>
        <p><strong>Hours Booked:</strong> <?= $reservation->hours ?> hours</p>
        <p><strong>Total Amount:</strong> $<?= $totalAmount ?></p>
        <!-- You can add more information here if needed -->
    </div>
</body>

</html>
