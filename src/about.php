<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
include_once 'includes/getMonthlyData.php';
include_once 'includes/fusioncharts.php';
sec_session_start();

?>
<!DOCTYPE html>
<html>
<head>
<title>About Us | Scrumptious Finance</title>
<meta charset="utf-8">
<link href="css/reset.css" rel="stylesheet" type="text/css" />
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" type="image/x-icon" href="img/sf_icon.ico" />
<script src="js/chartload.js"></script>
<script src="js/fusioncharts.js"></script>
<script src="js/fusioncharts.charts.js"></script>
</head>
<body>
<header>
   <div id="upper">
   <a href="overview.php"><img src="img/sf_logo.png" alt="Logo" id="logo" /></a>
   <?php
    if (login_check($mysqli) == false) {
    // If not logged in they are a guest
   ?>
   <div class="dropdown">
     <!-- Add php to pull user's name and add it here -->
		<button class="dropbtn">Guest</button>
		<div class="dropdown-content">
			<p><a href="login.php">Login</a></p>
			<p><a href="register.php">Register</a></p>
		</div>
  </div>
   <?php
    }else{
    $user_id = $_SESSION['user_id'];
   ?>
   <div class="dropdown">
     <!-- Add php to pull user's name and add it here -->
		<button class="dropbtn"><?php echo $_SESSION['username'];?></button>
		<div class="dropdown-content">
			<p><a href="profile.php">Account</a></p>
			<p><a href="includes/logout.php">Logout</a></p>
		</div>
  </div>
    <?php } ?>
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
    <section id="center-noleft" class="backlight">
      <h2>About Us</h2>
        <p class="largerfont">The Scrumptious Finance website was designed to allow users to view all of their monthly bank statements in one place, as well as to transfer money between accounts and easily analyze their financial information. Our website is meant to be a hub for you to view all of your different financial accounts, whether it be your day to day chequing account or your long term investment accounts, in order to make managing your financial life easier.</p>
        <p class="largerfont">It is our goal to make it easier for people to view all of their finances without having to go to multiple different bank websites. We'd like Scrumptious Finance to provide a central location for you to manage your finances.</p>
      </section>
  <div class="clear"></div>
  </main>
  <footer class="absolute">
    <p><a href="about.php">ABOUT US</a> | <a href="contact.php">CONTACT US</a> | <a href="privacypolicy.php">PRIVACY POLICY</a> | <a href="termsofuse.php">TERMS OF USE</a></p>
    <p>&copy; Copyright 2018 Scrumptious Finance. All rights reserved.</p>
  </footer>
</body>
</html>
