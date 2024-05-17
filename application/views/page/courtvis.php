<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Court Availability - <?php echo date('F j, Y', strtotime($date)); ?></title>
    <link rel="stylesheet" href="<?php echo base_url('application/assets/css/main.css'); ?>">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding-top: 120px; /* Adjusted to account for fixed navbar height */
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h1 {
            margin: 20px 0;
        }
        form {
            margin-bottom: 20px;
        }
        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 80%;
            max-width: 1200px;
            overflow-x: auto;
        }
        .header, .row {
            display: flex;
            align-items: center;
        }
        .header {
            background-color: #333;
            color: white;
            padding: 10px 0;
            border-radius: 8px 8px 0 0;
        }
        .row {
            background-color: #f9f9f9;
            border-bottom: 1px solid #ddd;
        }
        .row:nth-child(even) {
            background-color: #fff;
        }
        .time-label, .court-header, .time-slot {
            flex: 1;
            padding: 10px;
            text-align: center;
            border-right: 1px solid #ddd;
        }
        .time-label, .court-header {
            font-weight: bold;
        }
        .court-header {
            background-color: #333;
            color: white;
        }
        .time-slot.green {
            background-color: #28a745;
            color: white;
            background-image: url('<?php echo base_url('assets/tennis-court-top-view-vector.jpg'); ?>');
            background-size: cover;
            background-position: center;
        }
        .time-slot.grey {
            background-color: grey;
            color: white;
        }
        .time-label:last-child, .court-header:last-child, .time-slot:last-child {
            border-right: none;
        }
    </style>
</head>
<body>
    <h1>Court Availability - <?php echo date('F j, Y', strtotime($date)); ?></h1>
    <form method="GET" action="<?php echo site_url('Page/courtvis'); ?>">
        <label for="date">Select Date:</label>
        <input type="date" id="date" name="date" value="<?php echo $date; ?>">
        <button type="submit">Filter</button>
    </form>
    <div class="container">
        <div class="header">
            <div class="time-label">Time</div>
            <?php for ($courtId = 1; $courtId <= 11; $courtId++): ?>
                <div class="court-header">Court <?php echo $courtId; ?></div>
            <?php endfor; ?>
        </div>
        <?php foreach ($timeSlots as $time): ?>
            <div class="row">
                <div class="time-label"><?php echo $time; ?></div>
                <?php for ($courtId = 1; $courtId <= 11; $courtId++): ?>
                    <?php
                        $isBooked = isset($bookedSlots[$time][$courtId]);
                        $class = $isBooked ? 'grey' : 'green';
                    ?>
                    <div class="time-slot <?php echo $class; ?>"></div>
                <?php endfor; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <script src="<?php echo base_url('application/assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('application/assets/js/browser.min.js'); ?>"></script>
    <script src="<?php echo base_url('application/assets/js/breakpoints.min.js'); ?>"></script>
    <script src="<?php echo base_url('application/assets/js/util.js'); ?>"></script>
    <script src="<?php echo base_url('application/assets/js/main.js'); ?>"></script>
</body>
</html>
