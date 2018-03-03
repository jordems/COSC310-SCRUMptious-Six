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
      <form action="includes/verify_code.php" method="post" id="forgot-form">
        <fieldset>
          <legend>We Sent a Verification Code to your Email</legend>
          <?
          $error = filter_input(INPUT_GET, 'error', $filter = FILTER_SANITIZE_STRING);

          if (!empty($error)) {
              echo '<p class=\"error-msg\">Verification Code Entered is Incorrect.</p>';
          }
          ?>
          <label for="login-user" class="input-title">Verification Code:</label>
          <input type="text" name="code" id="forgot-user">
          <div id="forgot-anchors">
            <p><a href="forgot.php">Didn't work? Try Again.</a></p>
          </div>
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
