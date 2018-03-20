<?php
include_once 'psl-config.php';

function sec_session_start() {
    $session_name = 'sec_session_id';   // session name
    $secure = SECURE;
    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
    // Sets the session name to the one set above.
    session_name($session_name);
    session_start();            // Start the PHP session
    session_regenerate_id();    // regenerated the session, delete the old one.
}

function login($username, $password, $mysqli) {
    // Using prepared statements means that SQL injection is not possible.
    if ($stmt = $mysqli->prepare("SELECT uid, password
        FROM Users
       WHERE username = ?
        LIMIT 1")) {
        $stmt->bind_param('s', $username);
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();

        // get variables from result.
        $stmt->bind_result($user_id, $db_password);
        $stmt->fetch();


        if ($stmt->num_rows == 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts

            if (checkbrute($user_id, $mysqli) == true) {
                // Account is locked
                // Send an email to user saying their account is locked
                return false;
            } else {
                // Check if the password in the database matches
                // the password the user submitted. We are using
                // the password_verify function to avoid timing attacks.
                if (password_verify($password, $db_password)) {
                    // Password is correct!
                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    // XSS protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    // XSS protection as we might print this value
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/",
                                                                "",
                                                                $username);
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512',
                              $db_password . $user_browser);
                    // Login successful.
                    return true;
                } else {
                    // Password is not correct
                    // We record this attempt in the database
                    $now = time();
                    $mysqli->query("INSERT INTO login_attempts(compid, time)
                                    VALUES ('$user_id', '$now')");
                    return false;
                }
            }
        } else {
            // No user exists.
            return false;
        }
    }
}

function getBalance($user_id, $mysqli){
  $user_id = $_SESSION['user_id'];

  if ($stmt = $mysqli->prepare("SELECT balance
      FROM Wallet
     WHERE wid = ?
      LIMIT 1")) {
      $stmt->bind_param('i', $user_id);
      $stmt->execute();    // Execute the prepared query.
      $stmt->store_result();

      // get variables from result.
      $stmt->bind_result($balance);
      $stmt->fetch();

      if ($stmt->num_rows == 1) {
          return $balance;
      }
      return -1.0;
    }

}

function checkbrute($user_id, $mysqli) {
    // Get timestamp of current time
    $now = time();

    // All login attempts are counted from the past 2 hours.
    $valid_attempts = $now - (2 * 60 * 60);

    if ($stmt = $mysqli->prepare("SELECT time
                             FROM login_attempts
                             WHERE compid = ?
                            AND time > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);

        // Execute the prepared query.
        $stmt->execute();
        $stmt->store_result();

        // If there have been more than 7 failed logins
        if ($stmt->num_rows > 7) {
            return true;
        } else {
            return false;
        }
    }
}

function login_check($mysqli) {
    // Check if all session variables are set
    if (isset($_SESSION['user_id'],
                        $_SESSION['username'],
                        $_SESSION['login_string'])) {

        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];

        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        if ($stmt = $mysqli->prepare("SELECT password
                                      FROM Users
                                      WHERE uid = ? LIMIT 1")) {
            // Bind "$user_id" to parameter.
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                // If the user exists get variables from result.
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);

                if (hash_equals($login_check, $login_string) ){
                    // Logged In!!!!
                    return true;
                } else {
                    // Not logged in
                    return false;
                }
            } else {
                // Not logged in
                return false;
            }
        } else {
            // Not logged in
            return false;
        }
    } else {
        // Not logged in
        return false;
    }
}

