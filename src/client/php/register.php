<?php
include_once 'includes/register.inc.php';
include_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html>
    <head lang="en">
        <meta charset="UTF-8">
        <title>Secure Login: Registration Form</title>
        <script type="text/javaScript" src="js/sha512.js"></script>
        <script type="text/javaScript" src="js/forms.js"></script>
    </head>
    <body>
      <header>
        <figure>
          <img src="" alt="FinaApp Logo">
          <figcaption>
            <strong>We Care About your Money&trade;</strong>
          </figcaption>
        </figure>
      </header>
      <main>
        <?php
        /*Registration form to be output if the input from user is not
        Properly formatted. Should only be activated if User is attempting to bypass js.*/
        if (!empty($error_msg)) {
            echo $error_msg;
        }
        ?>
        <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>"
                method="post"
                name="registration_form"
                onsubmit="return regformhash(this, this.username, this.email, this.password, this.confirm);">
            <fieldset>
              <legend>Register</legend>
              <label for="username">Username:</label> <input type='text' name='username' id='username' /><br>
              <label for="email">Email:</label> <input type="text" name="email" id="email" /><br>
              <label for="password">Password:</label> <input type="password" name="password" id="password"><br>
              <label for="confirm">Confirm password:</label> <input type="password" name="confirmp" id="confirm"><br>
              <label for="firstName">First Name:</label> <input type="text" name="firstName" id="firstName" /><br>
              <label for="lastName">Last Name:</label> <input type="text" name="lastName" id="lastName" /><br>
              <label for="address">Address:</label> <input type="text" name="address" id="address" /><br>
              <input type="submit" value="Register">
            </fieldset>
        </form>
        <p>Return to the <a href="index.php">login page</a>.</p>
      </main>
      <footer>
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
