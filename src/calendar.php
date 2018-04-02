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
	<div id="tab" class="calendar">

		<div id="LeftSide">
			<div id='aa'>aa</div>
			<div id='bb'>bb</div>
			<div id='cc'>cc</div>
		</div>
		<div id='text'>
			<h2>Monthly Report</h2>
			<p></p>
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
			<h2>Positive sign(+) is income, negative(-) is outcome</h2>
			<form id ="addEvent" action="" name="myform" method="POST" onsubmit="post()" >
				<select name="outcome" id="transactionAccountSelection" required>
					<option value="Food & Drinks">Food & Drinks</option>
					<option value="Housing">Housing</option>
					<option value="Vehicle">Vehicle</option>
					<option value="Entertainment">Entertainment</option>
					<option value="Investments">Investments</option>
					<option value="Bill">Bill</option>
					<option value="Education">Education</option>
					<option value="Insurance">Insurance</option>
					<option value="">New Thing&hellip;</option>

				</select>

				<select name="account" id="acc" required>
            <?php

            $query = "SELECT aid, title, balance FROM Account WHERE uid = ?";
            if ($stmt = $mysqli->prepare($query)) {
                $stmt->bind_param('i', $user_id);
                $stmt->execute();    // Execute the prepared query.
                $result = $stmt->get_result();
                // get variables from result.
                while($row = $result->fetch_assoc())
                {
                  echo "<option value=\"".$row['aid']."\">".$row['title']." | \$".$row['balance']."</option>";
				   				$GLOBALS['aid']=$row['aid'];
                }
                $result -> free();
                $stmt->close();
              }
			  mysqli_close($mysqli);
            ?>
          </select>

				<input id="tranInput" type="text" name="money" placeholder="$" required />
				<input id="input_date" type="date" required>
				<input id="statementName" type="text" name="statementName" placeholder="statementName" />
				<input id ="outcomebtn" type="submit" value="Done"/>
				<br>
			</form>

		</div>

		<script>
		/*
			function myfunciton(){

				alert("test myfunction");
			}*/
		</script>

		<!--<div id='income'>
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
		</div>    -->
		<div id='transaction'>
		</div>
		</div>
	<div class="modal-footer">
				<h3></h3>
				<p id="text_addEvent"></p>
			</div>
	</div>
	</div>

		<script>

			var aid = "<?php echo $aid; ?>";;
			//alert(aid);
		</script>
		<script type="text/javascript" src="js/calendar2.js?randomNo=Math.random()"></script>
	</main>
	<footer class="absolute">
		<p><a href="about.php">ABOUT US</a> | <a href="contact.php">CONTACT US</a> | <a href="privacypolicy.php">PRIVACY POLICY</a> | <a href="termsofuse.php">TERMS OF USE</a></p>
    <p>&copy; Copyright 2018 Scrumptious Finance. All rights reserved.</p>
	</footer>
</body>

</html>
