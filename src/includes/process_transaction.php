<?php
/* Document is called when the user requests to Send funds to another user
* -Sanitizes the data then calls the core function
*/
include_once 'db_connect.php';
include_once 'functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (isset($_POST['receivingUsername'], $_POST['amount'], $_POST['reason'], $_POST['account'])) {
    // Sanitize Data
    $receivingUsername = filter_input(INPUT_POST, 'receivingUsername', FILTER_SANITIZE_STRING);
    $reason = filter_input(INPUT_POST, 'reason', FILTER_SANITIZE_STRING);
    $account = filter_input(INPUT_POST, 'account', FILTER_SANITIZE_NUMBER_INT);
    $amount = preg_replace("/[^0-9,.]/", "", $_POST['amount']); // Removes all nonnumeric charachters

    // Make sure that the amount isn't negative
    $amount = abs($amount);


    switch(sendTransaction($receivingUsername, $amount, $reason ,$account, $mysqli)) {
      case 0:
        // Transaction Success
        header('Location: ../transactions.php?success=1');
        break;
      case 1:
        // Transaction Failed DB
        header('Location: ../transactions.php?error=Database Communication Error, Please Contact Us');
        break;
      case 2:
        // Transaction Failed Insufficient Funds
        header('Location: ../transactions.php?error=Insufficient funds');
        break;
      case 3:
        // Transaction Failed Receiving Username Doesn't have a main Account
        header('Location: ../transactions.php?error=Username doesn\'t Exist or User Hasen\'t Set up an Account');
        break;
      case 5:
          // Transaction Failed Receiving Username Doesn't Exist
        header('Location: ../transactions.php?error=You are not linked to this account!');
        break;
      default:
        header('Location: ../transactions.php?error=Unknown Error, Please Contact Us');
        break;
    }
    mysqli_close($mysqli);
} else {
    // The correct POST variables were not sent to this page.
    mysqli_close($mysqli);
    echo 'Invalid Request';
}
