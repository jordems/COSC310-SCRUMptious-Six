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
        // Pull user statement data from database, convert to JSON, add to data section of charts
        $query = "SELECT mainAcc FROM Users WHERE uid = ? LIMIT 1";
        if ($stmt = $mysqli->prepare($query)) {
          $stmt->bind_param('i', $user_id);
          $stmt->execute();    // Execute the prepared query.
          $stmt->bind_result($mainAccount);
          $stmt->fetch();
          $stmt->close();
        }

        $query = "SELECT amount, `desc` FROM AccountTransaction WHERE aid = ?";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param('i', $mainAccount);
            $stmt->execute();    // Execute the prepared query.

            $result = $stmt->get_result();
            
            // $arrData is the associative array that is initialized to store the chart attributes

            $arrData = array(
              "chart" => array(
                  "caption"=> "Transactions - Amount per Category",
                  "bgColor"=> "#555555",
                  "borderColor"=> "#666666",
                  "borderThickness"=> "4",
                  "borderAlpha"=> "80",
                  "baseFontSize"=> "12",
                  "numberPrefix"=> "$",
                  "theme"=> "zune"
              )
            );

            // $actualData is the array that is initialized to store the data
            $actualData = array();
            // get data from result
            while($row = $result->fetch_assoc()){
              $amount = $row['amount'];
              $desc = $row['desc'];
              $amount = abs($amount);
              $actualData += [$desc => $amount];
            }
            $result -> free();
            $stmt->close();
        }
        $arrData['data'] = array();
        
        // Iterate through the data in `$actualData` and insert in to the `$arrData` array.
        foreach ($actualData as $key => $value) {
          array_push($arrData['data'],
              array(
                  'label' => $key,
                  'value' => $value
              )
          );
        }
        // Encodes the data into JSON format for use in the chart
        $jsonEncodedData = json_encode($arrData);

       // echo $jsonEncodedData;
        $pieChart = new FusionCharts("Pie2D", "thirdChart", "100%", 400, "chart-1", "json", $jsonEncodedData);

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
