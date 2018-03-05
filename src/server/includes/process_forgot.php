<?php
include_once 'db_connect.php';
include_once 'functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (isset($_POST['username'], $_POST['email'])) {

    // Sanitize Data
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Not a valid email
        $error_msg .= '<p class="error">The email address you entered is not valid</p>';
    }

    if (submitForgot($username, $email, $mysqli) == true) {
        // Email Sent
        header('Location: ../recovery.php');
    } else {
        // Email Not Sent
        header('Location: ../forgot.php?error=1');
    }
} else {
    // The correct POST variables were not sent to this page.
    echo 'Invalid Request';
}
