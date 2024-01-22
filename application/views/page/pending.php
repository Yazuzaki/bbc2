<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.5.1/css/iziModal.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.5.1/js/iziModal.min.js"></script>

    <title>Pending Reservation</title>
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
                /* Reduce font size for tab labels */
            }

            .tab-content {
                top: 3.5em;
                /* Adjust the top position of tab content */
                padding: 1rem;
                /* Increase padding for tab content */
            }

            .modal-content {
                color: black;
                font-size: 14px;
                /* Reduce font size for modal content */
            }
        }
    </style>
    <div class="wrapper">
        <div class="tabs">
            <div class="tab">
                <input type="radio" name="css-tabs" id="tab-1" checked class="tab-switch">
                <label for="tab-1" class="tab-label">Pending Reservations</label>
                <div class="tab-content">

                    <table id="myTable" class="display table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Reservation ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Reserved Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
                                <th>Sport</th>
                                <th>Court</th>
                                <th>QR Code</th>
                                <th>Proof of Payment</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reservations as $row): ?>
                                <tr>
                                    <td>
                                        <?= $row->ReservationID ?>
                                    </td>
                                    <td>
                                        <?= $row->Username ?>
                                    </td>
                                    <td>
                                        <?= $row->email ?>
                                    </td>
                                    <td>
                                        <?= $row->Date ?>
                                    </td>
                                    <td>
                                        <?= $row->StartTime ?>
                                    </td>
                                    <td>
                                        <?= $row->EndTime ?>
                                    </td>
                                    <td class="status-<?= strtolower($row->status) ?>">
                                        <?= $row->status ?>
                                    </td>
                                    <td>
                                        <?= $row->sport_id ?>
                                    </td>
                                    <td>
                                        <?= $row->court_id ?>
                                    </td>
                                    <td>
                                        <?= $row->qr_code ?>
                                    </td>
                                    <td>
                                        <a href="#" onclick="showImage('<?= base_url($row->refnum) ?>')">
                                            <img src="<?= base_url($row->refnum) ?>" alt="Proof of Payment" width="100"
                                                height="100">
                                        </a>
                                    </td>
                                    <script>
                                        function showImage(src) {
                                            var img = new Image();
                                            img.onload = function () {
                                                var w = window.open("", "_blank");
                                                w.document.write("<img src='" + src + "' width='" + img.width + "' height='" + img.height + "'>");
                                            };
                                            img.src = src;
                                        }
                                    </script>

                                    <td> <a href="#" class="btn btn-success reschedule-button mb-2" data-toggle="modal"
                                            data-target="#rescheduleModal" data-action="reschedule"
                                            data-id="<?= $row->ReservationID ?>" data-start="<?= $row->Date ?>"
                                            data-start="<?= $row->StartTime ?>" data-end="<?= $row->EndTime ?>"
                                            data-sport="<?= $row->sport_id ?>" data-court="<?= $row->court_id ?>"
                                            data-name="<?= $row->Username ?>" data-email="<?= $row->email ?>"
                                            data-qr-code="<?= $row->qr_code ?>">
                                            Approve
                                        </a>
                                        <a href="#" data-toggle="modal" data-target="#responseModal" data-action="decline"
                                            data-id="<?= $row->ReservationID ?>" class="btn btn-danger">Decline</a>
                                    </td>
                                </tr>



                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- ... (Your existing code) ... -->

    <div class="modal fade" id="rescheduleModal" tabindex="-1" role="dialog" aria-labelledby="rescheduleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rescheduleModalLabel">Edit Reservation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="reservationForm">
                        <!-- Hidden field to store reservation ID -->
                        <input type="hidden" name="reservationId" id="reservationId" value="">

                        <!-- Other input fields for editing data -->
                        <div class="form-group">
                            <label for="currentReservedDate">Reserved Date:</label>
                            <input type="text" id="currentReservedDate" readonly>
                        </div>
                        <div class="form-group">
                            <label for="currentReservedStarttime">Start Time:</label>
                            <input type="text" id="currentReservedStarttime" readonly>
                        </div>
                        <div class="form-group">
                            <label for="currentReservedEndtime">End Time:</label>
                            <input type="text" id="currentReservedEndtime" readonly>
                        </div>
                        <!-- Add other fields as needed (e.g., sport, court, etc.) -->

                        <!-- Updated fields for editing -->
                        <div class="form-group">
                            <label for="newReservedDate">New Reserved Date:</label>
                            <input type="datetime-local" id="newReservedDate" name="newReservedDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="sport" class="form-label">Select Sport:</label>
                            <select id="sport" name="sport" class="form-select" required>
                                <!-- Options for sports will be dynamically populated using PHP -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="court" class="form-label">Select Court:</label>
                            <select id="court" name="court" class="form-select" required>
                                <!-- Options for courts will be dynamically populated using PHP -->
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="finalizeButton">Save Changes</button>
                </div>
            </div>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>

        $(document).ready(function () {
            $('#myTable').DataTable({

            });

        });

        $('.reschedule-button').click(function (e) {
            e.preventDefault();

            // Retrieve data attributes
            var reservationId = $(this).data('id');
            var date = $(this).data('date');
            var startTime = $(this).data('start-time');
            var endTime = $(this).data('end-time');
            var sport = $(this).data('sport');
            var court = $(this).data('court');
            var userName = $(this).data('name');
            var userEmail = $(this).data('email');
            var reservationQRCode = $(this).data('qr-code');

            // Populate modal fields with data
            $('#reservationId').val(reservationId);
            $('#currentReservedDate').val(date);
            $('#currentReservedStarttime').val(startTime);
            $('#currentReservedEndtime').val(endTime);
            $('#newReservedDate').val(date);
            $('#newReservedStarttime').val(startTime);
            $('#newReservedEndtime').val(endTime);
            $('#userNameInput').val(userName);
            $('#userEmailInput').val(userEmail);
            $('#qrCodeInput').val(reservationQRCode);

            $('#sport').val(sport);
            $('#court').val(court);
        });

        $("#finalizeButton").click(function () {


            var formData = $('#reservationForm').serialize();

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('Page/finalize_reservation'); ?>',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        alert('Reservation rescheduled successfully.');


                    } else {
                        alert('Failed to reschedule reservation.');
                    }


                },
                error: function () {
                    $('#responseBody').html('An error occurred during the request.');


                    $('#responseModal').modal('show');
                }
            });


            var reservationQRCode = $(this).data('qr-code');


            generateQRCode(reservationQRCode);

            function generateQRCode(reservationQRCode) {

                $.ajax({
                    url: `<?= base_url('Page/generate_qrcode_and_send_email/') ?>${reservationQRCode}`,
                    type: "GET",
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {

                            approveReservation();
                        } else {
                            alert('Failed to generate QR code: ' + response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("QR Code AJAX Error:", error);
                    }
                });
            }

            function approveReservation() {
                var reservationId = $('#reservationId').val();

                // Send an AJAX request to approve the reservation
                $.ajax({
                    url: `<?= base_url('Page/approve_reservation/') ?>${ReservationID}`,
                    type: "GET",
                    dataType: "json",
                    success: function (response) {
                        if (response.status === 'success') {
                            alert('QR code generated and Reservation approved successfully.');
                        } else {
                            alert('Failed to approve reservation.');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", error);
                    }
                });
            }
        });



    </script>

</body>

</html>