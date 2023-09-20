<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <title>Reseved Slots</title>
</head>

<body>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: "Open Sans";
            background: #2c3e50;
            color: #ecf0f1;
            line-height: 1.618em;
        }

        .wrapper {
            max-width: 50rem;
            width: 100%;
            margin: 0 auto;
        }

        .tabs {
            position: relative;
            margin: 3rem 0;
            height: auto;

        }

        .tabs::before,
        .tabs::after {
            content: "";
            display: table;
        }

        .tabs::after {
            clear: both;
        }

        .tab {
            float: left;
        }

        .tab-switch {
            display: none;
        }

        .tab-label {
            position: relative;
            display: block;
            line-height: 2.75em;
            height: 3em;
            padding: 0 1.618em;
            background: #1abc9c;
            border-right: 0.125rem solid #16a085;
            color: #fff;
            cursor: pointer;
            top: 0;
            transition: all 0.25s;
        }

        .tab-label:hover {
            top: -0.25rem;
            transition: top 0.25s;
        }

        .tab-content {
            /* Removed fixed height */
            position: absolute;
            z-index: 1;
            top: 2.75em;
            left: 0;
            padding: 1.618rem;
            background: #fff;
            color: #2c3e50;
            border-bottom: 0.25rem solid #bdc3c7;
            opacity: 0;
            transition: all 0.35s;
        }

        .tab-switch:checked+.tab-label {
            background: #fff;
            color: #2c3e50;
            border-bottom: 0;
            border-right: 0.125rem solid #fff;
            transition: all 0.35s;
            z-index: 1;
            top: -0.0625rem;
        }

        .tab-switch:checked+label+.tab-content {
            z-index: 2;
            opacity: 1;
            transition: all 0.35s;
        }

        .modal-content {
            color: black;
        }

        @media (max-width: 768px) {
            .tab-label {
                font-size: 14px;

            }

            .tab-content {
                top: 3.5em;

                padding: 1rem;

            }

            .modal-content {
                color: black;
                font-size: 14px;

            }
        }
    </style>
    <div class="wrapper">
        <div class="tabs">
            <div class="tab">
                <input type="radio" name="css-tabs" id="tab-1" checked class="tab-switch">
                <label for="tab-1" class="tab-label">Reservations</label>
                <div class="tab-content">

                    <table id="myTable" class="display table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Reserve ID</th>
                                <th>Reserved Datetime</th>
                                <th>Created on</th>
                                <th>Status</th>
                                <th>Sport</th>
                                <th>Court</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($future_reservations as $row): ?>
                                <tr>
                                    <td>
                                        <?= $row->id ?>
                                    </td>
                                    <td>
                                        <?= $row->reserved_datetime ?>
                                    </td>
                                    <td>
                                        <?= $row->created_at ?>
                                    </td>
                                    <td class="status-<?= strtolower($row->status) ?>">
                                        <?= $row->status ?>
                                    </td>
                                    <td>
                                        <?= $row->sport ?>
                                    </td>
                                    <td>
                                        <?= $row->court ?>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-success cancel-button" data-toggle="modal"
                                            data-target="#responseModal" data-action="cancel"
                                            data-id="<?= $row->id ?>">Cancel</a>

                                        <a href="#" class="btn btn-danger reschedule-button" data-toggle="modal"
                                            data-target="#rescheduleModal" data-action="reschedule"
                                            data-id="<?= $row->id ?>"
                                            data-reserved-datetime="<?= $row->reserved_datetime ?>">Reschedule</a>


                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal fade" id="responseModal" tabindex="-1" role="dialog" aria-labelledby="responseModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="responseModalLabel">Response</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="responseBody">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="rescheduleModal" tabindex="-1" role="dialog"
                aria-labelledby="rescheduleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="rescheduleModalLabel">Reschedule Reservation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="reservationForm">
                                <input type="hidden" name="reservationId" id="reservationId" value="">
                                <div class="form-group">
                                    <label for="currentReservationId">Current Reservation ID:</label>
                                    <input type="text" id="currentReservationId" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="newReservedDatetime">New Reserved Datetime:</label>
                                    <input type="datetime-local" id="newReservedDatetime" name="newReservedDatetime">
                                </div>
                                <div class="mb-3">
                                    <label for="sport" class="form-label">Select Sport:</label>
                                    <select id="sport" name="sport" class="form-select" required>
                                        <?php foreach ($sports as $sport): ?>
                                            <option value="<?php echo $sport['sport_id']; ?>">
                                                <?php echo $sport['sport_name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="court" class="form-label">Select Court:</label>
                                    <select id="court" name="court" class="form-select" required>
                                        <?php foreach ($courts as $court): ?>
                                            <option value="<?php echo $court['court_id']; ?>">
                                                <?php echo $court['court_number']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="submitReschedule">Reschedule</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>



            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
            <script>




                $(document).ready(function () {
                    $('#myTable').DataTable();
                });

                // Replace the existing cancel-button click event code with this event delegation code.
                $(document).on('click', '.cancel-button', function (e) {
                    e.preventDefault();

                    var reservationId = $(this).data('id');

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url('Page/cancel_reservation'); ?>',
                        data: { reservationId: reservationId },
                        dataType: 'json',
                        success: function (response) {
                            if (response.status === 'success') {
                                $('#responseBody').html('Reservation canceled successfully.');
                            } else {
                                $('#responseBody').html('Failed to cancel reservation.');
                            }

                            $('#responseModal').modal('show');
                        },
                        error: function () {
                            $('#responseBody').html('An error occurred during the request.');
                            $('#responseModal').modal('show');
                        }
                    });
                });


                $('.reschedule-button').click(function (e) {
                    e.preventDefault();

                    var reservationId = $(this).data('id');
                    var reservedDatetime = $(this).data('reserved-datetime');


                    $('#reservationId').val(reservationId);
                    $('#currentReservationId').val(reservationId);
                    $('#currentReservedDatetime').val(reservedDatetime);
                    $('#newReservedDatetime').val(reservedDatetime);


                    $('#rescheduleModal').modal('show');
                });




                $('#submitReschedule').click(function () {
                    // Serialize the form data
                    var formData = $('#reservationForm').serialize();

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url('Page/reschedule_reservation'); ?>',
                        data: formData,
                        dataType: 'json',
                        success: function (response) {
                            if (response.status === 'success') {
                                $('#responseBody').html('Reservation rescheduled successfully.');
                            } else {
                                $('#responseBody').html('Failed to reschedule reservation.');
                            }

                            // Hide the reschedule modal
                            $('#rescheduleModal').modal('hide');

                            // Show the response modal
                            $('#responseModal').modal('show');
                        },
                        error: function () {
                            $('#responseBody').html('An error occurred during the request.');

                            // Hide the reschedule modal
                            $('#rescheduleModal').modal('hide');

                            // Show the response modal
                            $('#responseModal').modal('show');
                        }
                    });
                });
                responseModal.addEventListener('hidden.bs.modal', function () {
                    responseBody.innerText = '';
                    location.reload();
                });

                responseModal.querySelector('.btn-secondary').addEventListener('click', function () {
                    responseBody.innerText = '';
                    $('#responseModal').modal('hide');
                    location.reload();
                });


                $.ajax({
                    type: 'GET',
                    url: '<?php echo site_url("Page/get_court_choices"); ?>',
                    dataType: 'json',
                    success: function (courts) {
                        var courtSelect = document.getElementById('court');


                        courts.forEach(function (court) {
                            var option = document.createElement('option');
                            option.value = court.court_number;
                            option.text = court.court_number;
                            courtSelect.appendChild(option);
                        });
                    },
                    error: function () {
                        alert('Error fetching court choices');
                    }
                });
                $.ajax({
                    type: 'GET',
                    url: '<?php echo site_url("Page/get_sport_choices"); ?>',
                    dataType: 'json',
                    success: function (sports) {
                        var sportSelect = document.getElementById('sport');

                        sports.forEach(function (sport) {
                            var option = document.createElement('option');
                            option.value = sport.sport_name;
                            option.text = sport.sport_name;
                            sportSelect.appendChild(option);
                        });
                    },
                    error: function () {
                        alert('Error fetching sport choices');
                    }
                });

            </script>
</body>

</html>