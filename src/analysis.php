<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
include_once 'includes/getMonthlyData.php';
include_once 'includes/fusioncharts.php';

sec_session_start();

if (login_check($mysqli) == false) {
  // If not logged in then send to login page
  header('Location:login.php');
}

$user_id = $_SESSION['user_id'];

?>
  <!DOCTYPE html>
  <html>
  <head>
  <title>SF - Analysis</title>
  <meta charset="utf-8">
  <link href="css/reset.css" rel="stylesheet" type="text/css" />
  <link href="css/styles.css" rel="stylesheet" type="text/css" />
  <link rel="shortcut icon" type="image/x-icon" href="img/sf_icon.ico" />
  <script src="js/fusioncharts.js"></script>
  <script src="js/fusioncharts.charts.js"></script>
  </head>
  <body>
  <header>
     <div id="upper">
     <img src="img/sf_logo.png" alt="Logo" id="logo" />
     <div class="dropdown">
       <!-- Add php to pull user's name and add it here -->
		<button class="dropbtn"><?php echo $_SESSION['username'];?></button>
  		<div class="dropdown-content">
  			<p><a href="profile.php">Account</a></p>
  			<p><a href="includes/logout.php">Logout</a></p>
  		</div>
  	</div>
     </div>
     <div id="lower">
      <nav>
      <ul>
        <li><a href="overview.php">OVERVIEW</a></li>
        <li><a href="account.php">ACCOUNTS</a></li>
        <li><a href="addCSV.php">BANK STATEMENTS</a></li>
        <li><a href="transactions.php">TRANSACTIONS</a></li>
        <li><a href="Investments.php">INVESTMENTS</a></li>
        <li><a href="analysis.php">ANALYSIS</a></li>
        <li><a href="calendar.php">CALENDAR</a></li>
      </ul>
      </nav>
     </div>
  </header>
  <main>
    <section id="rightColumn" class="backlight">
      <!-- The latest finacial news and events from the world or user's particular area shown here -->
      <h2>News and Events</h2>
        <ul>
          <li><a href="#">False alarm, everything is going to be okay.</a></li>
          <li><a href="#">The stock market has crashed, the end of the world is near.</a></li>
          <li><a href="#">A new bank has opened in your area.</a></li>
          <li><a href="#">Disney buys 21st Century Fox for $52.4 billion.</a></li>
        </ul>
    </section>
    <section id="center-noleft" class="backlight">
    <h1>Financial Analysis</h1>
    <?php
    $query = "SELECT mainAcc FROM Users WHERE uid = ? LIMIT 1";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param('i', $user_id);
        $stmt->execute();    // Execute the prepared query.
        $stmt->bind_result($mainAccount);
        $stmt->fetch();
    }
    // Pull user statement data from database, convert to JSON, add to data section of charts
    $janIncome = getMonthlyIncome($mysqli, $mainAccount, 1);
    if($janIncome == NULL || $janIncome == 0){
        echo "NOOOOO";
    }
    $febIncome = getMonthlyIncome($mysqli, $mainAccount, 2);
    $marIncome = getMonthlyIncome($mysqli, $mainAccount, 3);
    $aprilIncome = getMonthlyIncome($mysqli, $mainAccount, 4);
    $mayIncome = getMonthlyIncome($mysqli, $mainAccount, 5);
    $juneIncome = getMonthlyIncome($mysqli, $mainAccount, 6);
    $julyIncome = getMonthlyIncome($mysqli, $mainAccount, 7);
    $augIncome = getMonthlyIncome($mysqli, $mainAccount, 8);
    $sepIncome = getMonthlyIncome($mysqli, $mainAccount, 9);
    $octIncome = getMonthlyIncome($mysqli, $mainAccount, 10);
    $novIncome = getMonthlyIncome($mysqli, $mainAccount, 11);
    $decIncome = getMonthlyIncome($mysqli, $mainAccount, 12);

    $janExpenses = getMonthlyExpenses($mysqli, $mainAccount, 1);
    $febExpenses = getMonthlyExpenses($mysqli, $mainAccount, 2);
    $marExpenses = getMonthlyExpenses($mysqli, $mainAccount, 3);
    $aprilExpenses = getMonthlyExpenses($mysqli, $mainAccount, 4);
    $mayExpenses = getMonthlyExpenses($mysqli, $mainAccount, 5);
    $juneExpenses = getMonthlyExpenses($mysqli, $mainAccount, 6);
    $julyExpenses = getMonthlyExpenses($mysqli, $mainAccount, 7);
    $augExpenses = getMonthlyExpenses($mysqli, $mainAccount, 8);
    $sepExpenses = getMonthlyExpenses($mysqli, $mainAccount, 9);
    $octExpenses = getMonthlyExpenses($mysqli, $mainAccount, 10);
    $novExpenses = getMonthlyExpenses($mysqli, $mainAccount, 11);
    $decExpenses = getMonthlyExpenses($mysqli, $mainAccount, 12);

    $columnChart = new FusionCharts("Column2D", "incomeChart" , "100%", 400, "chart-1", "json",
    '{
        "chart": {
            "caption": "Monthly Income for Last Year",
            "bgColor": "#555555",
            "borderColor": "#666666",
            "borderThickness": "4",
            "borderAlpha": "80",
            "baseFontSize": "12",
            "xAxisName": "Month",
            "yAxisName": "Income",
            "numberPrefix": "$",
            "theme": "zune"
        },
        "data": [
                {"label": "Jan", "value": "'.$janIncome.'"},
                {"label": "Feb", "value": "'.$febIncome.'"},
                {"label": "Mar", "value": "'.$marIncome.'"},
                {"label": "Apr", "value": "'.$aprilIncome.'"},
                {"label": "May", "value": "'.$mayIncome.'"},
                {"label": "Jun", "value": "'.$juneIncome.'"},
                {"label": "Jul", "value": "'.$julyIncome.'"},
                {"label": "Aug", "value": "'.$augIncome.'"},
                {"label": "Sep", "value": "'.$sepIncome.'"},
                {"label": "Oct", "value": "'.$octIncome.'"},
                {"label": "Nov", "value": "'.$novIncome.'"},
                {"label": "Dec", "value": "'.$decIncome.'"}
            ]
        }');

        $columnChart2 = new FusionCharts("Column2D", "expensesChart", "100%", 400, "chart-2", "json",
        '{
            "chart": {
                "caption": "Monthly Expenses for Last Year",
                "bgColor": "#555555",
                "borderColor": "#666666",
                "borderThickness": "4",
                "borderAlpha": "80",
                "baseFontSize": "12",
                "xAxisName": "Month",
                "yAxisName": "Expenses",
                "numberPrefix": "$",
                "theme": "zune"
            },
            "data": [
                    {"label": "Jan", "value": "'.$janExpenses.'"},
                    {"label": "Feb", "value": "'.$febExpenses.'"},
                    {"label": "Mar", "value": "'.$marExpenses.'"},
                    {"label": "Apr", "value": "'.$aprilExpenses.'"},
                    {"label": "May", "value": "'.$mayExpenses.'"},
                    {"label": "Jun", "value": "'.$juneExpenses.'"},
                    {"label": "Jul", "value": "'.$julyExpenses.'"},
                    {"label": "Aug", "value": "'.$augExpenses.'"},
                    {"label": "Sep", "value": "'.$sepExpenses.'"},
                    {"label": "Oct", "value": "'.$octExpenses.'"},
                    {"label": "Nov", "value": "'.$novExpenses.'"},
                    {"label": "Dec", "value": "'.$decExpenses.'"}
                ]
            }');

            $pieChart = new FusionCharts("Pie2D", "thirdChart", "100%", 400, "chart-3", "json",
        '{
            "chart": {
                "caption": "Transactions - Amount per Category",
                "bgColor": "#555555",
                "borderColor": "#666666",
                "borderThickness": "4",
                "borderAlpha": "80",
                "baseFontSize": "12",
                "xAxisName": "Month",
                "yAxisName": "Revenues",
                "numberPrefix": "$",
                "theme": "zune"
            },
            "data": [
                    {"label": "Bills", "value": "420"},
                    {"label": "Entertainment", "value": "810"},
                    {"label": "Food", "value": "220"},
                    {"label": "Work/Education", "value": "1550"},
                    {"label": "Insurance", "value": "910"},
                    {"label": "Other", "value": "510"}
                ]
            }');

      $columnChart->render();
      $columnChart2->render();
      $pieChart->render();
    ?>
    <!-- containers for inserting charts -->
    <div id="chart-1"></div>
    <div id="chart-2"></div>
    <div id="chart-3"></div>
    </section>
  <div class="clear"></div>
  </main>
  <footer>
    <p><a href="#">ABOUT US</a> | <a href="#">CONTACT US</a> | <a href="#">PRIVACY POLICY</a> | <a href="#">TERMS OF USE</a> | <a href="#">SUPPORT</a></p>
    <p>&copy; Copyright 2018 Scrumpptious Finance. All rights reserved.</p>
  </footer>
</body>
</html>
