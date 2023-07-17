<!DOCTYPE html>
<html>
<head>
    <title>Electricity Rates Calculation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> 
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
        function calculateElectricityRates($voltage, $current, $currentRate)    // Defining function to calculate electricity rates based on user inputs
        {
            $tableRows = '';                                                    // Initialization of $tableRows to be inserted into the HTML
            $hourlyTotals = [];                                                 // Initialization of array of rates calculated 

            for ($hour = 1; $hour <= 24; $hour++) {
                $power = $voltage * $current;
                $energy = $power * $hour / 1000;

                $hourlyTotal = ($energy) * ($currentRate / 100);
                $hourlyTotals[$hour] = $hourlyTotal;

                $tableRows .= "<tr>
                    <td>{$hour}</td>
                    <td>{$hour}</td>
                    <td>{$energy}</td>
                    <td>" . number_format($hourlyTotal, 2) . "</td>
                </tr>";
            }

            $dailyTotal = $hourlyTotals[24];                                    // Defining the total electricity rates of the day

            return [
                'tableRows' => $tableRows,
                'dailyTotal' => $dailyTotal,
            ];
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {                            // Obtaining all the user inputs using POST method
            $voltage = floatval($_POST['voltage']);
            $current = floatval($_POST['current']);
            $currentRate = floatval($_POST['currentRate']);

            $results = calculateElectricityRates($voltage, $current, $currentRate);
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
                    <?= $results['tableRows'] ?>
                </tbody>
            </table>

            <p><strong>Daily Total Price:</strong> RM <?= number_format($results['dailyTotal'], 2) ?></p>
        <?php } ?>

    </div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>
