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
  <meta charset="UTF-8">

  <link rel="stylesheet" href="css/login.css">
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script type="text/javaScript" src="js/sha512.js"></script>
  <script type="text/javaScript" src="js/forms.js"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>

  <title>Forgot Password | Scrumptious Finance</title>
</head>
<body>
<div class="limiter">
    <div class="login-container">
      <div class="login-wrap">
          <figure>
            <img src="img/sf_logo.png" alt="FinaApp Logo" id="logo">
            <figcaption>
              <strong class="title">Retrieve Password</strong>
            </figcaption>
          </figure>
      
            <form action="includes/process_forgot.php" method="post" class="login-form">
             
                <?php
                $error = filter_input(INPUT_GET, 'error', $filter = FILTER_SANITIZE_STRING);

                if (!empty($error)) {
                    echo '<p class=\"error-msg\">Username and Password don\'t link to an Account.</p>';
                }
                ?>
                <div class="input-wrap">
                <span class="fas fa-user user"></span>
                <input type="text" name="username" class="input" placeholder="Username">
                </div>
                <div class="input-wrap">
                <span class="fas fa-envelope envelope"></span>
                <input type="text" name="email" class="input" placeholder="Email">
                </div>
                <div class="button-container">
                <input type="submit" value="Submit" class="button">
                </div>
                <div id="forgot-anchors">
                  <p><a href="index.php" class="text">Login Page</a></p>
                  <p><a href="contactus.php" class="text">Contact Us</a></p>
                </div>
                
              
            </form>
        </div>
      </div>
    </div>
</body>
</html>
