<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task2</title>
    <link rel="icon" type="image/x-icon" href="images/download.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: lightsteelblue; 
        }
    </style>
</head>
<body>
     <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <h1 class="text-center">Task-2</h1>
          <form action="practice2.php" method="post" id="dateModifierForm">
           <div class="form-group">
            <label for="date">Enter Date:</label>
            <input type="date" id="date" name="date" class="form-control" value="<?php echo isset($_POST['date']) ? $_POST['date'] : ''; ?>">
           </div>
          <div class="form-group">
            <label for="rule">Select Rule:</label>
            <select id="rule" name="rule" class="form-control">
              <option value="select">Select</option>
                <option value="nBD"<?php echo isset($_POST['rule']) && $_POST['rule'] == 'nBD' ? 'selected' : ''; ?>>n Business Days</option>
                <option value="nD" <?php echo isset($_POST['rule']) && $_POST['rule'] == 'nD' ? 'selected' : ''; ?>>n Days</option>
                <option value="nW" <?php echo isset($_POST['rule']) && $_POST['rule'] == 'nW' ? 'selected' : ''; ?>>n Weeks</option>
                <option value="nM" <?php echo isset($_POST['rule']) && $_POST['rule'] == 'nM' ? 'selected' : ''; ?>>n months</option>
            </select>
          </div>
            <div class="form-group" id="nthDayInput" style="display:">
                <label for="n">Enter value of 'n' (1-31):</label>
                <input type="number" id="n" name="n" class="form-control" min="1" max="31" value="<?php echo isset($_POST['n']) ? $_POST['n'] : ''; ?>">
            </div>

          <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary btn-block">Modify Date</button>
          </div>
        </form>
      </div>
    </div>
  </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#rule').select2();
    });
</script>
</body>
</html>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $rule = $_POST['rule'];
    $n = $_POST['n'];

    if ($rule == 'select' || empty($date)) {
        echo "<div class='container mt-5'>";
        echo "<h2 class='text-center'>Error</h2>";
        echo "<p class='text-center'>Please select a rule and enter a valid date.</p>";
        echo "</div>";
        exit;
    }

    function addBusinessdays($date, $n, $rule) {
        switch($rule) {
            case 'nBD':
                $businessDaysToAdd = $n;
                $timestamp = strtotime($date);
                $dayOfWeek = date("N", $timestamp);
                if ($dayOfWeek >= 6) {
                    $timestamp = strtotime("next Monday", $timestamp);
                    $businessDaysToAdd -= 1;
                }
                // Add the remaining business days to the timestamp
                $timestamp = strtotime("+$n weekdays", $timestamp);
                $result = date("Y-m-d", $timestamp);
                echo "<div class='container mt-5'>";
                echo "<h2 class='text-center'>Next Business day</h2>";
                echo "<p class='text-center'>$result</p>";
                echo "</div>";
                break;

            case 'nD':
                $timestamp = strtotime($date);
                $timestamp = strtotime("+$n days", $timestamp);
                $result = date("Y-m-d", $timestamp);
                echo "<div class='container mt-5'>";
                echo "<h2 class='text-center'>Adding N Days</h2>";
                echo "<p class='text-center'>$result</p>";
                echo "</div>";
                break;

            case 'nW':
                $timestamp = strtotime($date);
                $timestamp = strtotime("+$n weeks", $timestamp);
                $result = date("Y-m-d", $timestamp);
                echo "<div class='container mt-5'>";
                echo "<h2 class='text-center'>Adding N Weeks</h2>";
                echo "<p class='text-center'>$result</p>";
                echo "</div>";
                break;

            case 'nM':
    $timestamp = strtotime($date);
    $year = date("Y", $timestamp);
    $month = date("m", $timestamp);
    $day = date("d", $timestamp);

    // Add N months to the date
    $timestamp = strtotime("+$n months", $timestamp);
    
    // Check if the resulting month has fewer days than the original day
    // If so, set the day to the last day of the resulting month
    if ($day > date('t', $timestamp)) {
        $day = date('t', $timestamp);
    }

    // Reconstruct the resulting date
    $result = date("Y-m-d", mktime(0, 0, 0, $month + $n, $day, $year));

    echo "<div class='container mt-5'>";
    echo "<h2 class='text-center'>Adding $n Months</h2>";
    echo "<p class='text-center'>$result</p>";
    echo "</div>";
    break;


        }
    }

    addBusinessdays($date, $n, $rule);
}
?>

