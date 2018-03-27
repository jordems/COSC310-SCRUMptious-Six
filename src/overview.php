<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
include 'includes/fusioncharts.php';
sec_session_start();
if (login_check($mysqli) == false) {
    // If not Logged in then send to login page
    header('Location:login.php');
}
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html>
<head>
<title>SCRUMptious</title>
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
   <a href="overview.php"><img src="img/sf_logo.png" alt="Logo" id="logo" /></a>
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
    <section id="leftColumn" class="backlight">
      <!-- The latest updates associated with the particular user's account shown here -->

        <h2>Latest Updates</h2>
        <!-- Going to need Javascript/PHP/Database to have this work in real time with real content  -->
        <p><span class="headline">Mar 11, 2018</span></p>
         <p>The value of your investment increased $50.00.</p>
        <p><span class="headline">Mar 9, 2018</span> </p>
        <p>You deposited $300.00 in your savings account with RBC.</p>
        <p><span class="headline">Mar 1, 2018</span></p>
         <p>You recieved $102.00 from jordems.</p>
        <p><span class="headline">Feb 27, 2018</span> </p>
        <p>Your account with Scrumptious Finance was created!</p>

    </section>
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
    <section id="center" class="backlight">
      <h2>Overview</h2>
        <?php
        $pieChart = new FusionCharts("Pie2D", "thirdChart", "100%", 400, "chart-1", "json",
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

            $pieChart->render();
        ?>
        <div id="chart-1"></div>
    </section>
  <div class="clear"></div>
  </main>
  <footer>
    <p><a href="#">ABOUT US</a> | <a href="#">CONTACT US</a> | <a href="#">PRIVACY POLICY</a> | <a href="#">TERMS OF USE</a> | <a href="#">SUPPORT</a></p>
    <p>&copy; Copyright 2018 Scrumptious Finance. All rights reserved.</p>
  </footer>
</body>
</html>
