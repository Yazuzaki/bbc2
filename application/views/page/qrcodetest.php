<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="QR Code Test Page">
    <title>QR Code Test Page</title>
</head>
<body>
    <div>
        <h2>Reservation QR Code</h2>
        <?php if (!empty($qr_code_data_uri)) { ?>
            <img src="<?= $qr_code_data_uri; ?>" alt="Reservation QR Code">
        <?php } else { ?>
            <p>No QR code available.</p>
        <?php } ?>
    </div>
</body>
</html>
