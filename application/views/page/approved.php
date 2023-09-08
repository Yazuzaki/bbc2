<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Today's Reservations</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #007BFF;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
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
    <?php if (!empty($today)): ?>
        <?php
        // Define the number of reservations per page
        $reservationsPerPage = 10;

        // Calculate the total number of pages
        $totalPages = ceil(count($today) / $reservationsPerPage);

        // Get the current page from the URL parameter
        $currentPage = isset($_GET['page']) ? max(1, min((int) $_GET['page'], $totalPages)) : 1;

        // Calculate the starting index for displaying reservations on the current page
        $startIndex = ($currentPage - 1) * $reservationsPerPage;

        // Create a subset of reservations to display on the current page
        $displayReservations = array_slice($today, $startIndex, $reservationsPerPage);
        ?>
        <table class="table-hover" width="600" border="0" cellspacing="5" cellpadding="5">
            <tr style="background:#CCC">
                <th>Reserve ID</th>
                <th>Reserved Datetime</th>
                <th>Created on</th>
                <th>Court</th>
                <th>Sport</th>
                <th>Status</th>
            </tr>
            <?php foreach ($displayReservations as $row): ?>
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
                    <td>
                        <?= $row->court ?>
                    </td>
                    <td>
                        <?= $row->sport ?>
                    </td>
                    <td>
                        <?= $row->status ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <!-- Pagination links -->
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <?php
                // Display pagination links
                for ($i = 1; $i <= $totalPages; $i++) {
                    $activeClass = ($i === $currentPage) ? 'active' : '';
                    echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                }
                ?>
            </ul>
        </nav>
    <?php else: ?>
        <p>No today's reservations available.</p>
    <?php endif; ?>

</body>

</html>