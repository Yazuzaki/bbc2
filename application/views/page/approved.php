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
    <title>Today's Reservations</title>
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
                font-size: 14px; /* Reduce font size for tab labels */
            }

            .tab-content {
                top: 3.5em; /* Adjust the top position of tab content */
                padding: 1rem; /* Increase padding for tab content */
            }

            .modal-content {
                color: black;
                font-size: 14px; /* Reduce font size for modal content */
            }
        }
    </style>
    <div class="wrapper">
        <div class="tabs">
            <div class="tab">
                <input type="radio" name="css-tabs" id="tab-1" checked class="tab-switch">
                <label for="tab-1" class="tab-label">Today's Reservation</label>
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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Ref num</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ongoing as $row): ?>
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
                                        <?= $row->user_name ?>
                                    </td>
                                    <td>
                                        <?= $row->user_email ?>
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
                                    <td>
                                    <a href="#" class="btn btn-warning cancel-button" data-toggle="modal"
                                            data-target="#responseModal" data-action="checkout"name="checkout"
                                            data-id="<?= $row->id ?>">CheckOut</a>

                                      <!--   <a href="#" class="btn btn-success cancel-button" data-toggle="modal"
                                            data-target="#responseModal" data-action="cancel"
                                            data-id="<?= $row->id ?>">Cancel</a>

                                            <a href="#" class="btn btn-danger reschedule-button" data-toggle="modal"
                                            data-target="#rescheduleModal" data-action="reschedule"
                                            data-id="<?= $row->id ?>"
                                            data-reserved-datetime="<?= $row->reserved_datetime ?>"
                                            data-sport="<?= $row->sport ?>" data-court="<?= $row->court ?>">Reschedule</a -->


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

            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
            <script>

                function cancelReservation(reservationId) {
                    $.ajax({
                        url: `<?= base_url('Page/cancel_reservation') ?>/${encodeURIComponent(reservationId)}`,
                        type: "GET",
                        dataType: "json",
                    })
                        .done(function (data) {
                            console.log(data);
                            if (data.status === "success") {
                                alert("Reservation canceled successfully.");
                                location.reload();
                            } else {
                                alert("Failed to cancel reservation: " + data.message);
                            }
                        })
                        .fail(function (jqXHR, textStatus, errorThrown) {
                            console.error("AJAX Error:", errorThrown);
                        });
                }


                $(document).ready(function () {
                    $('#myTable').DataTable();

                });

                document.addEventListener("DOMContentLoaded", function () {
                    // Initialize variables and event listeners here

                    const approveButtons = document.querySelectorAll(".btn-success[data-action='approve']");
                    const declineButtons = document.querySelectorAll(".btn-danger[data-action='decline']");
                 

                    approveButtons.forEach(button => {
                        button.addEventListener("click", function () {
                            const reservationId = this.getAttribute("data-id");
                            const reservationRow = this.closest("tr");
                            const reservationDate = new Date(reservationRow.getAttribute("data-date"));
                            performAction(reservationId, "approve", reservationDate, reservationRow);
                        });
                    });

                    declineButtons.forEach(button => {
                        button.addEventListener("click", function () {
                            const reservationId = this.getAttribute("data-id");
                            performAction(reservationId, "decline");
                        });
                    });

                    // Inside your performAction function
                    function performAction(reservationId, action, reservationDate, reservationRow) {
                        fetch(`<?= base_url('Page/') ?>${action}_reservation/${reservationId}`, {
                            method: "POST",
                        })
                            .then(response => response.json())
                            .then(data => {
                                console.log(data);
                                if (data.status === "success") {
                                    responseBody.innerText = "Reservation " + action + " success";


                                    reservationRow.remove();


                                    if (isToday(reservationDate)) {
                                        if (action === 'approve') {

                                            const todayTable = document.getElementById('today');
                                            todayTable.appendChild(reservationRow);
                                        } else if (action === 'decline') {
                                            reservationRow.remove();

                                        }
                                    } else {
                                        if (action === 'approve') {

                                            const futureTable = document.getElementById('future');
                                            futureTable.appendChild(reservationRow);
                                        } else if (action === 'decline') {
                                            reservationRow.remove();

                                        }
                                    }

                                    refreshReservationTable();
                                } else {
                                    responseBody.innerText = data.message;
                                }
                                $('#responseModal').modal('show');
                            })
                            .catch(error => {

                            });
                    }

                    responseModal.addEventListener('hidden.bs.modal', function () {
                        responseBody.innerText = '';
                        location.reload();
                    });

                    responseModal.querySelector('.btn-secondary').addEventListener('click', function () {
                        responseBody.innerText = '';
                        $('#responseModal').modal('hide');
                        location.reload();
                    });

                    // Function to determine if the date is today
                    function isToday(date) {
                        const today = new Date();
                        return date.getDate() === today.getDate() &&
                            date.getMonth() === today.getMonth() &&
                            date.getFullYear() === today.getFullYear();
                    }

                });





            </script>
</body>

</html>