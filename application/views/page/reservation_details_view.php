<!DOCTYPE html>
<html>
<head>
    <title>Reservation Details</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Reservation Details</h1>
        <table class="table">
            <tr>
                <th>QR Code</th>
                <td><?= $reservationDetails['qr_code'] ?></td>
            </tr>
            <tr>
                <th>Name</th>
                <td><?= $reservationDetails['user_name'] ?></td>
            </tr>
            <tr>
                <th>Reservation Date</th>
                <td><?= $reservationDetails['reserved_datetime'] ?></td>
            </tr>
            <tr>
                <th>Court</th>
                <td><?= $reservationDetails['court'] ?></td>
            </tr>
            <tr>
                <th>Sport</th>
                <td><?= $reservationDetails['sport'] ?></td>
            </tr>
            <tr>
                <th>Hours</th>
                <td><?= $reservationDetails['hours'] ?></td>
            </tr>
        </table>
    </div>
    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
