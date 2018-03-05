<?php
include_once 'includes/updateUser.php';
include_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>SCRUMptious</title>
    <meta charset="utf-8">
    <link href="../css/styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<header>
   <div id="upper">
   <img src="images/logo.svg" alt="Logo" id="logo" />
   <div class="dropdown"> 
		<button class="dropbtn">User's Name</button> 
		<div class="dropdown-content">
			<p><a href="account.php">Account</a></p>
			<p><a href="logout.jsp">Logout</a></p>
		</div>
	</div> 
   </div>
   <div id="lower">
    <nav>
    <ul>
      <li><a href="overview.php">OVERVIEW</a></li>
      <li><a href="account.php">ACCOUNT</a></li>
      <li><a href="#">TRANSACTION HISTORY</a></li>
      <li><a href="#">SETTINGS</a></li>
    </ul>
    </nav>
   </div>
</header>
<main>
    <h1>The update was successful!</h1>
    <form action="" method="post" name="update_form" onsubmit="">
        <fieldset>
                <legend>Update your Account Information</legend>
                <label for="username">Username:</label> <input type='text' name='username' id='username' value=/>
                <label for="email">Email:</label> <input type="text" name="email" id="email" />
                <label for="firstName">First Name:</label> <input type="text" name="firstName" id="firstName" />
                <label for="lastName">Last Name:</label> <input type="text" name="lastName" id="lastName" />
                <label for="address">Address:</label> <input type="text" name="address" id="address" />
                <input type="submit" value="Update" id="update-submit">
        </fieldset>
    </form>
</main>
<footer>
     <p><a href="#">ABOUT US</a> | <a href="#">CONTACT US</a> | <a href="#">PRIVACY POLICY</a> | <a href="#">TERMS OF USE</a> | <a href="#">SUPPORT</a></p>
     <p>&copy; Copyright 2018 Scrumpptious Finance. All rights reserved.</p>
</footer>
</body>
</html>
