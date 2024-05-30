<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task-1b</title>
    <link rel="icon" type="image/x-icon" href="images/download.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: lightblue; 
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="text-center">Currency Converter</h1>
    <form action="update1.php" method="post">
        <div class="mb-3">
            <label for="amount" class="form-label">Amount:</label>
            <input type="text" id="amount" name="amount" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="from" class="form-label">From Currency:</label>
            <select id="from1" name="from1" class="form-control select2" required>
                <option value="">Select Currency</option>
                <?php
                // PHP code to generate select options
                $currencies = array(
                    "USD" => "USD - United States Dollar",
                    "EUR" => "EUR - Euro",
                    "GBP" => "GBP - British Pound Sterling",
                    "JPY" => "JPY - Japanese Yen",
                    "CAD" => "CAD - Canadian Dollar",
                    "AUD" => "AUD - Australian Dollar",
                    "CHF" => "CHF - Swiss Franc",
                    "CNY" => "CNY - Chinese Yuan",
                    "INR" => "INR - Indian Rupee",
                    "RUB" => "RUB - Russian Ruble",
                    "KRW" => "KRW - South Korean Won",
                    "SGD" => "SGD - Singapore Dollar"
                );
                foreach ($currencies as $code => $name) {
                    echo "<option value=\"$code\">$name</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="to" class="form-label">To Currency:</label>
            <select id="to1" name="to1" class="form-control select2" required>
                <option value="">Select Currency</option>
                <?php
                // PHP code to generate select options
                foreach ($currencies as $code => $name) {
                    echo "<option value=\"$code\">$name</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Convert</button>
    </form>
    
    <?php
    if(isset($_POST['amount'])) {
        $amount = $_POST['amount'];
        $from = $_POST['from1'];
        $to = $_POST['to1'];
        
        $from_exchange_rates = json_decode(file_get_contents("https://api.exchangerate-api.com/v4/latest/" . $from ), true );
        $to_exchange_rates = json_decode(file_get_contents("https://api.exchangerate-api.com/v4/latest/" . $to),true);
        if ($from_exchange_rates && isset($from_exchange_rates["rates"][$to]) &&
            $to_exchange_rates && isset($to_exchange_rates["rates"][$from])) {
            $conversion_rate_to_target = $from_exchange_rates["rates"][$to];
            $converted_amount_to = $amount * $conversion_rate_to_target;
            
            // Display the result
            echo "<div class='container mt-3'>";
            echo "<h2 class='text-center'>Conversion Result</h2>";
            echo "<p class='text-center'>$amount $from = $converted_amount_to $to</p>";
            echo "</div>";
        } else {
            echo "<div class='container mt-3'>";
            echo "<p class='text-center text-danger'>Selected currency conversion rate not available.</p>";
            echo "</div>";
        }
    } else {
        echo "<div class='container mt-3'>";
        // echo "<p class='text-center text-danger'>Failed to connect to the currency exchange rate API.</p>";
        echo "</div>";
    }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2').select2();
});
</script>

</body>
</html>
