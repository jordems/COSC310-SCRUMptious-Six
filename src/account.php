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
      <section id="leftColumn">
        <!-- The latest finacial news and events from the world or user's particular area shown here -->
        <div class="backlight">
        <h2 class="centered">Summary</h2>
        <?php
        $query = "SELECT SUM(balance) as totalBalance, COUNT(aid) FROM Account WHERE uid = ?";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param('i', $user_id);
            $stmt->execute();    // Execute the prepared query.
            $stmt->store_result();
            $stmt->bind_result($totalBalance, $numAccount);
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
                  echo "<p class=\"account-summary\">Total Received: \$$totalDeposits</p>";
                else
                  echo "<p class=\"account-summary\">Total Received: \$0.00</p>";
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
                    echo "<p class=\"account-summary\">Total Spent: \$$totalSpent</p>";
                  }else
                    echo "<p class=\"account-summary\">Total Spent: \$0.00</p>";
                }
                $stmt->close();
              }
        ?>
      </div>
      <?php if($numAccount > 0) { ?>
        <div class="backlight">
          <h2 class="centered" style="margin-bottom:0;">Set Main Account</h2>
          <p class="centered"><em>(For Receiving Money)</em></p>
          <?php
          $error = filter_input(INPUT_GET, 'mainaccerror', $filter = FILTER_SANITIZE_STRING);
          $success = filter_input(INPUT_GET, 'mainaccsuccess', $filter = FILTER_SANITIZE_STRING);

          if (!empty($error)) {
              echo '<p class="error-msg">'.$error.'</p>';
          }
          if (!empty($success)) {
              echo '<p class="success-msg">Main Account Changed</p>';
          }
          ?>
          <form method="POST" action="includes/changeMainAccount.php">
            <select name="account" id="acc" style="width:100%" required>
              <?php
              $query = "SELECT aid, title, balance FROM Account WHERE aid = (SELECT mainAcc FROM Users WHERE uid = ?);";
              if ($stmt = $mysqli->prepare($query)) {
                  $stmt->bind_param('i', $user_id);
                  $stmt->execute();    // Execute the prepared query.

                  $result = $stmt->get_result();
                  // get variables from result.

                  if($row = $result->fetch_assoc())
                  {
                    $mainacc = $row['aid'];
                    echo "<option value=\"".$row['aid']."\" selected>".$row['title']." | \$".$row['balance']."</option>";
                  }
                  $result -> free();
                  $stmt->close();
                }
              $query = "SELECT aid, title, balance FROM Account WHERE uid = ? and aid != ?";
              if ($stmt = $mysqli->prepare($query)) {
                  $stmt->bind_param('ii', $user_id,$mainacc);
                  $stmt->execute();    // Execute the prepared query.

                  $result = $stmt->get_result();
                  // get variables from result.

                  while($row = $result->fetch_assoc())
                  {
                    echo "<option value=\"".$row['aid']."\">".$row['title']." | \$".$row['balance']."</option>";
                  }
                  $result -> free();
                  $stmt->close();
                }
              ?>
            </select>
            <input type="submit" value="Update" id="send-submit">

          </form>
        </div>
      <?php } ?>
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
          echo '<p class="error-msg" style="margin-left:1em">Error 503</p>';
      }
      if (!empty($success)) {
          echo '<p class="success-msg" style="margin-left:1em">Added Account!</p>';
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
            $hasAccount = FALSE;
              while($row = $result->fetch_assoc())
              {
                $hasAccount = TRUE;
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

              if(!$hasAccount){
                echo "
                <a href=\"addaccount.php\">
                <li class=\"account-entry\"><p class=\"account-title\">Create an Account so you can Start Sending / Recieving Money</p></li>
                </a>";
              }
              $result -> free();
              $stmt->close();
        }
        ?>
      </ul>
	    </section>
  </main>
  <!--<footer class="absolute">
    <p><a href="#">ABOUT US</a> | <a href="#">CONTACT US</a> | <a href="#">PRIVACY POLICY</a> | <a href="#">TERMS OF USE</a> | <a href="#">SUPPORT</a></p>
    <p>&copy; Copyright 2018 Scrumptious Finance. All rights reserved.</p>
  </footer> -->
	</body>
<html>