function esc_url($url) {

    if ('' == $url) {
        return $url;
    }

    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;

    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }

    $url = str_replace(';//', '://', $url);
    $url = htmlentities($url);
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);

    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
  }

  function submitForgot($username, $email, $mysqli){
    if ($stmt = $mysqli->prepare("SELECT uid
        FROM Users
       WHERE username = ? and email = ?
        LIMIT 1")) {
        $stmt->bind_param('ss', $username, $email);
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();

        // get variables from result.
        $stmt->bind_result($user_id);
        $stmt->fetch();

        // if their is a user with the entered username and password then cont.
        if ($stmt->num_rows == 1) {

          $_SESSION['user_id'] = $user_id; // set a session variable for uid so we can keep track of this person for later

          // create a random String of characters that is 10 characters long
          $bytes = openssl_random_pseudo_bytes(5);
          $code = bin2hex($bytes);
          //TODO: Send email to the user.
          if(sendEmail($email, $code) == true){

            if ($insert_stmt = $mysqli->prepare("INSERT INTO forgot (uid, code) VALUES (?,?)")) {
                $insert_stmt->bind_param('is', $user_id, $code);
                // Execute the prepared query.
                if ($insert_stmt->execute()) {
                    // If insert doesn't complete for some reason
                    return true;
                }
            }
          }
        }
    }
    return false;
  }

  function sendEmail($email, $code){
    // Setting content-type
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: <noreply@scrumptiousfinance.com>' . "\r\n";

    $message = "
    <html>
      <head>
      <title>Password Reset</title>
      </head>
      <body>
      <h1>Password Reset</h1>
      <p>Code: ".$code."</p>
      </body>
    </html>
    ";
    mail($email,"no-reply: Scrumptious Finance - Password Reset",$message,$headers);
    return true;
  }

  function verifyCode($code, $mysqli){
    $user_id = $_SESSION['user_id'];
    if($user_id == null)
      return false;

      // Make sure that the code has been generated within 10 minutes
    if ($stmt = $mysqli->prepare("SELECT uid
          FROM forgot
          WHERE uid = ? and code = ? and timeStamp >= NOW() - INTERVAL 10 MINUTE
          LIMIT 1")) {
        $stmt->bind_param('is', $user_id, $code);
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();

        // get variables from result.
        $stmt->bind_result($user_id);
        $stmt->fetch();

        // if their is a user with the entered username and password then cont.
        if ($stmt->num_rows == 1) {
          $bytes = openssl_random_pseudo_bytes(5);
          $bString = bin2hex($bytes);
          $_SESSION['browserString'] = $bString;
          if ($insert_stmt = $mysqli->prepare("UPDATE forgot SET browserString = ? WHERE uid = ? and code = ?")) {
              $insert_stmt->bind_param('sis', $bString, $user_id, $code);
              // Execute the prepared query.
              if ($insert_stmt->execute()) {
                  // If insert doesn't complete for some reason
                  return true;
              }
          }
        }
      }

    return false;
  }

  function updatePassword($password, $mysqli){
    $user_id = $_SESSION['user_id'];
    if($user_id == null)
      return false;
    $user_browser = $_SESSION['browserString'];

      // Make sure that the code has been generated within 10 minutes
    if ($stmt = $mysqli->prepare("SELECT uid
          FROM forgot
          WHERE uid = ? and browserString = ? and timeStamp >= NOW() - INTERVAL 10 MINUTE
          ORDER BY timeStamp DESC LIMIT 1")) {
        $stmt->bind_param('is', $user_id, $user_browser);
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();

        // get variables from result.
        $stmt->bind_result($user_id);
        $stmt->fetch();

        // if their is a user with the entered username and password then cont.
        if ($stmt->num_rows == 1) {
          $password = password_hash($password, PASSWORD_BCRYPT);
          if ($insert_stmt = $mysqli->prepare("UPDATE Users SET password = ? WHERE uid = ?")) {
              $insert_stmt->bind_param('si', $password, $user_id);
              // Execute the prepared query.
              if ($insert_stmt->execute()) {
                  // If successful
                  return true;
              }
          }
        }
      }
    return false;
  }

  function sendTransaction($receivingUsername, $amount, $reason, $mysqli){
    $user_id = $_SESSION['user_id'];
    if($user_id == null)
      return 1;

    // Query that the sending user has enough money and their account is not frozen
    $stmt = $mysqli->prepare("SELECT wid FROM Wallet WHERE wid = ? and balance >= ? and !isFrozen");
    $stmt->bind_param('sd', $user_id, $amount);
    $stmt->execute();    // Execute the prepared query.
    $stmt->store_result();

    $stmt->bind_result($receivingUser_id);
    $stmt->fetch();

    // if the sending user has enough balance then:
    if ($stmt->num_rows == 1) {

      // Query that the  "$receivingUsername" exists in the database
      $stmt = $mysqli->prepare("SELECT uid FROM Users WHERE username = ?");
      $stmt->bind_param('s', $receivingUsername);
      $stmt->execute();    // Execute the prepared query.
      $stmt->store_result();

      // get variables from result.
      $stmt->bind_result($receivingUser_id);
      $stmt->fetch();

      // if the "$receivingUsername" exists in the database then:
      if ($stmt->num_rows == 1) {

        // Remove the balance from the sender first
        $update_stmt = $mysqli->prepare("UPDATE Wallet SET balance = balance - ? WHERE wid = ?");
        $update_stmt->bind_param('di', $amount, $user_id);

        if(!$update_stmt->execute()){
          // Problem has Occured removing the balance from sender
          return 1;
        }

        // Update the balance of the receiever
        $update_stmt = $mysqli->prepare("UPDATE Wallet SET balance = balance + ? WHERE wid = ?");
        $update_stmt->bind_param('di', $amount, $receivingUser_id);

        if(!$update_stmt->execute()){
          /* Problem has Occured adding the balance to the receiver
          *  Therefore, we must reimburse the sender*/
          $update_stmt = $mysqli->prepare("UPDATE Wallet SET balance = balance + ? WHERE wid = ?");
          $update_stmt->bind_param('di', $amount, $user_id);
          $update_stmt->execute();
          return 1;
        }

        date_default_timezone_set("Canada/Pacific"); // So the time taken is PST
        $timestamp = date('Y-m-d G:i:s'); // Current timestamp in mysql format
        $tid = hash("sha256", $user_id.$receivingUser_id.$timestamp); // Create a primary key for the transaction
        // Insert Completed transaction into transaction table
        $insert_stmt = $mysqli->prepare("INSERT INTO Transaction (tid, fromid, toid, amount, reason, datetime) VALUES (?,?,?,?,?,?)");
        $insert_stmt->bind_param('siidss', $tid, $user_id, $receivingUser_id, $amount, $reason, $timestamp);
            // Execute the prepared statement.
        $insert_stmt->execute();
        return 0;

      }else{
        return 3;
      }

    }else{
      return 2;
    }

  }

  function addAccount($title, $financialinstitution,$type,$balance, $mysqli){
    $user_id = $_SESSION['user_id'];
    if($user_id == null)
      return false;

      // Insert Account into the db
    $insert_stmt = $mysqli->prepare("INSERT INTO Account (uid, balance, title, financialinstitution, type) VALUES (?,?,?,?,?)");
    $insert_stmt->bind_param('idsss', $user_id,$balance, $title, $financialinstitution, $type);
        // Execute the prepared statement.
    if($insert_stmt->execute()){
      return true;
    }
    return false;
  }

  function editAccount($title, $financialinstitution,$type,$balance,$aid, $mysqli){
    $user_id = $_SESSION['user_id'];
    if($user_id == null)
      return false;

      // Insert Account into the db
    $UPDATE_stmt = $mysqli->prepare("UPDATE Account SET balance = ?, title = ?, financialinstitution = ?, type = ? WHERE aid = ? and uid = ?");
    $UPDATE_stmt->bind_param('dsssii', $balance, $title, $financialinstitution, $type,$aid, $user_id);
        // Execute the prepared statement.
    if($UPDATE_stmt->execute()){
      return true;
    }
    return false;
  }
  function deleteAccount($aid, $mysqli){
    $user_id = $_SESSION['user_id'];
    if($user_id == null)
      return false;

    $remove_stmt = "DELETE FROM AccountTransaction WHERE aid = ? and uid = ?";
    $stmt = $mysqli->prepare($remove_stmt);
    // check existing email
    if ($stmt) {
        $stmt->bind_param('ii',$aid,$user_id);
        if($stmt->execute()){
          $DELETE_stmt = $mysqli->prepare("DELETE FROM Account WHERE aid = ? and uid = ?");
          $DELETE_stmt->bind_param('ii', $aid, $user_id);
              // Execute the prepared statement.
          if($DELETE_stmt->execute()){
            $DELETE_stmt->close();
            return true;
          }
          $DELETE_stmt->close();
        }
    $stmt->close();
    }
    return false;
  }

  function userHasAccount($user_id, $aid, $mysqli){
    if($user_id == null)
      return false;

    $stmt = $mysqli->prepare("SELECT uid FROM Account WHERE uid = ? and aid = ?");
    $stmt->bind_param('ii', $user_id, $aid);
    $stmt->execute();    // Execute the prepared query.
    $stmt->store_result();

    $stmt->bind_result($receivingUser_id);
    $stmt->fetch();

    // if the sending user has enough balance then:
    if ($stmt->num_rows == 1) {
      return true;
    }
    return false;
  }
