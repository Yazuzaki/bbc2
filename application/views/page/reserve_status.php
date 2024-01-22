<!-- Assuming you want to display reservation status in a tabular format -->
<h2>Your Reservation Status</h2>

<?php if (!empty($reservations)): ?>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Reserved Datetime</th>
            <th>Status</th>
            <!-- Add more columns as needed -->
        </tr>
        <?php foreach ($reservations as $reservation): ?>
            <tr>
                <td><?php echo $reservation->id; ?></td>
                <td><?php echo $reservation->reserved_datetime; ?></td>
                <td><?php echo $reservation->status; ?></td>
                <!-- Add more cells as needed -->
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>No reservations found for the user.</p>
<?php endif; ?>
