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
<title>Privacy Policy | Scrumptious Finance</title>
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
      <h1>Privacy Policy</h1>
        <p class="largerfont">This Privacy Policy covers the treatment of personally identifiable information collected by Scrumptious Finance during your visits to our website. This Privacy Policy is subject to change without notice to you, so we recommend that you review it regularly. By using this site you acknowledge that you have read and understand this Privacy Policy as amended from time to time.</p>
        <h2>Privacy and Confidentiality</h2>
        <p class="largerfont">Scrumptious Finance is committed to respecting the privacy and confidentiality of information it receives, in accordance with our <a class="link" href="termsofuse.php">Terms of Use</a>, and applicable law. Scrumptious Finance has established and will continue to maintain reasonable safeguards to protect the security and confidentiality of personal information. However, you acknowledge and confirm that the Internet is not a secure medium where privacy and confidentiality can be guaranteed and that complete security and confidentiality of transmissions to and from this site over the Internet is not possible at this time. Your confidential use of this site cannot be guaranteed and you acknowledge that your use of this site (including information you transmit to the site) may be subject to access or manipulation by, or disclosure to, third parties. Without limiting any other disclaimer herein, Scrumptious and its affiliates shall not be responsible or liable for any damages that you or any other person may suffer in connection with any such breach of privacy, confidentiality or security.</p>
        <h2>Your Personal Information</h2>
        <p class="largerfont">Our website may require you to provide personal information, such as when you are required to register in order to access the site. Such personal information (for example, your name, address, and email) is used to help provide you with a secure, private and convenient experience on the site.</p>
        <p class="largerfont">For registration:</p>
        <ul class="list">
            <li><strong>Identity verification:</strong> This information is used to confirm your identity when registering for access to our website. This information is matched against our existing records to enable you to register.</li>
            <li><strong>Contacting us:</strong> If you send Scrumptious Finance an email through our <a href="contact.php">Contact Us</a> form, the email address you provide at registration will be used to contact you with our reply.</li>
            <li><strong>Forgotton password:</strong> If you forget your password, it is simple to recover it by going through our <a href="forgot.php">Forgotten Password</a> process, available from the <a href="login.php">Login page.</a> To confirm your identity before displaying either of these items, we match what you enter against the information collected during the registration process.</li>
        </ul>
       <p class="largerfont">Remember that the security of email communication cannot be guaranteed. Do not send private or confidential information to Scrumptious Finance via email (e.g., your Social Insurance Number, birthday). Also, Scrumptious Finance will never send you an email message requesting personal information. Any such request is a fraudulent attempt to gain your valuable personal information (a technique known as "phishing").</p> 
       <p class="largerfont">You will not receive any marketing or advertisements from Scrumptious Finance at the email address you provide nor will we ever sell your information to any third parties, or share it with any other organization for marketing purposes.</p>
       <h2>Cookies</h2>
       <p class="largerfont">"Cookies" are small items of data that websites store in your browser. These data files contain information the site can use to track and organize the pages you have visited, and to gather information. Scrumptious Finance uses "session" cookies which help us deliver a superior website experience that is designed to be fast, secure and personalized. Such cookies do not contain your financial information. You may decline cookies by configuring your web browser accordingly, but this may lead to reduced site functionality.</p>
    </section>
  <div class="clear"></div>
  </main>
  <footer>
    <p><a href="about.php">ABOUT US</a> | <a href="contact.php">CONTACT US</a> | <a href="privacypolicy.php">PRIVACY POLICY</a> | <a href="termsofuse.php">TERMS OF USE</a></p>
    <p>&copy; Copyright 2018 Scrumptious Finance. All rights reserved.</p>
  </footer>
</body>
</html>
