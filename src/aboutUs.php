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
		ABOUT US
	</title>
	<style>
#aboutUs img {
  border-radius: 50%;
  width:50px; 
  padding: 10px;

}
#aboutUs span{
	padding: 10px;
	font-weight: bold;
	
}
#content{
	padding: 20px;
	font-size: 15px;
	background: #f1f1f1;
	color: #555;
	width: 1200px;
	 line-height: 1.6;
}

</style>
	
	
</head>
<script>	
	 var user_id ="<?php echo $_SESSION['user_id']; ?>";
	 //alert(user_id);
	</script>
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
        <li><a href="Investments.php">INVESTMENTS</a></li>
        <li><a href="analysis.php">ANALYSIS</a></li>
        <li><a href="calendar.php">CALENDAR</a></li>
      </ul>
			</nav>
		 </div>
	</header>
	<main>
	<div id ="aboutUs">
		<h1>ABOUT US</h1>
		<br>
		<span><img src="../images/AhmedFayed.jpg" alt="Avatar" > Project manager</span>
		<span><img src="../images/VarunKaushal.jpg" alt="Avatar" > Client & Developer</span>
		<span><img src="../images/JordanEmslie.jpg" alt="Avatar" > Technical lead</span>
		<span><img src="../images/LeviMagnus.jpg" alt="Avatar" >  Technical lead</span>
		<span><img src="../images/JaskaranLidher.jpg" alt="Avatar" > Developer</span>
		<span><img src="../images/DanielKandie.jpg" alt="Avatar" > Developer</span>		
		<span><img src="../images/JinhanLi.jpg" alt="Avatar"> Developer</span>
		
		<br>
		<br><p id= "content">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Our project is to create a financial planning web app. This website will allow our user not only to view their withdrawals and deposits but also view their monthly bank statements, transfer money, and see analytics of their financial situation.
			Our web app is meant to be a hub for a user to view different bank accounts and make managing their financial lives easily. Our goal is to make it easier for people to view their whole of their finances without having to go to multiple different bank websites. 
			The main idea for this website is to provide a central location for the user to manage their finances.
			Our web app will allow users to create a SCRUMptious Finance account to create a personalized experience. Once A user has created their account they will be able to add their different bank accounts to the system. 
			After adding their bank accounts users will then be able to fully utilize the site. From this point the website will gather information from the bank such as their expenses, deposits and spending trends.
			Using information the bank makes available SCRUMptious finance will centralize our users financial information into easy to a format that is easy to understand. The demographic of this website is a very wide range of users.
			The user can range from a young adult looking to start taking proper care of their finances to an elderly person keeping track of their investments. Due to our web app having such a wide demographic there is a very clear business opportunity. 
		</p>
	
	</div>
	</main>
	<footer class="absolute">
		<p><a href="#">ABOUT US</a> | <a href="#">CONTACT US</a> | <a href="#">PRIVACY POLICY</a> | <a href="#">TERMS OF USE</a> | <a href="#">SUPPORT</a></p>
		<p>&copy; Copyright 2018 Scrumptious Finance. All rights reserved.</p>
	</footer>
</body>

</html>