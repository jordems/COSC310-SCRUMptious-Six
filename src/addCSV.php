<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
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
<title>SF - Add CSV</title>
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
		      <li><a href="calendar.php">CALENDAR</a></li>    </ul>
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
    <section id="center-noleft">
    <div class="csvinstruct backlight">
    <?php
              $error = filter_input(INPUT_GET, 'error', $filter = FILTER_SANITIZE_STRING);
              $message = filter_input(INPUT_GET, 'message', $filter = FILTER_SANITIZE_STRING);

              if (!empty($error)) {
                  echo '<h2 class=\"error-msg\" style="text-align:center;color:red">'.$error.'</h2>';
              }
              if(!empty($message)){
                  echo '<h2 class=\"success-msg\" style="text-align:center;color:#3ACC27">'.$message.'</h2>';
              }
              ?>
    <h1>Upload Bank Statements in CSV Format</h1>

    <h2>How to format your CSV file:</h2>
    <p>To create a basic CSV to upload to Scrumptious Finance you need to include three columns: date, amount and description.</p>
    <ul>
        <li>Column A - date: Use the date format YYY-MM-DD Ex: 2018-01-23</li>
        <li>Column B - amount: Formatted as 'Number' to 2 decimal places, transactions for money paid out of the bank account should have minus signs in front of them (-) and transactions for money coming into the bank account should not have minus signs in front of them</li>
        <li>Column C - description: The invoice reference, or a brief description.</li>
    </ul>
    <h2>Checklist</h2>
    <p>In your CSV file make sure:</p>
    <ul>
        <li>You haven’t included a header row</li>
        <li>The date format is YYYY-MM-DD Ex: 2018-01-23</li>
        <li>You've used a single 'amounts' column that contains both money paid out and money paid in</li>
        <li>There are no commas in your amounts columns</li>
        <li>You haven't included any quote marks (")</li>
        <li>Each description is on a single line</li>
        <li>The file format is .csv (not .xls or .xlsx)</li>
        <li>A character delimiter of comma ',' is being used when you export your CSV file.</li>
    </ul>
    <div class="formcontainer">
    <form action="includes/upload.php" method="post" enctype="multipart/form-data" class="upload-form">

    <label>Name Your Statement (Ex: January 2018)</label>
    <input type="text" placeholder="Enter Statement Name" name="statement">
				<label>Select Account</label>
				<p><select name="Account">
          <?php
          $sql = $mysqli->prepare("SELECT title, aid FROM Account WHERE uid = ?");
          $user_id = $_SESSION['user_id'];

          $sql->bind_param('i', $user_id);

          $sql->execute();
          $result = $sql -> get_result();
          if(empty($result)){
            header('Location:addAccount.php');
          }else{
          while($row = $result->fetch_assoc()){
            echo "<option value=\"" . $row['aid'] . "\">" . $row['title'] . "</option>";
          }
        }
          ?>
				</select></p>

    <p><input type="file" name="csv" value="" />
    <input type="submit" name="submit" value="Save" class="savebtn"/></p>
    </form>
      </div>
    </div>
    </section>
  <div class="clear"></div>
  </main>
  <footer>
    <p><a href="#">ABOUT US</a> | <a href="#">CONTACT US</a> | <a href="#">PRIVACY POLICY</a> | <a href="#">TERMS OF USE</a> | <a href="#">SUPPORT</a></p>
    <p>&copy; Copyright 2018 Scrumpptious Finance. All rights reserved.</p>
  </footer>
</body>
</html>
