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
    <section class="backlight">
    <h1>Financial Analysis</h1>
    <?php
    $query = "SELECT mainAcc FROM Users WHERE uid = ? LIMIT 1";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param('i', $user_id);
        $stmt->execute();    // Execute the prepared query.
        $stmt->bind_result($mainAccount);
        $stmt->fetch();
        $stmt->close();
    }
    
    // Pull user statement data from database, convert to JSON, add to data section of charts
    $janIncome = getMonthlyIncome($mysqli, $mainAccount, 1);
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
    
    $query = "SELECT amount, `desc` FROM AccountTransaction WHERE aid = ?";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param('i', $mainAccount);
            $stmt->execute();    // Execute the prepared query.

            $result = $stmt->get_result();
            
            // $arrData is the associative array that is initialized to store the chart attributes

            $arrData = array(
              "chart" => array(
                  "caption"=> "Account Transactions - Amount per Category",
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

        $query = "SELECT amount, reason FROM Transaction WHERE toid = ? OR fromid = ?";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param('ii', $mainAccount, $mainAccount);
            $stmt->execute();    // Execute the prepared query.

            $result = $stmt->get_result();
            
            // $dataArr is the associative array that is initialized to store the chart attributes

            $dataArr = array(
              "chart" => array(
                  "caption"=> "Money Transfers - Amount per Category",
                  "bgColor"=> "#555555",
                  "borderColor"=> "#666666",
                  "borderThickness"=> "4",
                  "borderAlpha"=> "80",
                  "baseFontSize"=> "12",
                  "numberPrefix"=> "$",
                  "theme"=> "zune"
              )
            );

            // $actData is the array that is initialized to store the data
            $actData = array();
            // get data from result
            while($row = $result->fetch_assoc()){
              $amount = $row['amount'];
              $reason = $row['reason'];
              $actData += [$reason => $amount];
            }
            $result -> free();
            $stmt->close();
        }
        $dataArr['data'] = array();
        
        // Iterate through the data in `$actualData` and insert in to the `$arrData` array.
        foreach ($actData as $key => $value) {
          array_push($dataArr['data'],
              array(
                  'label' => $key,
                  'value' => $value
              )
          );
        }
        // Encodes the data into JSON format for use in the chart
        $jsonData = json_encode($dataArr);

    $columnChart = new FusionCharts("Column2D", "incomeChart" , "49.8%", 400, "chart-1", "json",
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

        $columnChart2 = new FusionCharts("Column2D", "expensesChart", "49.8%", 400, "chart-2", "json",
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

         $pieChart = new FusionCharts("Pie2D", "transactionsChart", "49.8%", 400, "chart-3", "json", $jsonEncodedData);
         $pieChart2 = new FusionCharts("Pie2D", "transfersChart", "49.8%", 400, "chart-4", "json", $jsonData);


      $columnChart->render();
      $columnChart2->render();
      $pieChart->render();
      $pieChart2->render();
    ?>
    <!-- containers for inserting charts -->
    <div id="chart-1"></div>
    <div id="chart-2"></div>
    <div id="chart-3"></div>
    <div id="chart-4"></div>
    </section>
  <div class="clear"></div>
  </main>
  <footer>
    <p><a href="about.php">ABOUT US</a> | <a href="contact.php">CONTACT US</a> | <a href="privacypolicy.php">PRIVACY POLICY</a> | <a href="termsofuse.php">TERMS OF USE</a></p>
    <p>&copy; Copyright 2018 Scrumptious Finance. All rights reserved.</p>
  </footer>
</body>
</html>
