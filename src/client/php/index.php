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
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script type="text/javaScript" src="../js/sha512.js"></script>
  <script type="text/javaScript" src="../js/forms.js"></script>

  <title>FinaApp</title>
</head>
<body>
  <header>
    <!--Add Logo and Mission Statement-->
    <figure>
      <img src="" alt="FinaApp Logo">
      <figcaption>
        <strong>We Care About your Money&trade;</strong>
      </figcaption>
    </figure>
  </header>
  <main>
    <form action="includes/process_login.php" method="post" onsubmit="formhash(this, this.password);" id="login-form">
      <fieldset>
        <legend>Login</legend>
        <label for="login-user">Username:</label>
        <input type="text" name="username" id="login-user">
        <label for="login-pass">Password:</label>
        <input type="password" name="password" id="login-pass">
        <p id="login-forgot"><a href="forgot.html">Forgot Password?</a></p>
        <p id="login-register"><a href="register.php">Don't Have an Account?</a></p>
        <input type="submit" value="Login">
      </fieldset>
    </form>
  </main>
  <footer>
    <!--Add Copyright and Company Name-->
    <ul>
      <li><a href="">About Us</a></li>
      <li><a href="">Contact Us</a></li>
      <li><a href="">Rules</a></li>
      <li><a href="">Development Team</a></li>
    </ul>
    <p>&copy; Copyright 2018 FinaApp</p>
  </footer>
</body>
</html>
