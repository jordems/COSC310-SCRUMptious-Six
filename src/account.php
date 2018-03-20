<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

sec_session_start();

if (login_check($mysqli) == false) {
    // If already Logged in then send to login page
    header('Location:login.php');
}
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html>
	<head lang = "en">
		<title>SF - Accounts</title>
		<meta charset="utf-8">
		<link href="css/reset.css" rel="stylesheet" type="text/css" />
		<link href="css/styles.css" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" type="image/x-icon" href="img/sf_icon.ico" />
		</head>
		<body>
		<header>
		   <div id="upper">
		   <a href="overview.php"><img src="img/sf_logo.png" alt="Logo" id="logo" /></a>
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
      <section id="leftColumn" class="backlight">
        <!-- The latest finacial news and events from the world or user's particular area shown here -->
        <h2 class="centered">Summary</h2>
        <?php
        $query = "SELECT SUM(balance) as totalBalance FROM Account WHERE uid = ?";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param('i', $user_id);
            $stmt->execute();    // Execute the prepared query.
            $stmt->store_result();
            $stmt->bind_result($totalBalance);
            $stmt->fetch();
            if ($stmt->num_rows == 1) {
              if($totalBalance != null)
                echo "<p class=\"account-summary\">Total Balance: \$$totalBalance</p>";
              else
                echo "<p class=\"account-summary\">Total Balance: \$0.00</p>";
            }
            $stmt->close();
          }

          echo "<h3 class=\"account-title\">Last 30 Days:</h2>";
          $query = "SELECT SUM(amount) as totalDeposits FROM AccountTransaction WHERE amount > 0 AND uid = ? AND date BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()";
          if ($stmt = $mysqli->prepare($query)) {
              $stmt->bind_param('i', $user_id);
              $stmt->execute();    // Execute the prepared query.
              $stmt->store_result();
              $stmt->bind_result($totalDeposits);
              $stmt->fetch();
              if ($stmt->num_rows == 1) {
                if($totalDeposits != null)
                  echo "<p class=\"account-summary\">Total Recieved: \$$totalDeposits</p>";
                else
                  echo "<p class=\"account-summary\">Total Recieved: \$0.00</p>";
              }
              $stmt->close();
            }
            // Get the Combination of the Amount spent over all accounts in the last 30 days
            $query = "SELECT SUM(amount) as totalSpent FROM AccountTransaction WHERE amount < 0 AND uid = ? AND date BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()";
            if ($stmt = $mysqli->prepare($query)) {
                $stmt->bind_param('i', $user_id);
                $stmt->execute();    // Execute the prepared query.
                $stmt->store_result();
                $stmt->bind_result($totalSpent);
                $stmt->fetch();
                if ($stmt->num_rows == 1) {
                  if($totalSpent != null){
                    $totalSpent = abs($totalSpent);
                    echo "<p class=\"account-summary\">Total Spend: \$$totalSpent</p>";
                  }else
                    echo "<p class=\"account-summary\">Total Spend: \$0.00</p>";
                }
                $stmt->close();
              }
        ?>
      </section>
			<section id="center-noright">
			<h2 id="account-title">Accounts</h2>
      <a href="addaccount.php" id="new-account-button">New Account</a>
      <?php
      $error = filter_input(INPUT_GET, 'deleteerror', $filter = FILTER_SANITIZE_STRING);
      $success = filter_input(INPUT_GET, 'deletesuccess', $filter = FILTER_SANITIZE_STRING);

      if (!empty($error)) {
          echo '<p class="error-msg">Error 503</p>';
      }
      if (!empty($success)) {
          echo '<p class="success-msg">Deleted Account!</p>';
      }

      $error = filter_input(INPUT_GET, 'adderror', $filter = FILTER_SANITIZE_STRING);
      $success = filter_input(INPUT_GET, 'addsuccess', $filter = FILTER_SANITIZE_STRING);

      if (!empty($error)) {
          echo '<p class="error-msg">Error 503</p>';
      }
      if (!empty($success)) {
          echo '<p class="success-msg">Added Account!</p>';
      }
      ?>
      <ul>
        <?php
        $query = "SELECT aid, title, balance, financialinstitution, type FROM Account WHERE uid = ?";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param('i', $user_id);
            $stmt->execute();    // Execute the prepared query.

            $result = $stmt->get_result();
            // get variables from result.

            while($row = $result->fetch_assoc())
            {
              $aid = $row['aid'];
              $title = $row['title'];
              $balance = $row['balance'];
              $financialinstitution = $row['financialinstitution'];
              $type = $row['type'];
              echo "<a href=\"accountdetails.php?aid=$aid\"><li class=\"account-entry\">";
              echo "<p class=\"account-title\">$title</p>";
              echo "<p class=\"account-type\">Balance: \$$balance</p>";
              echo "<p class=\"account-type\">$type with $financialinstitution</p>";
              echo "</li></a>";
            }
            $result -> free();
            $stmt->close();
          }

        ?>
      </ul>
	    </section>
  </main>
  <footer class="absolute">
    <p><a href="#">ABOUT US</a> | <a href="#">CONTACT US</a> | <a href="#">PRIVACY POLICY</a> | <a href="#">TERMS OF USE</a> | <a href="#">SUPPORT</a></p>
    <p>&copy; Copyright 2018 Scrumptious Finance. All rights reserved.</p>
  </footer>
	</body>
<html>
