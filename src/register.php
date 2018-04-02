<?php
/* Document is displayed when the client is on the register page
* - Displays the inputs for the register Form: register.inc.php
*/
include_once 'includes/register.inc.php';
include_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html>
    <head lang="en">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/login.css">
        <link rel="shortcut icon" type="image/x-icon" href="img/sf_icon.ico" />
        <script type="text/javaScript" src="js/sha512.js"></script>
        <script type="text/javaScript" src="js/forms.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>

        <title>Register | Scrumptious Finance</title>
    </head>
    <body>
      <div class="limiter">
        <div class="login-container">
          <div class="login-wrap">
              <figure>
                <a href="overview.php"><img src="img/sf_logo.png" alt="Logo" id="logo" /></a>
                <figcaption>
                  <strong class="title">REGISTER</strong>
                </figcaption>
              </figure>

                <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>"
                        class="login-form"
                        method="post"
                        name="registration_form"
                        onsubmit="return regformhash(this, this.username, this.email, this.password, this.confirm, this.firstName, this.lastName, this.address);">

                      <?php
                      /*Registration form to be output if the input from user is not
                      Properly formatted. Should only be activated if User is attempting to bypass js.*/
                      if (!empty($error_msg)) {
                          echo '<h2 class="error-msg">'.$error_msg.'</h2>';
                      }
                      ?>
                      <div class="input-wrap">

                      <input type='text' name='username' placeholder="Username" class="input"/>
                      </div>
                      <div class="input-wrap">

                      <input type="password" name="password" placeholder="Password" class="input">
                      </div>
                      <div class="input-wrap">

                      <input type="password" name="confirm" placeholder="Confirm Password" class="input">
                      </div>
                      <div class="input-wrap">
                      <input type="text" name="email" placeholder="Email" class="input"/>
                      </div>
                      <div class="input-wrap">
                      <input type="text" name="firstName" placeholder="First Name" class="input"/>
                      </div>
                      <div class="input-wrap">
                      <input type="text" name="lastName" placeholder="Last Name" class="input"/>
                      </div>
                      <div class="input-wrap">
                      <input type="text" name="address" placeholder="Address" class="input"/>
                      </div>
                      <div class="button-container">
                      <input type="submit" value="Register" class="button">
                      </div>
                      <div id="login-anchors">
                      <p><a href="login.php" class="text">Already have an Account?</a></p>
                      </div>

                </form>
           </div>
        </div>
     </div>

    </body>
</html>
