<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Task1</title>
 <link rel="icon" type="image/x-icon" href="images/download.jpg">


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
        <h1 class="text-center">Date Modifier</h1>
          <form action="task1.php" method="post" id="dateModifierForm">
           <div class="form-group">
            <label for="date">Enter Date:</label>
            <input type="date" id="date" name="date" class="form-control" value="<?php echo isset($_POST['date']) ? $_POST['date'] : ''; ?>">
           </div>
          <div class="form-group">
            <label for="rule">Select Rule:</label>
            <select id="rule" name="rule" class="form-control">
              <option value="select">Select</option>
              <option value="NWE" <?php echo isset($_POST['rule']) && $_POST['rule'] == 'NWE' ? 'selected' : ''; ?>>Next Week End</option>
              <option value="NME" <?php echo isset($_POST['rule']) && $_POST['rule'] == 'NME' ? 'selected' : ''; ?>>Next Month End</option>
              <option value="nNM" <?php echo isset($_POST['rule']) && $_POST['rule'] == 'nNM' ? 'selected' : ''; ?>>nth day in Next Month</option>
            </select>
          </div>
          <div class="form-group" id="nthDayInput" style="<?php echo isset($_POST['rule']) && $_POST['rule'] == 'nNM' ? 'display: block;' : 'display: none;'; ?>">
            <label for="n">Enter value of 'n' (1-31):</label>
            <input type="number" id="n" name="n" class="form-control"  value="<?php echo isset($_POST['n']) ? $_POST['n'] : ''; ?>">
          </div>
          <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary btn-block">Modify Date</button>
          </div>
        </form>
      </div>
    </div>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('rule').addEventListener('change', function() {
        var selectedRule = this.value;
        var nthDayInput = document.getElementById('nthDayInput');
        
        if (selectedRule === 'nNM') {
            nthDayInput.style.display = 'block';
        } else {
            nthDayInput.style.display = 'none';
        }
    });
});
</script>

</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $rule = $_POST['rule'];

    if ($rule == 'select' || empty($date)) {
        echo "<div class='container mt-5'>";
        echo "<h2 class='text-center'>Error</h2>";
        echo "<p class='text-center'>Please select a rule and enter a valid date.</p>";
        echo "</div>";
        exit;
    }

    switch ($rule) {
        case 'NWE':
            $nextFriday = date('d-m-Y', strtotime('next friday', strtotime($date)));
           echo "<div class='container mt-5'>";
           echo "<h2 class='text-center'>Next Weekend</h2>";
           echo "<p class='text-center'>$nextFriday</p>";
           echo "</div>";
        break;
        case 'NME':
            $nextMonthEnd = date('d-m-Y', strtotime('last day of next month', strtotime($date)));
            echo "<div class='container mt-5'>";
            echo "<h2 class='text-center'>Next Month End</h2>";
            echo "<p class='text-center'>$nextMonthEnd</p>";
            echo "</div>";
        break;
        case 'nNM':
    $n = $_POST['n'];    
    $next_month = date("Y-m-d", strtotime("first day of next month", strtotime($date)));
    
    // Check if $n is within the range 1 to 31
    if ($n >= 1 && $n <= 31) {
        while ($n > date("t", strtotime($next_month))) {
            $next_month = date("Y-m-d", strtotime("first day of next month", strtotime($next_month)));
        }
        
        $nth_day = date("d-m-Y", strtotime("+$n days -1 day", strtotime($next_month)));
        echo "<div class='container mt-5'>";
        echo "<h2 class='text-center'>Nth day in next month</h2>";
        echo "<p class='text-center'>$nth_day</p>";
        echo "</div>";
    } else {
        // Display SweetAlert error message
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Invalid value for n. Please enter a value between 1 and 31.'
                });
            </script>";
    }
break;






    }
}
?>

