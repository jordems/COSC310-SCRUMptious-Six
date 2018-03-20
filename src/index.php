<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
sec_session_start();
/*if (login_check($mysqli) == false) {
    // If not Logged in then send to login page
    header('Location:index.php');
}*/
//$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html>
<head>
<title>SCRUMptious</title>
<meta charset="utf-8">
<link href="css/reset.css" rel="stylesheet" type="text/css" />
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" type="image/x-icon" href="img/sf_icon.ico" />
<link href="css/slider.css" rel="stylesheet" type="text/css" media="screen">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
<script type="text/javascript" src="js/slider.js"></script>
<script type="text/javascript">
		$(document).ready(function() {
		$('#slider').slider({
			timeOut: 4000
		});
	});
</script>
</head>
<body>
<header>
   <div id="upper">
   <img src="img/sf_logo.png" alt="Logo" id="logo" />
   <div class="dropdown">
     <!-- Add php to pull user's name and add it here -->
		<button class="dropbtn">Guest</button>
		<div class="dropdown-content">
			<p><a href="login.php">Log in</a></p>
			<p><a href="register.php">Register</a></p>
		</div>
	</div>
   </div>
   <div id="lower">
    <nav>
    <ul>
      <li><a href="login.php">OVERVIEW</a></li>
	  <li><a href="login.php">ADD ACCOUNT</a></li>
      <li><a href="login.php">TRANSACTIONS</a></li>
      <li><a href="login.php">INVESTMENTS</a></li>
      <li><a href="login.php">ANALYSIS</a></li>
      <li><a href="login.php">CALENDAR</a></li>
    </ul>
    </nav>
   </div>
</header>
  <main>
  
    <section id="leftColumn" class="backlight">
      <!-- The latest finacial news and events from the world or user's particular area shown here -->
      <h2>News and Events</h2>
        <ul>
          <li><a href="#">False alarm, everything is going to be okay.</a></li>
          <li><a href="#">The stock market has crashed, the end of the world is near.</a></li>
          <li><a href="#">A new bank has opened in your area.</a></li>
          <li><a href="#">Disney buys 21st Century Fox for $52.4 billion.</a></li>
        </ul>

    </section>
    <section id="rightColumn" class="backlight">

        <h2>Featured Services</h2>

        <span class="far fa-calendar-alt icon1"></span><p><strong>Stay organized by keeping track of your information with our intuitive built-in calendar application.</strong></p>
        <span class="fas fa-chart-line icon2"></span><p><strong>Upload your financial data to take advantage of our various analytical tools.</strong></p>
        <span class="fas fa-newspaper icon3"></span><p><strong>Keep up to date with the latest global and local finacial news and events relevant to you.</strong></p>
        <span class="fas fa-mobile-alt icon4"></span><p><strong>Our site is mobile friendly, so you can use our services everywhere you go!</strong></p>
        
    </section>
    <section id="center" class="backlight">
        <h1>Welcome!</h1>
        <div id="slider">
    <ul id="sliderContent">
        <li class="sliderImage">
            <img class="banner" src="img/banner1.png">
            
        </li>
        <li class="sliderImage">
            <img class="banner" src="img/banner3.png">
            <span></span>
        </li>
        <li class="sliderImage">
            <img class="banner" src="img/banner2.png">
            <span></span>
        </li>
        <li class="sliderImage">
            <img class="banner" src="img/banner1.png">
            <span></span>
        </li>
        <li class="sliderImage">
            <img class="banner" src="img/banner3.png">
            <span></span>
        </li>
        <li class="sliderImage">
            <img class="banner" src="img/banner2.png">
            <span></span>
        </li>
        <div class="clear sliderImage"></div>
    </ul>
   </div>
    </section>
  <div class="clear"></div>
  </main>
  <footer>
    <p><a href="#">ABOUT US</a> | <a href="#">CONTACT US</a> | <a href="#">PRIVACY POLICY</a> | <a href="#">TERMS OF USE</a> | <a href="#">SUPPORT</a></p>
    <p>&copy; Copyright 2018 Scrumptious Finance. All rights reserved.</p>
  </footer>
</body>
</html>
