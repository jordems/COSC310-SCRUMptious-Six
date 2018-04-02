<?php
/* This document is requested when the user wants to change their Main Account*/

include_once 'db_connect.php';
include_once 'functions.php';

$error_msg = "";
sec_session_start();

if(!login_check($mysqli)){
  exit(0);
}
$user_id = $_SESSION['user_id'];

if (isset($_POST['account'])) {
    // Sanitize and validate the data passed in
    $aid = filter_input(INPUT_POST, 'account', FILTER_SANITIZE_NUMBER_INT);
    // Make sure that this user owns this account
    $prep_stmt = "SELECT aid FROM Account WHERE aid = ? and uid = ?";

    if ($stmt = $mysqli->prepare($prep_stmt)){

      $stmt->bind_param('ii',$aid,$user_id);
      $stmt->execute();
      $stmt->store_result();

      if ($stmt->num_rows == 1) {
        // Update the users Main account
        $update_sql = "UPDATE Users SET mainAcc = ? WHERE uid = ?";
        $stmt = $mysqli->prepare($update_sql);

        if ($stmt) {
            $stmt->bind_param('ii',$aid,$user_id);
            if($stmt->execute()){
            // Update Success
            header('Location: ../account.php?mainaccsuccess=1');
          }else{
            header('Location: ../account.php?mainaccerror=Error 503');
          }
        $stmt->close();
      }else{
          // Database Error
          header('Location: ../account.php?error=Error 503');
        }
    } else {
      header('Location: ../account.php?mainaccerror=That isn\'t your account!');
      $stmt->close();
    }
}else{
    // Database Error
    header('Location: ../account.php?error=Error 503');
  }
}else{
    // Database Error
    header('Location: ../account.php?error=Error 503');
  }

?>
