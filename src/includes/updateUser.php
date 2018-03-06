<?php
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
        header('Location: ../account.php?error=Improper Email Format');
        exit(0);
    }

    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);

    if(empty($firstName) || empty($address) || empty($lastName)){
      header('Location: ../account.php?error=Empty Text Fields');
      exit(0);
    }

    $user_id = $_SESSION['user_id'];

    // check existing email
    $prep_stmt = "SELECT uid FROM Users WHERE email = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 1) {
        // A user with this email already exists
        header('Location: ../account.php?error=Email Already Exists');
        $stmt->close();
    }else{
    // Update the user's info in the database
    if ($update_stmt = $mysqli->prepare("UPDATE Users SET email = ?, firstName = ?, lastName = ?, billingAddress = ? WHERE uid = ?")) {
        $update_stmt->bind_param('ssssi', $email,$firstName,$lastName,$address,$user_id);
        // Execute the prepared query.
        if ($update_stmt->execute()) {
          header('Location: ../account.php?success=1');
        }
    }else{
      header('Location: ../account.php?error=Database Error');
    }
  }


  }else{
      header('Location: ../account.php?error=Empty Text Fields');
  }

?>
