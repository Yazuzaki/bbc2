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
    <title>Court manager</title>
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
                <label for="tab-1" class="tab-label">Available Reservations</label>
                <div class="tab-content">
                    <table id="myTable" class="display table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Court ID</th>
                                <th>Court Number</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($courts as $court): ?>
                                <tr>
                                    <td><?= $court->court_id ?></td>
                                    <td><?= $court->court_number ?></td>
                                    <td>
                                        <select class="status-select" id="court">
                                            <?php foreach ($enumValues as $value): ?>
                                                <option value="<?= $value ?>" <?php if ($value === $court->status) echo 'selected'; ?>>
                                                    <?= $value ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="update-status" data-courtid="<?= $court->court_id ?>">
                                            Update Status
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- ... (your existing modal and add court form) ... -->
        </div>
    </div>

    <script>
       $(document).ready(function () {
    $('#myTable').DataTable();

    // Handle the click event of the update status button
    $(document).on('click', '.update-status', function () {
        var row = $(this).closest('tr');
        var statusSelect = row.find('.status-select');
        var newStatus = statusSelect.val();

        $.ajax({
            type: 'GET',
            url: '<?php echo site_url("Page/get_court_status"); ?>',
            dataType: 'json',
            success: function (courtChoices) {
                // Assuming 'court' is the ID of the select element to populate
                var courtSelect = $('#court');

                // Clear existing options
                courtSelect.empty();

                // Populate options
                courtChoices.forEach(function (court) {
                    courtSelect.append($('<option>', {
                        value: court.status,
                        text: court.status
                    }));
                });
            },
            error: function () {
                alert('Error fetching court choices');
            }
        });
    });
});

    </script>
</body>

</html>