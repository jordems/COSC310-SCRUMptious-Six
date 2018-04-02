<?php
    /*
    This code takes the input from the contact us page form and emails it to the
    scrumptiousfinance email address
    */

include_once 'db_connect.php';
include_once 'functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {
    //sanitize data
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

    $success = mail("scrumptiousfinance@gmail.com", "Scrumptious Finance Contact Form Message",$message, "From: $email" );
    if(isset($success) && $success){
    header('Location: ../contact.php?message=Message Sent!');
    }else{
        header('Location: ../contact.php?error=Failed to send message. Try again later!');
    }
}else{
    header('Location: ../contact.php?error=All fields are required!');
}
?>