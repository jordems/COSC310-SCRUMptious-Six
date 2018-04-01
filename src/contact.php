<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

sec_session_start();

?>
<!DOCTYPE html>
<html>
<head>
<title>Contact Us | Scrumptious Finance</title>
<meta charset="utf-8">
<link href="css/reset.css" rel="stylesheet" type="text/css" />
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" type="image/x-icon" href="img/sf_icon.ico" />

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
          <li><a href="https://www.forbes.com/sites/lizfrazierpeck/2018/03/31/what-is-a-financial-plan-and-why-every-adult-needs-one/#38e9ac0558be">What Is A Financial Plan, And Why Every Adult Needs One</a></li>
          <li><a href="https://www.theglobeandmail.com/report-on-business/rob-commentary/canada-us-must-prepare-for-the-next-economic-or-financial-crisis/article38283300/">Canada, U.S. must prepare for the next economic or financial crisis</a></li>
          <li><a href="http://business.financialpost.com/pmn/business-pmn/british-columbias-economy-is-forecast-to-remain-strong-through-2020">British Columbia's economy is forecast to remain strong through 2020</a></li>
          <li><a href="https://www.forbes.com/sites/bobcarlson/2018/03/29/10-ways-to-simplify-your-financial-life/#4cafb132fef2">10 Ways To Simplify Your Financial Life</a></li>
        </ul>
    </section>
    <section id="center-noleft" class="backlight">
      <h2>Contact Us</h2>
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
      <form action="includes/send_mail.php" method="post" class="contactform">
			<ul>
				<li>
					<label for="name">Name</label>
					<input type="text" name="name" maxlength="30"/>
				</li>
				<li>
					<label for="email">Email</label>
					<input type="email" name="email" maxlength="30"/>
				</li>
				<li>
					<label for="message">Message</label>
					<textarea name="message" maxlength="1000"></textarea> 
				</li>
				<li class="button send">
                <input type="submit" name="submit" value="Send Message" class="savebtn"/>
				</li>
			</ul>
	 </form>	
      </section>
  <div class="clear"></div>
  </main>
  <footer>
    <p><a href="about.php">ABOUT US</a> | <a href="contact.php">CONTACT US</a> | <a href="privacypolicy.php">PRIVACY POLICY</a> | <a href="termsofuse.php">TERMS OF USE</a></p>
    <p>&copy; Copyright 2018 Scrumptious Finance. All rights reserved.</p>
  </footer>
</body>
</html>
