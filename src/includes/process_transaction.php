<?php
include_once 'db_connect.php';
include_once 'functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (isset($_POST['receivingUsername'], $_POST['amount'])) {

    // Sanitize Data
    $receivingUsername = filter_input(INPUT_POST, 'receivingUsername', FILTER_SANITIZE_STRING);
    $amount = filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_NUMBER_INT);

    // Make sure that the amount isn't negative
    $amount = abs($amount);

    if (sendTransaction($receivingUsername, $amount, $mysqli) == true) {
        // Transaction Success
        header('Location: ../send.php?success=1');
    } else {
        // Transaction Failed
        header('Location: ../send.php?error=1');
    }
} else {
    // The correct POST variables were not sent to this page.
    echo 'Invalid Request';
}
