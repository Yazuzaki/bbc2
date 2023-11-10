<!DOCTYPE html>
<html>
<head>
    <title>Sport Frequency Report</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Sport Frequency Report</h1>
        <div class="row">
            <div class="col-md-6">
                <h3>Table</h3>
                <table id="sportFrequencyTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sport</th>
                            <th>Frequency</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sport_frequency as $row): ?>
                            <tr>
                                <td><?php echo $row->sport; ?></td>
                                <td><?php echo $row->frequency; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <h3>Bar Chart</h3>
                <canvas id="sportFrequencyChart" style="max-width: 400px;"></canvas>
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

        $(document).ready(function() {
            $('#sportFrequencyTable').DataTable();
        });
    </script>
</body>
</html>
