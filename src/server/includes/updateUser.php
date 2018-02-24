<?php
include_once 'db_connect.php';
include_once 'psl-config.php';

$error_msg = "";

if (isset($_POST['username'], $_POST['email'], $_POST['firstName'], $_POST['lastName'], $_POST['address'])) {
    // Sanitize and validate the data passed in
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Not a valid email
        $error_msg .= '<p class="error">The email address you entered is not valid</p>';
    }
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

        // Update the user's info in the database
        if ($update_stmt = $mysqli->prepare("UPDATE Users SET username = ?, email = ?, firstName = ? lastName = ? address = ?) {
            $update_stmt->bind_param('sssss', $username,$email,$firstName,$lastName,$address);
            // Execute the prepared query.
            if (! $update_stmt->execute()) {
                header('Location: ../error.php?err=Update failure: UPDATE');
            }
        }
        header('Location: ./update_success.php');
    }
}
?>
