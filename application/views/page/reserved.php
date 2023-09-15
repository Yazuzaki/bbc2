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
                $(document).ready(function () {
                    $('#myTable').DataTable();
                });

                $(document).ready(function () {
                    $('.cancel-button').click(function (e) {
                        e.preventDefault();

                        var reservationId = $(this).data('id');

                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url('page/cancel_reservation'); ?>',
                            data: { reservationId: reservationId },
                            dataType: 'json',
                            success: function (response) {
                                if (response.status === 'success') {
                                    // Handle success, e.g., update the UI or show a success message
                                    $('#responseBody').html('Reservation canceled successfully.');
                                } else {
                                    // Handle error, e.g., show an error message
                                    $('#responseBody').html('Failed to cancel reservation.');
                                }

                                // Show the response modal
                                $('#responseModal').modal('show');
                            },
                            error: function () {
                                // Handle AJAX error
                                $('#responseBody').html('An error occurred during the request.');
                                $('#responseModal').modal('show');
                            }
                        });
                    });

                    // Add an event listener to the close button of the modal
                    $('#responseModal').on('hidden.bs.modal', function () {
                        $('#responseBody').empty(); // Clear the response body text
                        location.reload(); // Reload the page
                    });
                });
            </script>
</body>

</html>