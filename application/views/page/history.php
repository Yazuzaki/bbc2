<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Declined Reservations</title>
    <style>
            table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #dee2e6;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #dee2e6;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f8f9fa;
        }


        tr:hover {
            background-color: #f2f2f2;
        }


        .status-pending {
            color: #FFA500;
        }

        .table-container {
            text-align: center;
        }


        .pagination {
            justify-content: center;
        }

        .table,
        th,
        td {
            color: black;
        }

        .table-hover tbody tr:hover {
            background-color: #58D68D;
        }

        .nav .nav-item button.active {
            background-color: transparent;
            color: var(--bs-danger) !important;
        }

        .nav .nav-item button.active::after {
            content: "";
            border-bottom: 4px solid var(--bs-danger);
            width: 100%;
            position: absolute;
            left: 0;
            bottom: -1px;
            border-radius: 5px 5px 0 0;
        }


        td:nth-child(5) {
            color: blue;
        }


        td:nth-child(6) {
            color: violet;
        }

        .no-reservations {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
        }

    </style>
</head>
<body>
    <br>
    <br>
    <?php if (!empty($declined)) : ?>
        <?php
        // Define the number of reservations per page
        $reservationsPerPage = 10;

        // Calculate the total number of pages
        $totalPages = ceil(count($declined) / $reservationsPerPage);

        // Get the current page from the URL parameter
        $currentPage = isset($_GET['page']) ? max(1, min((int)$_GET['page'], $totalPages)) : 1;

        // Calculate the starting index for displaying reservations on the current page
        $startIndex = ($currentPage - 1) * $reservationsPerPage;

        // Create a subset of declined reservations to display on the current page
        $displayDeclined = array_slice($declined, $startIndex, $reservationsPerPage);
        ?>
        <br>
        <h2>Declined</h2>
        <table class="table-hover" width="600" border="0" cellspacing="5" cellpadding="5">
            <tr style="background:#CCC">
                <th>Reserve ID</th>
                <th>Reserved Datetime</th>
                <th>Created on</th>
                <th>Court</th>
                <th>Sport</th>
                <th>Status</th>
            </tr>
            <?php foreach ($displayDeclined as $row) : ?>
                <tr>
                    <td><?= $row->id ?></td>
                    <td><?= $row->reserved_datetime ?></td>
                    <td><?= $row->created_at ?></td>
                    <td><?= $row->court ?></td>
                    <td><?= $row->sport ?></td>
                    <td><?= $row->status ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <!-- Pagination links -->
        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <?php
                                $previousPage = $currentPage - 1;
                                $nextPage = $currentPage + 1;

                                if ($currentPage > 1) {
                                    echo '<li class="page-item"><a class="page-link" href="?page=' . $previousPage . '">Previous</a></li>';
                                }

                                for ($i = 1; $i <= $totalPages; $i++) {
                                    $activeClass = ($i === $currentPage) ? 'active' : '';
                                    echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                                }

                                if ($currentPage < $totalPages) {
                                    echo '<li class="page-item"><a class="page-link" href="?page=' . $nextPage . '">Next</a></li>';
                                }
                                ?>
                            </ul>
                        </nav>
    <?php else : ?>
        <p class="no-reservations">No declined reservations available.</p>
    <?php endif; ?>
</body>
</html>
