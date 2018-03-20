<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

sec_session_start();

if (login_check($mysqli) == false) {
    // If not already Logged in then send to login page
    header('Location:index.php');
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

<script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
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
      <li><a href="transactions.php">TRANSACTIONS</a></li>
      <li><a href="#">INVESTMENTS</a></li>
      <li><a href="analysis.php">ANALYSIS</a></li>
      <li><a href="calendar.html">CALENDAR</a></li>
    </ul>
    </nav>
   </div>
</header>
  <main>
    <section id="leftColumn">
      <!-- The latest updates associated with the particular user's account shown here -->

        <h2>Recent On-Site Transactions</h2>
        <ul class="transactions">
        <?php
        $query = "SELECT * FROM Transaction WHERE fromid = ? or toid = ? ORDER BY datetime DESC LIMIT 7";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param('ii', $user_id, $user_id);
            $stmt->execute();    // Execute the prepared query.

            $result = $stmt->get_result();
            // get variables from result.

            while($row = $result->fetch_assoc())
            {
              echo "<li class=\"transactions-item\">";
              $tid = $row['tid'];
              $toid = $row['toid'];
              $fromid = $row['fromid'];
              $reason = $row['reason'];
              $datetime = $row['datetime'];
              $amount = $row['amount'];
              if($toid == $user_id){

                $stmt1 = $mysqli->prepare("SELECT username FROM Users WHERE uid = ?");
                $stmt1->bind_param('i', $fromid);
                $stmt1->execute();    // Execute the prepared query.
                $stmt1->store_result();
                $stmt1->bind_result($username);
                $stmt1->fetch();
                echo "<p class=\"transactions-type\">Recieved $".$amount." from ".$username."</p>";
                echo "<p class=\"transactions-time\">".date("g:i a F j, Y ", strtotime($datetime))." | Reason: $reason</p>";
              }else {
                $stmt1 = $mysqli->prepare("SELECT username FROM Users WHERE uid = ?");
                $stmt1->bind_param('i', $toid);
                $stmt1->execute();    // Execute the prepared query.
                $stmt1->store_result();
                $stmt1->bind_result($username);
                $stmt1->fetch();
                echo "<p class=\"transactions-type\">Sent $".$amount." to ".$username."</p>";
                echo "<p class=\"transactions-time\">".date("g:i a F j, Y ", strtotime($datetime))." | Reason: $reason</p>";
              }

              echo "</li>";
            }
            $result -> free();
            $stmt->close();
          }

        ?>
        </ul>

    </section>
    <section id="rightColumn" class="centered">
      <!-- The latest finacial news and events from the world or user's particular area shown here -->
      <h2>Send Money:</h2>
      <form action="includes/process_transaction.php" method="post" id="send-form">
          <?php
          $error = filter_input(INPUT_GET, 'error', $filter = FILTER_SANITIZE_STRING);
          $success = filter_input(INPUT_GET, 'success', $filter = FILTER_SANITIZE_STRING);

          if (!empty($error)) {
              echo '<p class="error-msg">'.$error.'</p>';
          }
          if (!empty($success)) {
              echo '<p class="success-msg">Transaction Successful!</p>';
          }
          ?>
          <label for="login-user" class="input-title">Send to:</label>
          <span class="fas fa-user user"></span>
          <input type="text" name="receivingUsername" placeholder="Username"id="send-user" style="width:70%" required>
          <label for="login-user" class="input-title">Amount:</label>
          <span class="fas fa-dollar-sign imgsized"></span>
          <input type="number" name="amount" min="0.01" step="0.01" max="100000000000000.00" placeholder="0.00" id="send-amount" style="width:70%" required>
          <label for="login-user" class="input-title">Reason:</label>
          <span class="fas fa-angle-right imgsized"></span>
          <input list="reason" name="reason" style="width:70%" required>
          <datalist id="reason">
            <?php
            $query = "SELECT DISTINCT reason FROM Transaction WHERE !(reason = 'Bills' or reason = 'Goods/Entertainment' or reason = 'Gift') and (fromid = ? or toid = ?) ORDER BY datetime";
            if ($stmt = $mysqli->prepare($query)) {
                $stmt->bind_param('ii', $user_id, $user_id);
                $stmt->execute();    // Execute the prepared query.

                $result = $stmt->get_result();
                // get variables from result.

                while($row = $result->fetch_assoc())
                {
                  echo "<option value=\"".$row['reason']."\">";
                }
                $result -> free();
                $stmt->close();
              }
            ?>
            <option value="Bills">
            <option value="Goods/Entertainment">
            <option value="Gift">
          </datalist>
          <input type="submit" value="Submit" id="send-submit">
      </form>
    </section>
    <section id="center">
        <h2>Recent Account Transactions</h2>
        <ul class="transactions">
        <?php
        $query = "SELECT tid, A.financialinstitution as financialinstitution, AT.aid as aid, AT.date as date, AT.amount as amount, AT.`desc` as `desc`, A.title as title, A.type as type FROM AccountTransaction as AT, Account as A WHERE AT.aid = A.aid AND AT.uid = ? ORDER BY date DESC LIMIT 4";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param('i', $user_id);
            $stmt->execute();    // Execute the prepared query.

            $result = $stmt->get_result();
            // get variables from result.

            while($row = $result->fetch_assoc())
            {
              echo "<li class=\"transactions-item\">";
              $tid = $row['tid'];
              $financialinstitution = $row['financialinstitution'];
              $aid = $row['aid'];
              $date = $row['date'];
              $amount = $row['amount'];
              $desc = $row['desc'];
              $title = $row['title'];
              $type = $row['type'];

              $date = strtotime($date);

              if($amount >= 0){
                echo "<p class=\"transactions-title\">".$title." of ".$financialinstitution."</p>";
                echo "<p class=\"transactions-type\">Deposit of $".$amount." on ".date("j F Y", $date)." to ".$type."</p>";
                echo "<p class=\"transactions-desc\">Description: ".$desc."</p>";
              }else {
                echo "<p class=\"transactions-title\">".$title." of ".$financialinstitution."</p>";
                echo "<p class=\"transactions-type\">Withdrawl of $".abs($amount)." on ".date("j F Y", $date)." from ".$type."</p>";
                echo "<p class=\"transactions-desc\">Description: ".$desc."</p>";
              }

              echo "</li>";
            }
            $result -> free();
            $stmt->close();
          }

        ?>
        </ul>
    </section>
  <div class="clear"></div>
  </main>
  <footer>
    <p><a href="#">ABOUT US</a> | <a href="#">CONTACT US</a> | <a href="#">PRIVACY POLICY</a> | <a href="#">TERMS OF USE</a> | <a href="#">SUPPORT</a></p>
    <p>&copy; Copyright 2018 Scrumpptious Finance. All rights reserved.</p>
  </footer>
</body>
</html>
