<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Badminton Court Visualization</title>
    <style>
        /* Add your CSS styles for courts here */
        .court-container {
            display: flex;
            flex-wrap: wrap;
        }

        .court {
            position: relative;
            width: 150px;
            height: 200px;
            margin: 10px;
            cursor: pointer;
        }

        .court img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .reservation-info {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.8);
            text-align: center;
        }
    </style>
</head>
<body>

<div class="court-container" id="court-container"></div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // Fetch reservation data from the server
    $(document).ready(function() {
        $.ajax({
            url: '<?= base_url('badminton/fetch_reservations') ?>',
            type: 'GET',
            dataType: 'json',
            success: function(reservationData) {
                renderCourts(reservationData);
            },
            error: function() {
                console.error('Error fetching reservation data.');
            }
        });
    });

    function renderCourts(reservationData) {
        const courtContainer = $('#court-container');

        // Sample badminton court image URL
        const courtImageURL = 'path/to/badminton_court_image.jpg';

        // Assuming you have 11 courts
        for (let i = 1; i <= 11; i++) {
            const courtElement = $('<div class="court"></div>');
            const courtImage = $(`<img src="${courtImageURL}" alt="Badminton Court">`);
            courtElement.append(courtImage);

            const reservation = reservationData.find(res => res.court_id === i);
            if (reservation) {
                const reservationInfo = $('<div class="reservation-info"></div>');
                const status = reservation.status.charAt(0).toUpperCase() + reservation.status.slice(1);
                reservationInfo.text(`${reservation.Username} until ${reservation.EndTime} (${status})`);
                courtElement.append(reservationInfo);
            } else {
                courtElement.append('<div class="reservation-info">No one is using this court right now</div>');
            }

            courtContainer.append(courtElement);
        }
    }
</script>

</body>
</html>
