<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="asset\BBCLOGO.jpg">
    <title>Timeline</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .table-hover tbody tr:hover {
            background-color: #58D68D;
        }

        .status-pending {
            color: #FFA500;
        }

        .status-approved {
            color: #00FF00;
        }

        .status-declined {
            color: #FF0000;
        }
    </style>
</head>

<body>
    <br>
    <br>
    <?php echo form_open('Page/fetch_reservations') ?>
    <label for="start_date">From :</label>
    <input type="date" id="start_date" name="start_date">
    <label for="end_date">To :</label>
    <input type="date" id="end_date" name="end_date">
    <button type="submit" class="btn btn-primary">Filter</button>
    <?php echo form_close(); ?>
    <div id="reservationTableContainer">
        <?php if (!empty($reservations)): ?>
            <?php
            usort($reservations, function ($a, $b) {
                return strtotime($a->reserved_datetime) - strtotime($b->reserved_datetime);
            });
            ?>
            <table class="table-hover" width="600" border="0" cellspacing="5" cellpadding="5">
                <tr style="background:#CCC">
                    <th>Reserve ID</th>
                    <th>Reserved Datetime</th>
                    <th>Created on</th>
                    <th>Status</th>
                    <th>Court</th>
                    <th>Sport</th>
                    <th>Action</th>
                </tr>
                <?php
                foreach ($reservations as $row) {
                    echo "<tr>";
                    echo "<td>" . $row->id . "</td>";
                    echo "<td>" . $row->reserved_datetime . "</td>";
                    echo "<td>" . $row->created_at . "</td>";
                    echo "<td class=\"status-" . strtolower($row->status) . "\">" . $row->status . "</td>";
                    echo "<td>" . $row->court . "</td>";
                    echo "<td>" . $row->sport . "</td>";
                    echo '<td>';

                    echo '<a href="#" data-toggle="modal" data-target="#responseModal" data-action="approve" data-id="' . $row->id . '" class="btn btn-success">Approve</a>';
                    echo ' ';
                    echo '<a href="#" data-toggle="modal" data-target="#responseModal" data-action="decline" data-id="' . $row->id . '" class="btn btn-danger">Decline</a>';

                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </table>
        <?php else: ?>
            <p>No reservations available.</p>
        <?php endif; ?>
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

</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const responseModal = document.getElementById('responseModal');
        const responseBody = document.getElementById('responseBody');

        const approveButtons = document.querySelectorAll(".btn-success[data-action='approve']");
        const declineButtons = document.querySelectorAll(".btn-danger[data-action='decline']");

        approveButtons.forEach(button => {
            button.addEventListener("click", function () {
                const reservationId = this.getAttribute("data-id");
                performAction(reservationId, "approve");
            });
        });

        declineButtons.forEach(button => {
            button.addEventListener("click", function () {
                const reservationId = this.getAttribute("data-id");
                performAction(reservationId, "decline");
            });
        });



        function performAction(reservationId, action) {
            fetch(`<?= base_url('Page/') ?>${action}_reservation/${reservationId}`, {
                method: "GET",
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        responseBody.innerText = "Reservation has been " + action + "d.";
                    } else {
                        responseBody.innerText = data.message;
                    }
                    $('#responseModal').modal('show');
                })
                .catch(error => {
                    console.error(error);
                });
        }

        responseModal.addEventListener('hidden.bs.modal', function () {
            responseBody.innerText = '';
            location.reload();
        });

        responseModal.querySelector('.btn-secondary').addEventListener('click', function () {
            responseBody.innerText = '';
            $('#responseModal').modal('hide');
        });


        // AJAX for date filtering
        const dateFilterForm = document.getElementById('dateFilterForm');
        const reservationTableContainer = document.getElementById('reservationTableContainer');

        dateFilterForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(dateFilterForm);

            fetch('<?= site_url('Page/fetch_reservations') ?>', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    reservationTableContainer.innerHTML = data; // Update reservation table content
                })
                .catch(error => {
                    console.error(error);
                });
        });
    });
</script>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>