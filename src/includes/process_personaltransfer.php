<?php
include_once 'db_connect.php';
include_once 'functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (isset($_POST['amount'], $_POST['toaccount'], $_POST['fromaccount'])) {
    // Sanitize Data
    $toAid = filter_input(INPUT_POST, 'toaccount', FILTER_SANITIZE_STRING);
    $fromAid = filter_input(INPUT_POST, 'fromaccount', FILTER_SANITIZE_STRING);
    $amount = preg_replace("/[^0-9,.]/", "", $_POST['amount']); // Removes all nonnumeric charachters

    // Make sure that the amount isn't negative
    $amount = abs($amount);


    switch(personalTransfer($amount, $toAid ,$fromAid, $mysqli)) {
      case 0:
        // Transaction Success
        header('Location: ../account.php?transfersuccess=1');
        break;
      case 1:
        // Transaction Failed DB
        header('Location: ../account.php?transfererror=Database Communication Error, Please Contact Us');
        break;
      case 2:
        // Transaction Failed Insufficient Funds
        header('Location: ../account.php?transfererror=Insufficient funds');
        break;
      case 3:
        // Transaction Failed Receiving Username Doesn't have a main Account
        header('Location: ../account.php?transfererror=Can\'t Send Funds to the Account Sending Funds!');
        break;
      case 5:
          // Transaction Failed Sender is not linked to this account!
        header('Location: ../account.php?transfererror=You are not linked to this account!');
        break;
      default:
        header('Location: ../account.php?transfererror=Unknown Error, Please Contact Us');
        break;
    }
    mysqli_close($mysqli);
} else {
    // The correct POST variables were not sent to this page.
    mysqli_close($mysqli);
    echo 'Invalid Request';
}
