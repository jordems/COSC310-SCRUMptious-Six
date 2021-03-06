<?php

include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
include_once 'js/Rss_script.php';
sec_session_start();
if (login_check($mysqli) == false) {
    // If not Logged in then send to login page
   header('Location:index.php');
}
$user_id = $_SESSION['user_id'];
?>

<html>
<head>

<title>SF - Investments</title>
<meta charset="utf-8">
<link href="css/reset.css" rel="stylesheet" type="text/css" />
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" type="image/x-icon" href="img/sf_icon.ico" />
</head>
<body>
<header>
   <div id="upper">
    <img src="img/sf_logo.png" alt="Logo" id="logo" />
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
    <section id="leftColumn" class="backlight centered">
      <!-- The latest updates associated with the particular user's account shown here -->

        <h2>Latest Updates</h2>
        <!-- Going to need Javascript/PHP/Database to have this work in real time with real content  -->
        <!-- start sw-rss-feed code -->
        <script src="js/Rss_script.js" type="text/javascript">  </script>
        <script type="text/javascript" src="//feed.surfing-waves.com/js/rss-feed.js"></script>
        <!-- The link below is Reference to where the code for this RSS feed was obtained -->
        <div style="text-align:right; width:230px;">powered by <a href="http://www.surfing-waves.com" rel="noopener" target="_blank" style="color:#000;font-size:10px">Surfing Waves</a></div>
        <!-- end sw-rss-feed code -->

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
    <section id="center" class="backlight">
        <h1>Top 5 articles for today!</h1>
        <!-- <ul class="btn_more">
          <li><a href="#">More info</a></li>
        </ul> -->
        <div>
          <h2><a href="http://www.moneysense.ca/invest/where-to-invest-1000-now/">How to Invest 1,000</a></h2>
          <p> So you’ve suddenly got $1,000 burning a hole in your wallet but you aren’t sure what to do with it—all
            you know is you want that money to grow.
            Chances are you recently finished school and, armed with a degree, you’re now working diligently at establishing a career.
            For the first time, you’ve got a steady stream of income coming in and you’d like to start investing,
            hopefully for the biggest possible return. </P>
        </div>

        <div>
          <h2><a href="https://www.investopedia.com/advisor-network/articles/best-way-budget-automation/">The Best Way to Budget: Automate Your Finances</a></h2>
          <p> A budget is similar to a diet. What a diet is to physical health, a budget is to financial health.
            Both are developed to improve yourself, but neither are typically sustainable.
            More often than not, they're temporary lifestyle changes, not permanent behavioral changes.
            To help your healthy financial habits stick, budget through automation.
          </P>
        </div>

        <div>
          <h2><a href="http://business.financialpost.com/personal-finance/tax-season-is-here-and-the-do-it-yourself-options-are-multiplying">Tax season is here, and the do-it-yourself options are multiplying</a></h2>
          <p> While historically the majority of Canadians don’t actually prepare their own return themselves,
            a recent survey conducted by TurboTax Canada showed that Canadians are increasingly looking to take the lead
            when it comes to preparing their tax return this year.
            The survey found more people want to do their own taxes this year than did in 2017,
            with 54 per cent planning to file themselves compared to 41 per cent who said they did so last year.
            Read on to learn how you can quickly and easily file your own taxes
          </P>
        </div>

        <div>
          <h2><a href="https://caitflanders.com/2015/01/21/why-i-budget-monthly-semi-monthly-and-weekly/">Why I Budget Monthly, Semi-Monthly and Weekly</a></h2>
          <p> Do you budget monthly or per paycheque? If you have money leftover in your account before your next payday,
            what do you do with it? Do you keep a buffer in your chequing account? And how do you really track your spending?
            When I first started reading these questions, I thought, “haven’t I already answered these!?”.
            But in looking at my budget template and posts on how to write a budget, it doesn’t look like I have – at least not in one post!
             So, for those of you who asked, I haven’t been ignoring your questions; I just decided to answer them here, for all first-time budgeters
             (and financial voyeurs) to read.
          </P>
        </div>

        <div>
          <h2><a href="http://canadiancouchpotato.com/2018/03/17/podcast-15-the-value-of-simple/">Canadian Couch Potato: Podcast 15: The Value of Simple</a></h2>
          <p>
            The latest episode of the Canadian Couch Potato podcast focuses on the relationship between cost and complexity in your investment plan.
            ou can often lower fees in your portfolio with a few simple changes that require no additional skill or effort.
            But there are times when accepting slightly higher costs in exchange for simplicity and convenience is actually a wiser choice.
            There’s no single solution: every investor needs to find their sweet spot along that continuum.
            My guest on this episode is John Robertson, author of The Value of Simple, which has just been published in a revised second edition.
            John’s book does an excellent job of stressing these ideas. In the book—and in our interview—he discusses the various options available for
            investors looking to get started with indexing.
          </P>
        </div>

    </section>
  <div class="clear"></div>
  </main>
  <footer>
    <p><a href="about.php">ABOUT US</a> | <a href="contact.php">CONTACT US</a> | <a href="privacypolicy.php">PRIVACY POLICY</a> | <a href="termsofuse.php">TERMS OF USE</a></p>
    <p>&copy; Copyright 2018 Scrumptious Finance. All rights reserved.</p>
  </footer>
</body>
</html>
