<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
sec_session_start();
if (login_check($mysqli) == false) {
  // If not logged in then send to login page
  header('Location:index.php');
}
?>
<!DOCTYPE html>
<html>
<head>
<title>SCRUMptious</title>
<meta charset="utf-8">
<link href="css/reset.css" rel="stylesheet" type="text/css" />
<link href="css/styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<header>
   <div id="upper">
   <img src="images/logo.svg" alt="Logo" id="logo" />
   <div class="dropdown">
     <!-- Add php to pull user's name and add it here -->
		<button class="dropbtn">User's Name</button>
		<div class="dropdown-content">
			<p><a href="account.php">Account</a></p>
			<p><a href="includes/logout.php">Logout</a></p>
		</div>
	</div>
   </div>
   <div id="lower">
    <nav>
    <ul>
      <li><a href="#">OVERVIEW</a></li>
      <li><a href="addAccount.html">ADD ACCOUNT</a></li>
      <li><a href="#">PAYMENTS</a></li>
      <li><a href="#">INVESTMENTS</a></li>
      <li><a href="analysis.php">ANALYSIS</a></li>
      <li><a href="calendar.html">CALENDAR</a></li>
    </ul>
    </nav>
   </div>
</header>
<main>
    <section id="rightColumn">
      <!-- The latest finacial news and events from the world or user's particular area shown here -->
      <h2>News and Events</h2>
        <ul>
          <li><a href="#">False alarm, everything is going to be okay.</a></li>
          <li><a href="#">The stock market has crashed, the end of the world is near.</a></li>
          <li><a href="#">A new bank has opened in your area.</a></li>
          <li><a href="#">Disney buys 21st Century Fox for $52.4 billion.</a></li>
        </ul>
    </section>
    <section id="center-noleft">
    <h1>Upload Successful</h1>
    <h2>Upload Another Statement or Return to Analysis Tab</h2>
    <form action="includes/upload.php" method="post" enctype="multipart/form-data" class="upload-form">
      
				<label>Select Account</label>
				<p><select name="Account">
          <?php 
          $sql = $mysqli->prepare("SELECT title FROM Account WHERE uid = ?");
          $user_id = $_SESSION['user_id'];
          
          $sql->bind_param('i', $user_id);
         
          $sql->execute();
          $result = $sql -> get_result();
          if(empty($result)){
            header('Location:addAccount.php');
          }else{
          while($row = $result->fetch_assoc()){
            echo "<option>" . $row['title'] . "</option>";
          }
        }
          ?>
				</select></p>
		
    <p><input type="file" name="csv" value="" />
    <input type="submit" name="submit" value="Save" /></p>
    </form>
    </section>
  <div class="clear"></div>
  </main>
  <footer>
    <p><a href="#">ABOUT US</a> | <a href="#">CONTACT US</a> | <a href="#">PRIVACY POLICY</a> | <a href="#">TERMS OF USE</a> | <a href="#">SUPPORT</a></p>
    <p>&copy; Copyright 2018 Scrumpptious Finance. All rights reserved.</p>
  </footer>
</body>
</html>