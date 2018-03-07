<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

sec_session_start();

if (login_check($mysqli) == false) {
    // If already Logged in then send to login page
    header('Location:index.php');
}
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>SF - Edit Profile</title>
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
      <li><a href="account.php">ACCOUNT</a></li>
      <li><a href="#">TRANSACTION HISTORY</a></li>
      <li><a href="#">SETTINGS</a></li>
    </ul>
    </nav>
   </div>
</header>
<main>
    <?php
    // Selects current data from User and places it into field
    $stmt = $mysqli->prepare("SELECT email, firstName, lastName, billingAddress FROM Users Where uid = ?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();    // Execute the prepared query.
    $stmt->store_result();
    $stmt->bind_result($email, $firstName, $lastName, $address);
    $stmt->fetch();

    ?>
    <section id="center-nocolumns">
      <form action="includes/updateUser.php" method="post" name="update_form" id="update-form">
          <fieldset>
              <?php
                  $error = filter_input(INPUT_GET, 'error', $filter = FILTER_SANITIZE_STRING);

                  if (!empty($error)) {
                      echo '<p class=\"error-msg\" style\"text-align:center\">'.$error.'</p>';
                  }
              ?>
              <legend>Update your Account Information</legend>
              <label for="email">Email:</label> <input type="text" name="email" id="update-email" value="<?php echo $email;?>"/>
              <label for="firstName">First Name:</label> <input type="text" name="firstName" id="update-firstName" value="<?php echo $firstName;?>"/>
              <label for="lastName">Last Name:</label> <input type="text" name="lastName" id="update-lastName" value="<?php echo $lastName;?>"/>
              <label for="address">Address:</label> <input type="text" name="address" id="update-address" value="<?php echo $address;?>"/>
              <input type="submit" value="Update" id="update-submit">
          </fieldset>
      </form>
    </section>
</main>
<footer>
     <p><a href="#">ABOUT US</a> | <a href="#">CONTACT US</a> | <a href="#">PRIVACY POLICY</a> | <a href="#">TERMS OF USE</a> | <a href="#">SUPPORT</a></p>
     <p>&copy; Copyright 2018 Scrumpptious Finance. All rights reserved.</p>
</footer>
</body>
</html>
