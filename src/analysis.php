<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
sec_session_start();
if (login_check($mysqli) == false) {
  // If not logged in then send to login page
  header('Location:index.php');
}
$sql = $mysqli->prepare("SELECT `desc` FROM AccountTransaction WHERE uid = ?");
  $user_id = $_SESSION['user_id'];
  $sql->bind_param('i', $user_id);
  $sql->execute();
  $result = $sql -> get_result();
  if(empty($result)){
    header('Location:addCSV.php');
  }
  ?>
  <!DOCTYPE html>
  <html>
  <head>
  <title>SF - Analysis</title>
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
  		<button class="dropbtn"><?php echo $_SESSION['username']." | $".getBalance($user_id, $mysqli);?></button>
  		<div class="dropdown-content">
  			<p><a href="account.php">Account</a></p>
  			<p><a href="includes/logout.php">Logout</a></p>
  		</div>
  	</div>
     </div>
     <div id="lower">
      <nav>
      <ul>
        <li><a href="overview.php">OVERVIEW</a></li>
  		  <li><a href="addaccount.php">ADD ACCOUNT</a></li>
        <li><a href="transactions.php">TRANSACTIONS</a></li>
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
    <h1>Analyze your Bank Statements - Coming soon!</h1>
    <?php
    /*$sql2 = $mysqli->prepare("SELECT A.title AS title, AT.statementName AS statementName, AT.date AS date, AT.amount AS amount, AT.`desc` AS `desc` FROM AccountTransaction AS AT, Account AS A WHERE A.aid = AT.aid AND A.uid = ?");

    $sql2->bind_param('i', $user_id);
    $sql2->execute();
    $result2 = $sql2 -> get_result();
    while($row2 = $result2->fetch_assoc()){
      echo "<p><h2>" . $row2['title'] . "</h2>";
      echo "Statement Name: " . $row2['statementName'] ;
      echo "   Date: " . $row2['date'] ;
      echo "   Deposit:" . $row2['amount'] ;
      echo "   Description:" . $row2['desc'] . "</p>";
    }*/

    ?>


    <h2>Add another bank statement</h2>
    <form action="includes/upload.php" method="post" enctype="multipart/form-data" class="upload-form">
        <input type="text" placeholder="Enter Statement Name" name="statement">
				<label>Select Account</label>
				<p><select name="Account">
          <?php
          $sql3 = $mysqli->prepare("SELECT aid, title FROM Account WHERE uid = ?");
          $user_id = $_SESSION['user_id'];

          $sql3->bind_param('i', $user_id);

          $sql3->execute();
          $result3 = $sql3 -> get_result();
          if(empty($result3)){
            header('Location:addAccount.php');
          }else{
          while($row3 = $result3->fetch_assoc()){
            echo "<option value=\"".$row3['aid']."\">" . $row3['title'] . "</option>";
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