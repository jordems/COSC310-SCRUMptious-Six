<?php
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

  <link rel="stylesheet" href="css/login.css">
  <link rel="shortcut icon" type="image/x-icon" href="img/sf_icon.ico" />
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script type="text/javascript">
      window.jQuery || document.write('<script src=\"../js/jquery-3.1.1.min.js\"><\/script>');
  </script>
  <script type="text/javaScript" src="js/sha512.js"></script>
  <script type="text/javaScript" src="js/forms.js"></script>

  <title>Reset Password | Scrumptious Finance</title>
</head>
<body>
  <div class="limiter">
    <div class="login-container">
      <div class="login-wrap">
          <figure>
            <a href="overview.php"><img src="img/sf_logo.png" alt="Logo" id="logo" /></a>
            <figcaption>
              <strong class="title">Create a New Password</strong>
            </figcaption>
          </figure>

            <form action="includes/update_password.php" method="post" onsubmit="formhash(this, this.password);" class="login-form">

                <?
                $error = filter_input(INPUT_GET, 'error', $filter = FILTER_SANITIZE_STRING);

                if (!empty($error)) {
                    echo '<p class=\"error-msg\">Password Entered is Not Valid.</p>';
                }
                ?>
                <div class="input-wrap">
                <input type="password" name="password" class="input" placeholder="New Password">
                </div>
                <div class="input-wrap">
                <input type="password" name="confpassword" class="input" placeholder="Confirm New Password">
                </div>
                <div class="button-container">
                <input type="submit" value="Submit" class="button">
                </div>
            </form>
        </div>
      </div>
    </div>


</body>
</html>
