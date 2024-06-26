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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.5.1/js/iziModal.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>


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
                            <th>Reservation ID</th>
                            <th>Created</th>
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
                            <th>ReferenceNumber</th>
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
                                        <?= $row->created_at ?>
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
                                    <td>
                                        <?= $row->referencenumber ?>
                                    </td>

                                    <td> <a href="#" class="btn btn-success reschedule-button mb-2" data-toggle="modal"
                                            data-target="#rescheduleModal" data-action="reschedule"
                                            data-id="<?= $row->ReservationID ?>" data-date="<?= $row->Date ?>"
                                            data-start="<?= $row->StartTime ?>" data-end="<?= $row->EndTime ?>"
                                            data-sport="<?= $row->sport_id ?>" data-court="<?= $row->court_id ?>"
                                            data-name="<?= $row->Username ?>" data-email="<?= $row->email ?>"
                                            data-qr-code="<?= $row->qr_code ?>">
                                            Approve
                                        </a>
                                        <a href="#" class="btn btn-danger mb-2" data-toggle="modal"
                                            data-target="#declineModal" data-action="decline"
                                            data-id="<?= $row->ReservationID ?>" data-email="<?= $row->email ?>"
                                            data-id="<?= $row->qr_code ?>">Decline</a>
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
            <div class="modal-body">
                <!-- Loading Spinner -->
                <div id="loadingSpinner" class="spinner-border text-primary" role="status" style="display: none;">
                    <span class="visually-hidden">Loading...</span>
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
                                        <label for="newReservedDatetime">New Reserved Date:</label>
                                        <input type="date" id="newReservedDatetime" name="newReservedDatetime">
                                    </div>
                                    <div class="form-group">
                                        <label for="newStartTime">Start Time:</label>
                                        <select class="form-control" id="newStartTime" name="newStartTime" required>
                                            <?php foreach ($available_times as $time): ?>
                                                <option value="<?php echo $time; ?>">
                                                    <?php echo $time; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="newEndTime">End Time:</label>
                                        <select class="form-control" id="newEndTime" name="newEndTime" required>
                                            <?php foreach ($available_times as $time): ?>
                                                <option value="<?php echo $time; ?>">
                                                    <?php echo $time; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
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
                                                    <?php echo $court['court_name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-success" id="finalizeButton"
                                    data-qr-code="<?= $row->qr_code ?>">Approve</button>


                            </div>
                        </div>
                        </form>
                    </div>

                </div>
                <!-- Decline Reason Modal -->
                <div class="modal fade" id="declineModal" tabindex="-1" role="dialog"
                    aria-labelledby="declineModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="declineModalLabel">Reason for Decline</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="declineForm">
                                <div class="modal-body">
                                    <input type="hidden" name="ReservationID" id="modalReservationID">
                                    <div class="form-group">
                                        <label for="declineReason">Reason</label>
                                        <textarea class="form-control" id="declineReason" name="decline_reason" rows="3"
                                            required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger">Decline</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <script>




                </script>


                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

                <script>


                    $(document).ready(function () {
                        $('#myTable').DataTable({

                        });

                    });
                    $('#declineModal').on('show.bs.modal', function (event) {
                        var button = $(event.relatedTarget); // Button that triggered the modal
                        var reservationID = button.data('id'); // Extract info from data-* attributes

                        // Update the modal's content.
                        var modal = $(this);
                        modal.find('#modalReservationID').val(reservationID);
                    });

                    $('#declineForm').on('submit', function (e) {
                        e.preventDefault();

                        $.ajax({
                            url: '<?= base_url('Page/decline_reservation') ?>',
                            type: 'POST',
                            data: $(this).serialize(),
                            success: function (response) {
                                // Check if the response is already in JSON format
                                if (typeof response === 'object') {
                                    handleResponse(response);
                                } else {
                                    try {
                                        // Parse the response as JSON
                                        response = JSON.parse(response);
                                        handleResponse(response);
                                    } catch (error) {
                                        console.error('Error parsing JSON:', error);
                                        iziToast.error({
                                            title: 'Error',
                                            message: 'An error occurred while processing your request.',
                                            position: 'topRight'

                                        });
                                    }
                                }
                            },
                            error: function () {
                                iziToast.error({
                                    title: 'Error',
                                    message: 'An error occurred while processing your request.',
                                    position: 'topRight'
                                });
                            }
                        });
                    });

                    // Function to handle the response
                    function handleResponse(response) {
                        if (response.status === 'success') {
                            $('#declineModal').hide();


                            iziToast.success({
                                title: 'Success',
                                message: response.message,
                                position: 'topRight',
                                onClosed: function () {
                                    $('#myTable').DataTable().ajax.reload(); // Reload the DataTable after successful decline
                                }
                            });

                            // Show iziToast success message here
                            iziToast.success({
                                title: 'Success',
                                message: 'Decline email sent successfully',
                                position: 'topRight'
                            });
                        } else {
                            iziToast.error({
                                title: 'Error',
                                message: response.message,
                                position: 'topRight'
                            });
                        }
                    }


                    $('.reschedule-button').click(function (e) {
                        e.preventDefault();

                        var reservationId = $(this).data('id');
                        var reservedDate = $(this).data('date');
                        var startTime = $(this).data('start');
                        var endTime = $(this).data('end');
                        var sport = $(this).data('sport');
                        var court = $(this).data('court');
                        var userName = $(this).data('name');
                        var userEmail = $(this).data('email');
                        var reservationQRCode = $(this).data('qr-code');

                        // Set values in the modal
                        $('#reservationId').val(reservationId);
                        $('#currentReservationId').val(reservationId);
                        $('#currentReservedDatetime').val(reservedDate);
                        $('#newReservedDatetime').val(reservedDate);
                        $('#newStartTime').val(startTime);
                        $('#newEndTime').val(endTime);
                        $('#userNameInput').val(userName);
                        $('#userEmailInput').val(userEmail);
                        $('#qrCodeInput').val(reservationQRCode);

                        $('#sport').val(sport);
                        $('#court').val(court);

                        $('#rescheduleModal').modal('show');
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
                                    alert('Reservation Approved successfully.');


                                } else {
                                    alert('Reservation Approved successfully..');
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
                                url: `<?= base_url('Page/generate_qrcode_and_send_emailv2/') ?>${reservationQRCode}`,
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







                    // Function to handle the "Decline" button click
                    // $(".btn-danger[data-action='decline']").click(function () {
                    //     const reservationId = $(this).data("id");
                    //     $.ajax({
                    //         url: `<?= base_url('Page/decline_reservation/') ?>${reservationId}`,
                    //         type: "GET",
                    //         dataType: "json",
                    //         success: function (data) {
                    //             if (data.status === "success") {
                    //                 $("#responseBody").text("Reservation declined successfully.");
                    //             } else {
                    //                 $("#responseBody").text("Failed to decline reservation: " + data.message);
                    //             }
                    //             $('#responseModal').modal('show');
                    //         },
                    //         error: function (xhr, status, error) {
                    //             console.error("AJAX Error:", error);
                    //         }
                    //     });
                    // });
                    // responseModal.addEventListener('hidden.bs.modal', function () {
                    //     responseBody.innerText = '';
                    //     location.reload();
                    // });

                    // responseModal.querySelector('.btn-secondary').addEventListener('click', function () {
                    //     responseBody.innerText = '';
                    //     $('#responseModal').modal('hide');
                    //     location.reload();
                    // });

                    $.ajax({
                        type: 'GET',
                        url: '<?php echo site_url("Page/get_court_choices"); ?>',
                        dataType: 'json',
                        success: function (courts) {
                            var courtSelect = document.getElementById('court');


                            courts.forEach(function (court) {
                                var option = document.createElement('option');
                                option.value = court.court_id;
                                option.text = court.court_id;
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