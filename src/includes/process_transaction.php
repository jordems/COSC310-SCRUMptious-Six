<?php
include_once 'db_connect.php';
include_once 'functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (isset($_POST['receivingUsername'], $_POST['amount'], $_POST['reason'])) {
    // Sanitize Data
    $receivingUsername = filter_input(INPUT_POST, 'receivingUsername', FILTER_SANITIZE_STRING);
    $reason = filter_input(INPUT_POST, 'reason', FILTER_SANITIZE_STRING);
    $amount = preg_replace("/[^0-9,.]/", "", $_POST['amount']); // Removes all nonnumeric charachters

    // Make sure that the amount isn't negative
    $amount = abs($amount);
    switch(sendTransaction($receivingUsername, $amount, $reason, $mysqli)) {
      case 0:
        // Transaction Success
        header('Location: ../transactions.php?success=1');
        break;
      case 1:
        // Transaction Failed DB error
        header('Location: ../transactions.php?error=Database Communication Error, Please Contact Us');
        break;
      case 2:
        // Transaction Failed Insufficient Funds error
        header('Location: ../transactions.php?error=Insufficient funds');
        break;
      case 3:
        // Transaction Failed Username Doesn't Exist error
        header('Location: ../transactions.php?error=Username doesn\'t Exist');
        break;
    }
} else {
    // The correct POST variables were not sent to this page.
    echo 'Invalid Request';
}
