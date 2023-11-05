<!DOCTYPE html>
<html>
<head>
    <title>QR Code Reader Page</title>
</head>
<body>
<?php
// qr_code_display.php

// Check if the 'data' parameter is present in the URL
if (isset($_GET['data'])) {
    // Decode the JSON data
    $data = json_decode(urldecode($_GET['data']), true);

    // Check if the decoding was successful
    if ($data !== null) {
        // Display the data in an HTML table
        echo '<table border="1">';
        echo '<tr><th>QR Code</th><th>Reserved Datetime</th><th>Status</th><th>User Name</th><th>User Email</th><th>Court</th><th>Sport</th><th>Hours</th></tr>';
        echo '<tr>';
        echo '<td>' . $data['qr_code'] . '</td>';
        echo '<td>' . $data['reserved_datetime'] . '</td>';
        echo '<td>' . $data['status'] . '</td>';
        echo '<td>' . $data['user_name'] . '</td>';
        echo '<td>' . $data['user_email'] . '</td>';
        echo '<td>' . $data['court'] . '</td>';
        echo '<td>' . $data['sport'] . '</td>';
        echo '<td>' . $data['hours'] . '</td>';
        echo '</tr>';
        echo '</table>';
    } else {
        echo 'Invalid data format.';
    }
} else {
    echo 'Data not found.';
}
?>


    <!-- Add more data fields as needed -->

    <!-- You can also format and style the data as necessary -->
</body>
</html>
