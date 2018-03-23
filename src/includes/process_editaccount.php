<?php
include_once 'db_connect.php';
include_once 'functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (isset($_POST['title'], $_POST['financialinstitution'], $_POST['type'], $_POST['balance'], $_POST['aid'])) {

    // Sanitize Data
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $financialinstitution = filter_input(INPUT_POST, 'financialinstitution', FILTER_SANITIZE_STRING);
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
    $balance = preg_replace("/[^0-9,.]/", "", $_POST['balance']); // Removes all nonnumeric charachters
    $aid = filter_input(INPUT_POST,'aid' ,FILTER_SANITIZE_NUMBER_INT);

    if (editAccount($title, $financialinstitution,$type,$balance,$aid, $mysqli) == true) {
        // Account Edited
        header('Location: ../editaccount.php?aid='.$aid.'&success=1');
    } else {
        // Failed
        header('Location: ../editaccount.php?aid='.$aid.'&error=1');
    }
} else {
    // The correct POST variables were not sent to this page.
    echo 'Invalid Request';
}
