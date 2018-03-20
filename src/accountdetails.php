<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

sec_session_start();
if(isset($_GET['aid']))
  $aid = filter_input(INPUT_GET, 'aid', FILTER_SANITIZE_STRING);
else
  header('Location:login.php'); // Redirect if no account id is given

if (login_check($mysqli) == false) {
    // If already Logged in then send to login page
    header('Location:index.php');
    exit(0);
}
$user_id = $_SESSION['user_id'];

if(!userHasAccount($user_id, $aid, $mysqli)){
  // Account doesn't belong to user so redirect them
  header('Location:index.php');
  exit(0);
}
?>
<!DOCTYPE html>
<html>
	<head lang = "en">
		<title>SF - Account Details</title>
		<meta charset="utf-8">
		<link href="css/reset.css" rel="stylesheet" type="text/css" />
		<link href="css/styles.css" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" type="image/x-icon" href="img/sf_icon.ico" />
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
      <section id="leftColumn" >
        <!-- The latest finacial news and events from the world or user's particular area shown here -->
        <div class="backlight">
          <h2 class="centered">Account Summary</h2>
          <?php
          $query = "SELECT SUM(balance) as totalBalance FROM Account WHERE aid = ?";
          if ($stmt = $mysqli->prepare($query)) {
              $stmt->bind_param('i', $aid);
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

            echo "<h3 class=\"account-title\">Last 30 Days:</h3>";
            $query = "SELECT SUM(amount) as totalDeposits FROM AccountTransaction WHERE amount > 0 AND aid = ? AND `date` BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()";
            if ($stmt = $mysqli->prepare($query)) {
                $stmt->bind_param('i', $aid);
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
              $query = "SELECT SUM(amount) as totalSpent FROM AccountTransaction WHERE amount < 0 AND aid = ? AND `date` BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()";
              if ($stmt = $mysqli->prepare($query)) {
                  $stmt->bind_param('i', $aid);
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
        </div>
        <a href="addCSV.php">
        <div class="backlight">
          <h2 class="centered">Add a Statement</h2>
        </div>
        </a>
        <div class="backlight">
          <h2 class="centered">Delete a Statment</h2>
          <?php
          $error = filter_input(INPUT_GET, 'error', $filter = FILTER_SANITIZE_STRING);
          $success = filter_input(INPUT_GET, 'success', $filter = FILTER_SANITIZE_STRING);

          if (!empty($error)) {
              echo '<p class="error-msg">'.$error.'</p>';
          }
          if (!empty($success)) {
              echo '<p class="success-msg">Statement Deleted</p>';
          }
          ?>
          <form method="POST" action="includes/removeStatement.php">
            <select name="statementName" id="select-Name">
              <?php
              $query = "SELECT DISTINCT statementName FROM AccountTransaction WHERE aid = ? ORDER BY date DESC";
              if ($stmt = $mysqli->prepare($query)) {
                  $stmt->bind_param('i', $aid);
                  $stmt->execute();    // Execute the prepared query.

                  $result = $stmt->get_result();
                  // get variables from result.
                  while($row = $result->fetch_assoc())
                  {
                    $statementName = $row['statementName'];
                    echo "<option value=\"$statementName\">$statementName</option>";
                  }
                  $result -> free();
                  $stmt->close();
                }
              ?>
            </select>
            <?php echo "<input type=\"hidden\" name=\"aid\" value=\"$aid\">"; ?>
            <input type="submit" value="Delete" id="send-submit">

          </form>
        </div>


      </section>
      <a href="editaccount.php?aid=<?php echo $aid;?>" id="new-account-button" class="edit-button">Edit Account</a>
			<section id="center-noright">
      <ul>
        <?php
        $query = "SELECT aid, title, balance, financialinstitution, type FROM Account WHERE aid = ?";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param('i', $aid);
            $stmt->execute();    // Execute the prepared query.

            $result = $stmt->get_result();
            // get variables from result.

            if($row = $result->fetch_assoc())
            {
              $aid = $row['aid'];
              $title = $row['title'];
              $balance = $row['balance'];
              $financialinstitution = $row['financialinstitution'];
              $type = $row['type'];
              echo "<li class=\"account-entry\">";
              echo "<p class=\"account-title\">$title</p>";
              echo "<p class=\"account-type\">Balance: \$$balance</p>";
              echo "<p class=\"account-type\">$type with $financialinstitution</p>";
              echo "</li>";
            }
            $result -> free();
            $stmt->close();
          }
        ?>
      </ul>
      <table id="account-table">
        <tr>
          <thead>
            <th>Type</th>
            <th>Amount</th>
            <th>Reason</th>
            <th>Date</th>
            <th>Statement</th>
          </thead>
        </tr>
        <?php
        $query = "SELECT tid, `date`, amount, `desc`, statementName FROM AccountTransaction WHERE aid = ? ORDER BY date DESC";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param('i', $aid);
            $stmt->execute();    // Execute the prepared query.

            $result = $stmt->get_result();
            // get variables from result.

            while($row = $result->fetch_assoc())
            {
              $tid = $row['tid'];
              $date = $row['date'];
              $amount = $row['amount'];
              $desc = $row['desc'];
              $statementName = $row['statementName'];
              if($amount > 0){
                $type = "Deposit";
              }else{
                $type = "Withdrawl";
              }

              $amount = abs($amount);
              $date = date("j F Y",  strtotime($date));
              echo"
              <tr class=\"$type\">
              <td>$type</td>
              <td>"."$ ".number_format($amount, 2)."</td>
              <td>$desc</td>
              <td>$date</td>
              <td>$statementName</td>
              </tr>
              ";
            }
            $result -> free();
            $stmt->close();
          }
        ?>
      </table>
                    <a href="includes/process_deleteaccount.php?aid=<?php echo $aid;?>" id="new-account-button">Delete Account</a>
	    </section>
	</main>
	</body>
<html>
