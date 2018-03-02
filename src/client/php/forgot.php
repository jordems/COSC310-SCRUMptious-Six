<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

sec_session_start();

if (login_check($mysqli) == true) {
    // If already Logged in then send to home page
    header('Location:index.php');
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
      <form action="includes/process_forgot.php" method="post" id="forgot-form">
        <fieldset>
          <legend>Forgot Password</legend>
          <?
          $error = filter_input(INPUT_GET, 'err', $filter = FILTER_SANITIZE_STRING);

          if (! $error) {
              echo '<p class=\"error-msg\">Username and Password don\'t link to an Account.</p>';
          }
          ?>
          <label for="login-user" class="input-title">Username:</label>
          <input type="text" name="username" id="forgot-user">
          <label for="login-pass" class="input-title">Email:</label>
          <input type="text" name="email" id="forgot-pass">
          <div id="forgot-anchors">
            <p><a href="index.php">Login Page</a></p>
            <p><a href="contactus.php">Contact Us</a></p>
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
