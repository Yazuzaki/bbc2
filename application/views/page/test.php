<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
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
                                <th>Reserve ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Reserved Date</th>
                             
                                <th>Created on</th>
                                <th>Status</th>
                                <th>Hours</th>
                                <th>Sport</th>
                                <th>Court</th>
                                <th>Code</th>
                                <th>Img_Path</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reservations as $row): ?>
                                <tr>
                                    <td>
                                        <?= $row->id ?>
                                    </td>
                                    <td>
                                        <?= $row->user_name ?>
                                    </td>
                                    <td>
                                        <?= $row->user_email ?>
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
                                        <?= $row->hours ?>
                                    </td>
                                    <td>
                                        <?= $row->sport ?>
                                    </td>
                                    <td>
                                        <?= $row->court ?>
                                    </td>
                                    <td>
                                        <?= $row->qr_code ?>
                                    </td>
                                    <td>
                                        <a href="#" onclick="showImage('<?= base_url($row->image) ?>')">
                                            <img src="<?= base_url($row->image) ?>" alt="Reservation Image" width="100"
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


                                    <td> <a href="#" class="btn btn-success reschedule-button" data-toggle="modal"
                                            data-target="#rescheduleModal" data-action="reschedule"
                                            data-id="<?= $row->id ?>"
                                            data-reserved-datetime="<?= $row->reserved_datetime ?>"
                                            data-sport="<?= $row->sport ?>" data-court="<?= $row->court ?>"
                                            data-name="<?= $row->user_name ?>" data-email="<?= $row->user_email ?>"
                                            data-qr-code="<?= $row->qr_code ?>">
                                            Approve
                                        </a>
                                        <a href="#" data-toggle="modal" data-target="#responseModal" data-action="decline"
                                            data-id="<?= $row->id ?>" class="btn btn-danger">Decline</a>
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
                            <h5 class="modal-title" id="rescheduleModalLabel">Finalize Reservation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="reservationForm">
                                <input type="hidden" name="reservationId" id="reservationId" value="">
                                <div class="form-group">
                                    <label for="currentReservationId">Reservation ID:</label>
                                    <input type="text" id="currentReservationId" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="userNameInput">Name:</label>
                                    <input type="text" id="userNameInput" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="userEmailInput">Email:</label>
                                    <input type="text" id="userEmailInput" readonly>
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
                            <button type="button" class="btn btn-primary" id="submitReschedule">Update</button>
                            <button type="button" class="btn btn-success" id="finalizeButton"   data-qr-code="<?= $row->qr_code ?>">Approve</button>


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

                $('.reschedule-button').click(function (e) {
                    e.preventDefault();

                    var reservationId = $(this).data('id');
                    var reservedDatetime = $(this).data('reserved-datetime');
                    var sport = $(this).data('sport');
                    var court = $(this).data('court');
                    var userName = $(this).data('name'); // Get the user's name
                    var userEmail = $(this).data('email'); // Get the user's email
                    var reservationQRCode = $(this).data('qr_code');

                    $('#reservationId').val(reservationId);
                    $('#currentReservationId').val(reservationId);
                    $('#currentReservedDatetime').val(reservedDatetime);
                    $('#newReservedDatetime').val(reservedDatetime);
                    $('#userNameInput').val(userName); // Populate the user's name input
                    $('#userEmailInput').val(userEmail); // Populate the user's email input
                    $('#qrCodeInput').val(reservationQRCode);

                    // Populate the "sport" and "court" select elements in the modal
                    $('#sport').val(sport);
                    $('#court').val(court);

                    $('#rescheduleModal').modal('hide');
                });

                $("#finalizeButton").click(function () {
                   
    var reservationQRCode = $(this).data('qr-code');

    // First, generate the QR code
    generateQRCode(reservationQRCode);

    function generateQRCode(reservationQRCode) {
        // Make an AJAX request to call the generate_qrcode function
        $.ajax({
            url: `<?= base_url('Page/generate_qrcode_and_send_email/') ?>${reservationQRCode}`,
            type: "GET",
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    // QR code generated successfully, now approve the reservation
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
            url: `<?= base_url('Page/approve_reservation/') ?>${reservationId}`,
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



                /* $('#submitReschedule').click(function () {
                    // Serialize the form data
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

                            // Show the response modal
                            $('#responseModal').modal('show');
                        }
                    });
                });
               $("#finalizeButton").click(function () {
 
                    var reservationId = $('#reservationId').val();

                    $.ajax({
                        url: `<?= base_url('Page/approve_reservation/') ?>${reservationId}`,
                        type: "GET",
                        dataType: "json",
                        success: function (response) {
                            if (response.status === 'success') {
                                alert('Reservation approved successfully.');
                            } else {
                                alert('Failed to approve reservation:');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error("AJAX Error:", error);
                        }
                    });
                });

                $("#generateQRButton").click(function () {
                    // Retrieve the reservationQRCode or generate it as needed
                    var reservationQRCode = $(this).data('qr-code');
                    // Make an AJAX request to call the generate_qrcode function
                    $.ajax({
                        url: `<?= base_url('Page/generate_qrcode_and_send_email/') ?>${reservationQRCode}`,
                        type: "GET",
                        dataType: "json",
                        success: function (response) {
                            if (response.success) {
                                alert('QR code generated successfully.');
                            } else {
                                alert('Failed to generate QR code: ' + response.message);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error("QR Code AJAX Error:", error);
                        }
                    });
                });


 */


                // Function to handle the "Decline" button click
                $(".btn-danger[data-action='decline']").click(function () {
                    const reservationId = $(this).data("id");
                    $.ajax({
                        url: `<?= base_url('Page/decline_reservation/') ?>${reservationId}`,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            if (data.status === "success") {
                                $("#responseBody").text("Reservation declined successfully.");
                            } else {
                                $("#responseBody").text("Failed to decline reservation: " + data.message);
                            }
                            $('#responseModal').modal('show');
                        },
                        error: function (xhr, status, error) {
                            console.error("AJAX Error:", error);
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