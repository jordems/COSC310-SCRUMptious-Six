<?php
include_once 'includes/register.inc.php';
include_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html>
    <head lang="en">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/login.css">
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
                <img src="" alt="FinaApp Logo" id="logo">
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
                          echo $error_msg;
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
                      <p><a href="index.php" class="text">Already have an Account?</a></p>
                      </div>
                    
                </form>
           </div>
        </div>
     </div>
    
    </body>
</html>
