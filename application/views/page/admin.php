<!DOCTYPE html>
<html>

<head>
    <title>Sport Frequency Report</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container">

        <!-- Banner with color background -->
        <div class="jumbotron text-white bg-primary">
            <h1 class="display-4">Admin Dashboard</h1>
        </div>

        <!-- Cards Section -->
        <div class="row">

            <div class="col-md-3">
                <div class="card d-flex flex-fill bg-success rounded">
                    <div class="card-body">
                        <h3 class="card-title">Top Reservations</h3>
                        <p class="card-text">Frequent Reservation:
                            <?php foreach ($top_reservers as $reserver): ?>
                            <p>Username:
                                <?php echo $reserver->Username; ?>, <br>Reservation Count:
                                <?php echo $reserver->ReservationCount; ?>
                            </p>
                        <?php endforeach; ?>

                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card d-flex flex-fill bg-success rounded">
                    <div class="card-body">
                        <h3 class="card-title">Declined Reservations</h3>
                        <p class="card-text">Total Declined Reservations:
                            <?php echo $declinedCount; ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card d-flex flex-fill bg-success rounded">
                    <div class="card-body">
                        <h3 class="card-title">Pending Reservations</h3>
                        <p class="card-text">Total Pending Reservations:
                            <?php echo $pendingCount; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>


        <!-- Chart Section -->
        <div class="row">
            <div class="col-md-12">
                <h3>Sport Frequency Chart</h3>
                <canvas id="sportFrequencyChart" style="max-width: 800px;"></canvas>
            </div>
        </div>
    </div>

    <script>
        var sportData = <?php echo json_encode($sport_frequency); ?>;

        var sportLabels = sportData.map(item => item.sport_id);
        var sportFrequency = sportData.map(item => item.frequency);

        // Define an array of colors for each bar
        var barColors = [
            'rgba(75, 192, 192, 0.2)',
            'rgba(255, 99, 132, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            // Add more colors as needed
        ];

        // Create a bar chart with different colors
        var ctx = document.getElementById('sportFrequencyChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: sportLabels,
                datasets: [{
                    label: 'Sport Frequency',
                    data: sportFrequency,
                    backgroundColor: barColors,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Frequency'
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>