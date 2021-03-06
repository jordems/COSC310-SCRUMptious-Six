<?php
/* Document is displayed when the client is on the login page
* - Displays the inputs for the process_login Form: process_login.php
*/
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
sec_session_start();
if (login_check($mysqli) == true) {
    // If already Logged in then send to home page
    header('Location:overview.php');
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/login.css">
  <link rel="shortcut icon" type="image/x-icon" href="img/sf_icon.ico" />
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script type="text/javascript">
      window.jQuery || document.write('<script src=\"../js/jquery-3.1.1.min.js\"><\/script>');
  </script>
  <script type="text/javaScript" src="js/sha512.js"></script>
  <script type="text/javaScript" src="js/forms.js"></script>
  <script type="text/javaScript" src="js/login.js"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>

  <title>SF | Login</title>
</head>
<body>
  <div class="limiter">
    <div class="login-container">
      <div class="login-wrap">
          <figure>
            <img src="img/sf_logo.png" alt="FinaApp Logo" id="logo">
          <figcaption>
              <strong class="title">LOG IN</strong>
          </figcaption>
          </figure>
            <form action="includes/process_login.php" method="post" onsubmit="formhash(this, this.password);" class="login-form">
              <?php
              $error = filter_input(INPUT_GET, 'error', $filter = FILTER_SANITIZE_STRING);
              $messege = filter_input(INPUT_GET, 'messege', $filter = FILTER_SANITIZE_STRING);

              if (!empty($error)) {
                  echo '<h2 class=\"error-msg\" style="text-align:center;color:red">'.$error.'</h2>';
              }
              if(!empty($messege)){
                  echo '<h2 class=\"success-msg\" style="text-align:center;color:#3ACC27">'.$messege.'</h2>';
              }
              ?>
                <div class="input-wrap">
                  <span class="fas fa-user user"></span>
                  <input type="text" name="username" class="input" placeholder="Username">
                </div>
                <div class="input-wrap">
                  <span class="fas fa-lock lock"></span>
                  <input type="password" name="password" class="input" placeholder="Password">
                </div>
                <div class="checkbox">
                  <input class="input-checkbox" id="ckb1" type="checkbox" name="remember-me">
                  <label class="label-checkbox" for="ckb1">
                    Remember me
                  </label>
                </div>
                <div class="button-container">
                <input type="submit" value="Login" class="button">
                </div>
                <div id="login-anchors">
                  <p><a href="forgot.php" class="text">Forgot Password?</a></p>
                  <p><a href="register.php" class="text">Don't Have an Account?</a></p>
                </div>
            </form>
    </div>
  </div>
</div>
</body>
</html>
