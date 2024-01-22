<!DOCTYPE html>
<html>
<head>
    <title>Reservation Details</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
        
        <div class="text-center">
            <img src="<?php echo base_url('asset\299584772_435117378634124_6677388645313997495_n.png'); ?>" alt="Your Logo" width="150">
        </div>
        
        <h1 class="text-center">Reservation Details</h1>
        <table class="table">
       
            <tr>
            <th>Retrival ID</th>
                <td><?= $reservationDetails['qr_code'] ?></td>
            </tr>
            <tr>
                <th>Reservation ID</th>
                <td><?= $reservationDetails['ReservationID'] ?></td>
            </tr>
            <tr>
                <th>Name</th>
                <td><?= $reservationDetails['Username'] ?></td>
            </tr>
            <tr>
                <th>Reservation Date</th>
                <td><?= $reservationDetails['Date'] ?></td>
            </tr>
            <th>Reservation Start</th>
                <td><?= $reservationDetails['StartTime'] ?></td>
            </tr>
            <th>Reservation End</th>
                <td><?= $reservationDetails['EndTime'] ?></td>
            </tr>
            <tr>
                <th>Court</th>
                <td><?= $reservationDetails['court_id'] ?></td>
            </tr>
            <tr>
                <th>Sport</th>
                <td><?= $reservationDetails['sport_id'] ?></td>
            </tr>
          
        </table>
    </div>
    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
