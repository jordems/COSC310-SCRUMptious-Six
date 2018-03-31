<?php
include_once 'db_connect.php';
include_once 'functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (isset($_POST['title'], $_POST['financialinstitution'], $_POST['type'], $_POST['balance'])) {

    // Sanitize Data
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $financialinstitution = filter_input(INPUT_POST, 'financialinstitution', FILTER_SANITIZE_STRING);
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
    $balance = filter_input(INPUT_POST,'balance' ,FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    $mysqli->autocommit(FALSE);

    if (addAccount($title, $financialinstitution,$type,$balance, $mysqli) == true) {
        // Account Created
        header('Location: ../account.php?addsuccess=1');
    } else {
        // Failed
        header('Location: ../account.php?adderror=1');
    }
    $mysqli->autocommit(TRUE);
    $mysqli->close();
} else {
    // The correct POST variables were not sent to this page.
    echo 'Invalid Request';
}
