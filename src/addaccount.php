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
		<title>SF - Add Account</title>
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
			<section id="center-nocolumns">
				<form method="post" action="includes/process_addaccount.php" id="addaccount-form">
					<fieldset>
						<legend>Add an Account</legend>
					<label>Title: </label>
					<input type="text" name="title">
					<label>Financial Institution:</label>
					<select name="financialinstitution">
					<option value="RBC">RBC</option>
					<option value="HSBC">HSBC</option>
					<option value="CIBC">CIBC</option>
					<option value="BMO">BMO</option>
					<option value="Scotiabank">Scotiabank</option>
					<option value="Credit Union">Credit Union</option>
					<option value="TD Bank">TD Bank</option>
					<option value="Tangerine">Tangerine</option>
					<option disabled>More soon...</option>
				</select>
				<label>Account Type:</label>
				<select name="type">
					<option value="Savings Account">Savings Account</option>
					<option value="Chequing Account">Chequing Account</option>
					<option value="RESP Account">RESP Account</option>
					<option value="RRSP Account">RRSP Account</option>
				</select>
				<label>Balance:</label>
				 <input type="number" name="balance" min="0.00" step="0.01" max="999999999.99" placeholder="0.00">
				<button type="submit" value="Submit" id="update-submit">Add Account</button>
			</fieldset>
		</form>
	</section>
	</main>
	</body>
<html>
