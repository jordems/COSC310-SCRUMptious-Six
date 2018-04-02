<?php
/* Page is for the recieved code from the user's email for reseting their password
*/
include_once 'db_connect.php';
include_once 'functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (isset($_POST['code'])) {
    // Sanitize Data
    $code = filter_input(INPUT_POST, 'code', FILTER_SANITIZE_STRING);

    if (verifyCode($code, $mysqli) == true) {
        // If code is verified
        header('Location: ../reset_password.php');
    } else {
        // If code is not verified
        header('Location: ../recovery.php?error=1');
    }
} else {
    // The correct POST variables were not sent to this page.
    echo 'Invalid Request';
}
