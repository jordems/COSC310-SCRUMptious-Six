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
<head lang = "en">
	<title>SF - Accounts</title>
	<link href="css/reset.css" rel="stylesheet" type="text/css" />
	<link href="css/styles.css" rel="stylesheet" type="text/css" />
	<link rel="shortcut icon" type="image/x-icon" href="img/sf_icon.ico" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/calendar.css">
	<link rel="shortcut icon" type="image/x-icon" href="img/sf_icon.ico" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<title>
	</title>
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
	<div id="tab" class="calendar centered">

		<div id="LeftSide">
			<div id='aa'>aa</div>
			<div id='bb'>bb</div>
			<div id='cc'>cc</div>
		</div>
		<div id='text'>
			<h2>DATE 1</h2>
			<p>Hello world!</p>
		</div>
	</div>
	<p onload="showText()"></p>

	<div id="simpleModal" class="modal">
		<div class="modal-content">
		<div class="modal-header">
				<span class="closeBtn">&times;</span>
				<h2>Categories settings</h2>
		</div>
		<div class="modal-body">


		<div id='outcome'>
			<h2>Outcome</h2>
			<form name="myform" method="GET">
				<select name="outcome">
					<option></option>
					<option>Food & Drinks</option>
					<option>Housing</option>
					<option>Vehicle</option>
					<option>Entertainment</option>
					<option>investments</option>
					<option value="">New Thing&hellip;</option>

				</select>
				<input id="text1" type="text" name="money" placeholder="$" required />
				<input type="button" value="Done" Onclick="add_element(this)" required />
				<br>
			</form>
		</div>
		<div id='income'>
			<h2>income</h2>
			<form name="myform" method="GET">
				<select name="income">
					<option></option>
					<option>salary</option>
					<option>Owning a small business</option>
					<option>Consulting</option>
					<option>Gambling</option>
					<option>investments</option>
					<option value="">ADD&hellip;</option>

				</select>
				<input id="text1" type="text" name="money" placeholder="$" />
				<input type="button" value="Done" Onclick="add_element(this)" />
				<br>
			</form>
		</div>
		<div id='transaction'>
		</div>
		</div>
	<div class="modal-footer">
				<h3></h3>
			</div>
	</div>
	</div>

		<script type="text/javascript" src="js/calendar.js"></script>
	</main>
	<footer class="absolute">
		<p><a href="#">ABOUT US</a> | <a href="#">CONTACT US</a> | <a href="#">PRIVACY POLICY</a> | <a href="#">TERMS OF USE</a> | <a href="#">SUPPORT</a></p>
		<p>&copy; Copyright 2018 Scrumptious Finance. All rights reserved.</p>
	</footer>
</body>

</html>
