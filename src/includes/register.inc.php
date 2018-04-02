<?php
/* Document is called when the user requests to regester an account
* -Sanitizes the data performs the regester account functionallity
*/
include_once 'db_connect.php';
include_once 'psl-config.php';

$error_msg = "";

if (isset($_POST['username'], $_POST['email'], $_POST['p'], $_POST['firstName'], $_POST['lastName'], $_POST['address'])) {
    // Sanitize and validate the data passed in
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Not a valid email
        $error_msg .= '<p class="error">The email address you entered is not valid</p>';
    }
    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        // The hashed pass should be 128 characters long.
        $error_msg .= '<p class="error">Invalid password configuration.</p>';
    }

    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);

    // Username validity and password validity have been checked client side.
    // This should be adequate as nobody gains any advantage from
    // breaking these rules.

    $prep_stmt = "SELECT uid FROM Users WHERE email = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
   // check existing email
    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            // A user with this email address already exists
            $error_msg .= '<p class="error">A user with this email address already exists.</p>';
                        $stmt->close();
        }
    } else {
        $error_msg .= '<p class="error">Database error Line 39</p>';
            $stmt->close();
    }

    // check existing username
    $prep_stmt = "SELECT uid FROM Users WHERE username = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);

    if ($stmt) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
            if ($stmt->num_rows == 1) {
                    // A user with this username already exists
                    $error_msg .= '<p class="error">A user with this username already exists</p>';
                    $stmt->close();
            }
      } else {
              $error_msg .= '<p class="error">Database error line 55</p>';
              $stmt->close();
      }

    if (empty($error_msg)) {

        // Create hashed password using the password_hash function.
        // This function salts it with a random salt and can be verified with
        // the password_verify function.
        $password = password_hash($password, PASSWORD_BCRYPT);

        // Insert the new user into the database
        if ($insert_stmt = $mysqli->prepare("INSERT INTO Users (username, email, firstName, lastName, billingAddress, password) VALUES (?,?,?,?,?,?)")) {
            $insert_stmt->bind_param('ssssss', $username ,$email,$firstName,$lastName,$address, $password);
            // Execute the prepared query.
            if (! $insert_stmt->execute()) {
                header('Location: ../error.php?err=Registration failure: INSERT');
            }
            $user_id = $mysqli->insert_id;
            if ($insert_stmt = $mysqli->prepare("INSERT INTO Wallet (wid, balance) VALUES (?,0)")) {
                $insert_stmt->bind_param('i', $user_id);
                // Execute the prepared query.
                if (! $insert_stmt->execute()) {
                    header('Location: ../error.php?err=Registration failure: INSERT');
                }
            }

        }
        header('Location: login.php?messege=Registration Successful!');
    }
}
?>
