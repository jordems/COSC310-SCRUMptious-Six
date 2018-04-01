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
<title>Terms of Use | Scrumptious Finance</title>
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
      <h1>Terms of Use</h1>
        <p class="largerfont">Use of this website is governed by the following terms and conditions. Please read these terms and conditions carefully, as by using this site you will be deemed to have agreed to them. These terms and conditions are subject to change without notice to you, so we recommend that you review them regularly. If you do not agree with these terms and conditions, do not use this site.</p>
        <h2>Limited License and Use</h2>
        <p class="largerfont">No endorsement or approval of any third party or their statements, opinions, information, products, or services is expressed or implied by the contents of this site. To the extent any third party opinions or information are included on this site, they are provided for convenience only and Scrumptious Finance assumes no liability and does not approve or endorse such third party content, or warrant such content to be accurate, complete, reliable, verified, error free, or fit for any purpose.</p>
        <p class="largerfont">Scrumptious Finance may utilize third party service providers to provide certain tools. Access to other sites or use of any third party tools or programs on this site are subject to all terms and conditions found therein.</p>
        <p class="largerfont">The use and content of this site, including the terms and conditions of use, shall be governed by the laws of the Province of British Columbia and the laws of Canada applicable therein and you agree to attorn to the jurisdiction of the courts of the Province of British Columbia.</p>
        <h2>Availability</h2>
        <p class="largerfont">This site, in whole or in part, may periodically be unavailable to you in order to allow for maintenance or updates, or due to other causes, including causes beyond the control of Scrumptious Finance. Further, any or all of the services on this site may change at any time, with or without notice to you.</p>
        <h2>Copyright</h2>
        <p class="largerfont">This site has been developed by and is the property of the Scrumptious Finance team. All information and materials contained on this site are protected by the copyright laws of Canada, and are the property of their respective owner(s).Any infringement of the rights of Scrumptious Finance may result in appropriate legal action.</p>
        <h2>General Disclaimer</h2>
        <p class="largerfont">While the information posted on this site is believed to be reliable and accurate at the time of posting, Scrumptious Finance does not guarantee, represent or warrant that the information contained on this site is accurate, complete, reliable, verified, error-free or fit for any purpose.</p> 
        <p class="largerfont">You assume full responsibility for risk of loss of any nature whatsoever resulting from your use of this site. Without limiting the generality of the foregoing, you acknowledge and agree that none of Scrumptious Finance, its affiliates, or any third party, or any of their respective directors, officers, employees or agents shall be liable to you for loss of data, computer time or any loss or damage of any nature whatsoever arising out of or attributable in any manner whatsoever to your use or inability to use this site for any reason whatsoever or to any action or inaction on the part of Scrumptious Finance or for any direct, indirect, special or consequential damages, even if Scrumptious Finance has been advised of the possibility thereof, including but not limited to lost profits, lost opportunities or business revenues, loss of goodwill, or failure to realize expected savings.</p>
        <p class="largerfont">This site contains links to or may be accessed from other sites which sites are not maintained or controlled in any way by Scrumptious Finance. Scrumptious Finance does not control and is not responsible for any of these sites or their content, and as a result such links are not to be construed as an endorsement by Scrumptious Finance or any other party of the products, services, advice or opinions or any other content of such sites. Access or use of sites to which links are provided and of sites that link to this site are subject to the terms and conditions of such sites. You are fully responsible for any use that you make of the content contained on such sites and you are solely responsible for the consequences of any use of or reliance on such content. Links to such sites that are not maintained or controlled by Scrumptious Finance are provided for convenience only.</p>
        <h2>More Information</h2>
        <p class="largerfont">For more information please contact us using our <a class="link" href="contact.php">Contact Form</a></p>
    </section>
  <div class="clear"></div>
  </main>
  <footer>
    <p><a href="about.php">ABOUT US</a> | <a href="contact.php">CONTACT US</a> | <a href="privacypolicy.php">PRIVACY POLICY</a> | <a href="termsofuse.php">TERMS OF USE</a></p>
    <p>&copy; Copyright 2018 Scrumptious Finance. All rights reserved.</p>
  </footer>
</body>
</html>
