<!DOCTYPE html>
<html>
<head>
    <title>Electricity Rates Calculation</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
</head>
<body>
    <div class="container">
        <h1>Electricity Rates Calculation</h1>

        <form method="POST">
            <div class="form-group">
                <label for="voltage">Voltage (V):</label>
                <input type="number" step="0.01" class="form-control" id="voltage" name="voltage" required>
            </div>
            <div class="form-group">
                <label for="current">Current (A):</label>
                <input type="number" step="0.01" class="form-control" id="current" name="current" required>
            </div>
            <div class="form-group">
                <label for="currentRate">Current Rate (sen/kWh):</label>
                <input type="number" step="0.01" class="form-control" id="currentRate" name="currentRate" required>
            </div>
            <button type="submit" class="btn btn-primary">Calculate</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $voltage = floatval($_POST['voltage']);
            $current = floatval($_POST['current']);
            $currentRate = floatval($_POST['currentRate']);

            $tableRows = '';
            $hourTotal = 0;
            $dailyTotal = 0;

            for ($hour = 1; $hour <= 24; $hour++) {
                $power = $voltage * $current;
                $energy = $power * $hour / 1000;

                $hourTotal = ($energy) * ($currentRate / 100);
                $dailyTotal = $hourTotal;

                $tableRows .= "<tr>
                    <td>{$hour}</td>
                    <td>{$hour}</td>
                    <td>{$energy}</td>
                    <td>" . number_format($hourTotal, 2) . "</td>
                </tr>";
            }
            ?>

            <h2>Results:</h2>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Hour</th>
                        <th>Energy (kWh)</th>
                        <th>Total Price (RM)</th>
                    </tr>
                </thead>
                <tbody>
                    <?= $tableRows ?>
                </tbody>
            </table>

            <p><strong>Daily Total Price:</strong> RM <?= number_format($dailyTotal, 2) ?></p>
        <?php } ?>

    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
