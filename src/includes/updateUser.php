<?php

    /*
    This code updates the user's information in the database when they change it on their profile page 
    */

include_once 'db_connect.php';
include_once 'psl-config.php';
include_once 'functions.php';

sec_session_start();
$error_msg = "";

if (isset($_POST['email'], $_POST['firstName'], $_POST['lastName'], $_POST['address'])){


    // Sanitize and validate the data passed in
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: /../profile.php?error=Improper Email Format');
        exit(0);
    }

    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);

    if(empty($firstName) || empty($address) || empty($lastName)){
      header('Location: /../profile.php?error=Empty Text Fields');
      exit(0);
    }

    $user_id = $_SESSION['user_id'];

    // check existing email
    $prep_stmt = "SELECT email FROM Users WHERE uid = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->store_result();

    $stmt->bind_result($db_email);
    $stmt->fetch();
    if ($stmt->num_rows == 1) {

        if(strcasecmp($email, $db_email) == 0){
          if ($update_stmt = $mysqli->prepare("UPDATE Users SET firstName = ?, lastName = ?, billingAddress = ? WHERE uid = ?")) {
              $update_stmt->bind_param('sssi', $firstName,$lastName,$address,$user_id);
              // Execute the prepared query.
              if ($update_stmt->execute()) {
                $update_stmt->close();
                $stmt->close();
                header('Location: ../profile.php?success=1');
              }
          }else{
            $stmt->close();
            header('Location: ../profile.php?error=Error 503');
          }
        }else{
          // Check if a user with this email already exists
          $prep_stmt = "SELECT uid FROM Users WHERE email = ?";
          $stmt = $mysqli->prepare($prep_stmt);
          $stmt->bind_param('s', $email);
          $stmt->execute();
          $stmt->store_result();

          $stmt->bind_result($db_email);
          $stmt->fetch();
          if ($stmt->num_rows == 1) {
            header('Location: ../profile.php?error=Email is already in use on a different account');
          }

          if ($update_stmt = $mysqli->prepare("UPDATE Users SET email = ?, firstName = ?, lastName = ?, billingAddress = ? WHERE uid = ?")) {
              $update_stmt->bind_param('ssssi', $email,$firstName,$lastName,$address,$user_id);
              // Execute the prepared query.
              if ($update_stmt->execute()) {
                $update_stmt->close();
                $stmt->close();
                header('Location: ../profile.php?success=1');
              }
          }else{
            $stmt->close();
            header('Location: ../profile.php?error=Error 503');
          }
        }
        $stmt->close();
    }else{
    // Update the user's info in the database
    header('Location: ../profile.php?error=Error 503');
  }


  }else{
      header('Location: ../profile.php?error=Empty Text Fields');
  }

?>
