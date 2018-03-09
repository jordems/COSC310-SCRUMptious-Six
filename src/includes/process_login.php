<?php
include_once 'db_connect.php';
include_once 'functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (isset($_POST['username'], $_POST['p'])) {

    // Sanitize Data
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);

    if (login($username, $password, $mysqli) == true) {
        // Login success
        header('Location: ../overview.php');
    } else {
        // Login failed
        header('Location: ../index.php?error=Username or Password Incorrect');
    }
} else {
    // The correct POST variables were not sent to this page.
    echo 'Invalid Request';
}