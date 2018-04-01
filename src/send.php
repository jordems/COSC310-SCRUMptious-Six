<!DOCTYPE html>
<html>
<head>
<title>SCRUMptious</title>
<meta charset="utf-8">
<link href="../css/reset.css" rel="stylesheet" type="text/css" />
<link href="../css/styles.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" type="image/x-icon" href="img/sf_icon.ico" />
</head>
<body>
<header>
   <div id="upper">
   <a href="overview.php"><img src="img/sf_logo.png" alt="Logo" id="logo" /></a>
   <div class="dropdown">
     <!-- Add php to pull user's name and add it here -->
		<button class="dropbtn">User's Name</button>
		<div class="dropdown-content">
			<p><a href="profile.php">Account</a></p>
			<p><a href="includes/logout.php">Logout</a></p>
		</div>
	</div>
   </div>
   <div id="lower">
    <nav>
    <ul>
      <li><a href="#">OVERVIEW</a></li>
      <li><a href="account.php">ACCOUNTS</a></li>
      <li><a href="addCSV.php">BANK STATEMENTS</a></li>
      <li><a href="#">PAYMENTS</a></li>
      <li><a href="#">INVESTMENTS</a></li>
      <li><a href="#">ANALYSIS</a></li>
		      <li><a href="calendar.php">CALENDAR</a></li>
    </ul>
    </nav>
   </div>
</header>
  <main>
    <section id="leftColumn">
      <!-- The latest updates associated with the particular user's account shown here -->

        <h2>Latest Updates</h2>
        <!-- Going to need Javascript/PHP/Database to have this work in real time with real content  -->
        <p><span class="headline">Feb 11, 2018</span></p>
         <p>The value of your Bitcoin investment increased 5%.</p>
        <p><span class="headline">Jan 21, 2018</span> </p>
        <p>You deposited $300.00 in your savings account.</p>
        <p><span class="headline">Jan 1, 2018</span></p>
         <p>You recieved $1020.00 from John.</p>
        <p><span class="headline">Dec 29, 2017</span> </p>
        <p>Your account with Scrumptious Finance was created!</p>


    </section>
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
    <section id="center">
        <h1>Welcome!</h1>
        <form action="includes/process_transaction.php" method="post" id="send-form">
            <?
            $error = filter_input(INPUT_GET, 'error', $filter = FILTER_SANITIZE_STRING);
            $success = filter_input(INPUT_GET, 'success', $filter = FILTER_SANITIZE_STRING);

            if (!empty($error)) {
                echo '<p class=\"error-msg\">Error transfering Amount.</p>';
            }
            if (!empty($success)) {
                echo '<p class=\"success-msg\">Transfer Successful!</p>';
            }
            ?>
            <label for="login-user" class="input-title">Send to:</label>
            <input type="text" name="receivingUsername" placeholder="Username"id="send-user">
            <label for="login-user" class="input-title">Amount:</label>
            <input type="number" name="amount" min="0.01" step="0.01" max="100000000000000.00" placeholder="0.00" id="send-amount">
            <input type="submit" value="Submit">
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
