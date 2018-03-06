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
  <meta charset="UTF-8">

  <link rel="stylesheet" href="css/login.css">
  <link rel="shortcut icon" type="image/x-icon" href="img/sf_icon.ico" />
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script type="text/javaScript" src="js/sha512.js"></script>
  <script type="text/javaScript" src="js/forms.js"></script>

  <title>SF | Recover Password</title>
</head>
<body>
<div class="limiter">
    <div class="login-container">
      <div class="login-wrap">
          <figure>
            <img src="img/sf_logo.png" alt="FinaApp Logo" id="logo">
            <figcaption>
              <strong class="title">Verification Code Sent</strong>
            </figcaption>
          </figure>

            <form action="includes/verify_code.php" method="post" class="login-form">

                <?php
                $error = filter_input(INPUT_GET, 'error', $filter = FILTER_SANITIZE_STRING);

                if (!empty($error)) {
                    echo '<p class=\"error-msg\">Verification Code Entered is Incorrect.</p>';
                }
                ?>
                <div class="input-wrap">
                <input type="text" name="code" id="forgot-user" placeholder="Enter Verification Code" class="input" >
                </div>
                <div class="button-container">
                <input type="submit" value="Submit" class="button">
                </div>
                <div id="forgot-anchors">
                  <p><a href="forgot.php" class="text">Didn't work? Try Again.</a></p>
           </div>
        </div>
      </div>
    </div>

      </form>


</body>
</html>
