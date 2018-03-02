<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

sec_session_start();

if (login_check($mysqli) == true) {
    // If already Logged in then send to home page
    header('Location:home.php');
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
  <meta charset="utf-8">

  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/login.css">
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script type="text/javaScript" src="js/sha512.js"></script>
  <script type="text/javaScript" src="js/forms.js"></script>

  <title>SF</title>
</head>
<body>
  <header>
    <figure>
      <img src="" alt="FinaApp Logo" id="logo">
      <figcaption>
        <strong id="company-statement">We Care About your Money&trade;</strong>
      </figcaption>
    </figure>
  </header>
  <main>
    <div id="login-content">
      <form action="includes/update_password.php" method="post" onsubmit="formhash(this, this.password);" id="forgot-form">
        <fieldset>
          <legend>Select a new Password</legend>
          <?
          $error = filter_input(INPUT_GET, 'err', $filter = FILTER_SANITIZE_STRING);

          if (! $error) {
              echo '<p class=\"error-msg\">Password Entered is Not Valid.</p>';
          }
          ?>
          <label for="login-user" class="input-title">New Password:</label>
          <input type="password" name="password" id="forgot-user">
          <label for="login-user" class="input-title">Confirm Password:</label>
          <input type="password" name="confpassword" id="forgot-user">
          <input type="submit" value="Submit">
        </fieldset>
      </form>
    </div>
  </main>
  <footer>
    <nav>
      <ul id="bottom-dir">
        <li><a href="">About Us</a></li>
        <li><a href="">Contact Us</a></li>
        <li><a href="">Rules</a></li>
        <li><a href="">Development Team</a></li>
      </ul>
    </nav>
    <p>&copy; Copyright 2018 FinaApp</p>
  </footer>
</body>
</html>
