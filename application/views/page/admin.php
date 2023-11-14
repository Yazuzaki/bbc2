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
        <h1 class="my-4">Sport Frequency Report</h1>
      
        <div class="row">
            <div class="col-md-12">
                <h3>Bar Chart</h3>
                <canvas id="sportFrequencyChart" style="max-width: 800px;"></canvas>
            </div>
        </div>
    </div>
   
    <script>
        // Your sport frequency data from PHP
        var sportData = <?php echo json_encode($sport_frequency); ?>;

        var sportLabels = sportData.map(item => item.sport);
        var sportFrequency = sportData.map(item => item.frequency);

        // Create a bar chart
        var ctx = document.getElementById('sportFrequencyChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: sportLabels,
                datasets: [{
                    label: 'Sport Frequency',
                    data: sportFrequency,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
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
