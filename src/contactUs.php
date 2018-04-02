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
	contact us 
	</title>
	<style>
	main {margin: 0 auto;}
body {font-family: Arial, Helvetica, sans-serif;}

input[type=text],input[type=email], select, textarea {
    width: 30%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-top: 6px;
    margin-bottom: 16px;
    resize: vertical;
}

input[type=submit] {
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type=submit]:hover {
    background-color: #45a049;
}

.container {
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;
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
	<center>
		<h1>Contact US Form</h1>
<!-- The Form is from  www.w3schools.com-->
<div class="container">
  <form method="POST" action="sendEmail.php">
    <label for="fname">User name</label>
    <input type="text" id="username" name="username" placeholder="Your name.." required>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" placeholder="Your email.." required>

  

    <label for="subject">Subject</label>
    <textarea id="subject" name="subject" placeholder="Write something.." style="height:200px" required></textarea>
	<br>
    <input type="submit" value="Submit">
  </form>
</div>
	
	
	</center>
	</main>
	<footer class="absolute">
		<p><a href="#">ABOUT US</a> | <a href="#">CONTACT US</a> | <a href="#">PRIVACY POLICY</a> | <a href="#">TERMS OF USE</a> | <a href="#">SUPPORT</a></p>
		<p>&copy; Copyright 2018 Scrumptious Finance. All rights reserved.</p>
	</footer>
</body>

</html>