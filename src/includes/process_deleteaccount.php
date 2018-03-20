<?php
include_once 'db_connect.php';
include_once 'functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (login_check($mysqli) == false) {
    // If already Logged in then send to login page
    header('Location:login.php');
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['aid'])) {

    $aid = filter_input(INPUT_GET,'aid' ,FILTER_SANITIZE_NUMBER_INT);

    if(!userHasAccount($user_id, $aid, $mysqli)){
      // Account doesn't belong to user so redirect them
      header('Location: ../account.php?deleteerror=1');
      exit(0);
    }

    if (deleteAccount($aid, $mysqli) == true) {
        // Account Created
        header('Location: ../account.php?deletesuccess=1');
    } else {
        // Failed
        header('Location: ../account.php?deleteerror=1');
    }
} else {
    // The correct POST variables were not sent to this page.
    echo 'Invalid Request';
}
mysqli_close($mysqli);
