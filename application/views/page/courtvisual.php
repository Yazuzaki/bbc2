<!-- Your view file in CodeIgniter (e.g., application/views/badminton_courts.php) -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Badminton Courts</title>
    <link rel="stylesheet" href="path/to/your/custom.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script>
        $(document).ready(function () {
            $('.court-button').click(function () {
                // Remove the 'selected' class from all buttons
                $('.court-button').removeClass('selected');

                // Add the 'selected' class to the clicked button
                $(this).addClass('selected');

                // You can also perform other actions here, such as updating a form input with the selected court number
                var selectedCourt = $(this).data('court-number');
                $('#selectedCourtInput').val(selectedCourt);
            });
        });
    </script>
    <style>
        .court-button {
            width: 100px;
            height: 50px;
            margin: 10px;
            background-color: #3498db;
            color: #fff;
            border: 1px solid #2980b9;
            cursor: pointer;
            /* Add other styles as needed */
        }

        /* Add a common style for the badminton court visualization */
        .badminton-court {
            /* Your badminton court styles here */
            background-image: url('<?php echo base_url('asset/tennis-court-top-view-vector.jpg'); ?>');
            background-size: cover;
            /* Add other styles as needed */
        }

        .selected {
            background-color: #e74c3c; /* Change background color for selected court */
            border-color: #c0392b; /* Change border color for selected court */
        }
    </style>
</head>
<body>
    <h1>Badminton Courts</h1>

    <!-- Loop through 11 courts -->
    <?php for ($i = 1; $i <= 11; $i++) : ?>
        <button class="court-button" data-court-number="<?= $i ?>">Court <?= $i ?></button>
    <?php endfor; ?>

    <!-- Form input to capture selected court -->
    <form method="post" action="path/to/your/controller/action">
        <input type="hidden" id="selectedCourtInput" name="selected_court" value="">
        <button type="submit">Submit</button>
    </form>
</body>
</html>
