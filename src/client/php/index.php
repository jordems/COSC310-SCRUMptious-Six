
<!DOCTYPE html>
<html>
<head lang="en">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/login.css">
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script type="text/javaScript" src="js/sha512.js"></script>
  <script type="text/javaScript" src="js/forms.js"></script>
  <script type="text/javaScript" src="../js/login.js"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>

  <title>Scrumptious Finance</title>
</head>
<body>
  <div class="limiter">
    <div class="login-container">
      <div class="login-wrap">
          <figure>
            <img src="" alt="FinaApp Logo" id="logo">
          <figcaption>
              <strong class="title">LOG IN</strong>
          </figcaption>
          </figure>
            <form action="includes/process_login.php" method="post" onsubmit="formhash(this, this.password);" id="login-form">
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
