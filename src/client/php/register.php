<?php
include_once 'includes/register.inc.php';
include_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html>
    <head lang="en">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/reset.css">
        <link rel="stylesheet" href="css/register.css">
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
        <div id="register-content">
          <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>"
                  method="post"
                  name="registration_form"
                  onsubmit="return regformhash(this, this.username, this.email, this.password, this.confirm, this.firstName, this.lastName, this.address);">
              <fieldset>
                <?php
                /*Registration form to be output if the input from user is not
                Properly formatted. Should only be activated if User is attempting to bypass js.*/
                if (!empty($error_msg)) {
                    echo $error_msg;
                }
                ?>
                <legend>Register</legend>
                <label for="username">Username:</label> <input type='text' name='username' id='username' />
                <label for="password">Password:</label> <input type="password" name="password" id="password">
                <label for="confirm">Confirm password:</label> <input type="password" name="confirm" id="confirm">
                <label for="email">Email:</label> <input type="text" name="email" id="email" />
                <label for="firstName">First Name:</label> <input type="text" name="firstName" id="firstName" />
                <label for="lastName">Last Name:</label> <input type="text" name="lastName" id="lastName" />
                <label for="address">Address:</label> <input type="text" name="address" id="address" />
                <input type="submit" value="Register" id="register-submit">
                <p><a href="../">Already have an Account?</a></p>
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
