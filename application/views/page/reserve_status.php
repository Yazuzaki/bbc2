<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Reservations</title>

    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url('application\assets\css\main.css'); ?>">

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-family: Arial, sans-serif;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .cancel-btn {
            cursor: pointer;
            color: red;
            text-decoration: underline;
            border: none;
            background: none;
        }

        .cancel-btn[disabled] {
            color: gray;
            text-decoration: none;
            cursor: not-allowed;
        }
    </style>
</head>

<body>

    <h2>User Reservations</h2>

    <script>
        function cancelReservation(reservationId) {
            var confirmCancellation = confirm("Are you sure you want to cancel this reservation?");

            if (confirmCancellation) {
                // Use AJAX to cancel the reservation
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('Page/cancelReservation'); ?>",
                    data: { reservationId: reservationId },
                    success: function (response) {
                        alert(response);
                        // Refresh the page or update the reservation status dynamically
                        location.reload();
                    },
                    error: function () {
                        alert("Error canceling reservation.");
                    }
                });
            }
        }
    </script>

    <?php if (!empty($reservations)): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>Status</th>
                    <th>End Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation): ?>
                    <tr>
                        <td>
                            <?php echo $reservation->ReservationID; ?>
                        </td>
                        <td>
                            <?php echo $reservation->Username; ?>
                        </td>
                        <td>
                            <?php echo $reservation->Date; ?>
                        </td>
                        <td>
                            <?php echo $reservation->status; ?>
                        </td>
                        <td>
                            <?php echo $reservation->StartTime; ?>
                        </td>
                        <td>
                            <?php echo $reservation->EndTime; ?>
                        </td>
                        <td>
                            <?php
                            $reservationStart = new DateTime($reservation->created_at);
                            $reservationStart->modify('+48 hours');
                            $reservationStart->setTime(0, 0, 0);

                            $now = new DateTime();

                            if ($now > $reservationStart) {
                                echo '<button class="btn btn-danger cancel-btn" disabled>Cancel</button>';
                            } else {
                                echo '<button class="btn btn-danger cancel-btn" onclick="cancelReservation(' . $reservation->ReservationID . ')">Cancel</button>';
                            }
                            ?>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No reservations found for the user.</p>
    <?php endif; ?>

    <!-- Include jQuery and Bootstrap JS -->
    <script src="<?php echo base_url('application\assets\js\jquery.min.js'); ?>"></script>
	<script src="<?php echo base_url('application\assets\js\browser.min.js'); ?>"></script>
	<script src="<?php echo base_url('application\assets\js\breakpoints.min.js'); ?>"></script>
	<script src="<?php echo base_url('application\assets\js\util.js'); ?>"></script>
	<script src="<?php echo base_url('application\assets\js\main.js'); ?>"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>

</html>