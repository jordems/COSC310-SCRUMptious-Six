<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

sec_session_start();
if(isset($_GET['aid']))
  $aid = filter_input(INPUT_GET, 'aid', FILTER_SANITIZE_STRING);
else
  header('Location:login.php'); // Redirect if no account id is given

if (login_check($mysqli) == false) {
    // If already Logged in then send to login page
    header('Location:login.php');
}

$user_id = $_SESSION['user_id'];
if(!userHasAccount($user_id, $aid, $mysqli)){
  // Account doesn't belong to user so redirect them
  header('Location:login.php');
  exit(0);
}
?>
<!DOCTYPE html>
<html>
	<head lang = "en">
		<title>SF - Edit Account</title>
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
			<section id="center-nocolumns">
        <?php
        $query = "SELECT title, balance, financialinstitution, type FROM Account WHERE aid = ? and uid = ?";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param('ii', $aid, $user_id);
            $stmt->execute();    // Execute the prepared query.
            $stmt->store_result();
            $stmt->bind_result($title, $balance, $financialinstitution, $type);
            $stmt->fetch();
            if ($stmt->num_rows == 1) {
            }else{
              echo "<p class=\"error-msg\">Error 503</p>";
              exit(0); // Database isn't loading stop the rest of the page from loading
            }
            $stmt->close();
          }else{
            echo "<p class=\"error-msg\">Error 503</p>";
            exit(0); // Database isn't loading stop the rest of the page from loading
          }
        ?>

				<form method="post" action="includes/process_editaccount.php" id="addaccount-form">
          <?php
            echo "<input type=\"hidden\" name=\"aid\" value=\"$aid\">";
          ?>
					<fieldset>
						<legend>Edit Account</legend>
            <?php
            $error = filter_input(INPUT_GET, 'error', $filter = FILTER_SANITIZE_STRING);
            $success = filter_input(INPUT_GET, 'success', $filter = FILTER_SANITIZE_STRING);

            if (!empty($error)) {
                echo '<p class="error-msg">Error 503</p>';
            }
            if (!empty($success)) {
                echo '<p class="success-msg">Updated Account!</p>';
            }
            ?>
					<label>Title: </label>
					<input type="text" name="title" value="<?php echo $title;?>">
					<label>Financial Institution:</label>
					<select name="financialinstitution">
            <?php
              echo "<option value=\"$financialinstitution\" selected>$financialinstitution</option>";
            ?>
					<option value="RBC">RBC</option>
					<option value="HSBC">HSBC</option>
					<option value="CIBC">CIBC</option>
					<option value="BMO">BMO</option>
					<option value="Scotiabank">Scotiabank</option>
					<option value="Credit Union">Credit Union</option>
					<option value="TD Bank">TD Bank</option>
					<option value="Tangerine">Tangerine</option>
					<option disabled>More soon...</option>
				</select>
				<label>Account Type:</label>
				<select name="type">
          <?php
            echo "<option value=\"$type\" selected>$type</option>";
          ?>
            <option value="Savings Account">Savings Account</option>
            <option value="Chequing Account">Chequing Account</option>
            <option value="RESP Account">RESP Account</option>
            <option value="RRSP Account">RRSP Account</option>
				</select>
				<label>Balance:</label>
				 <input type="number" name="balance" min="0.00" step="0.01" max="999999999.99" placeholder="0.00" value="<?php echo $balance; ?>">
				<button type="submit" value="Submit" id="update-submit">Edit Account</button>
			</fieldset>
		</form>
	</section>
	</main>
	</body>
<html>
