<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
include 'includes/fusioncharts.php';
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
  		<button class="dropbtn"><?php echo $_SESSION['username']." | $".getBalance($user_id, $mysqli);?></button>
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
        <li><a href="#">INVESTMENTS</a></li>
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
   
    $columnChart = new FusionCharts("Column2D", "firstChart" , "100%", 400, "chart-1", "json",
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
                {"label": "Jan", "value": "4200"},
                {"label": "Feb", "value": "8100"},
                {"label": "Mar", "value": "7200"},
                {"label": "Apr", "value": "5500"},
                {"label": "May", "value": "9100"},
                {"label": "Jun", "value": "5100"},
                {"label": "Jul", "value": "6800"},
                {"label": "Aug", "value": "6200"},
                {"label": "Sep", "value": "6100"},
                {"label": "Oct", "value": "4900"},
                {"label": "Nov", "value": "9000"},
                {"label": "Dec", "value": "7300"}
            ]
        }');

        $columnChart2 = new FusionCharts("Column2D", "secondChart", "100%", 400, "chart-2", "json",
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
                    {"label": "Jan", "value": "920"}, 
                    {"label": "Feb", "value": "230"},
                    {"label": "Mar", "value": "520"},
                    {"label": "Apr", "value": "550"},
                    {"label": "May", "value": "410"},
                    {"label": "Jun", "value": "110"},
                    {"label": "Jul", "value": "680"},
                    {"label": "Aug", "value": "820"},
                    {"label": "Sep", "value": "310"},
                    {"label": "Oct", "value": "490"},
                    {"label": "Nov", "value": "200"},
                    {"label": "Dec", "value": "730"}
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
