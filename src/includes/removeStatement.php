<?php
/* Document is called when the user requests to delete a statement off an account
* -Sanitizes the data then completes the functionallity
*/

include_once 'db_connect.php';
include_once 'psl-config.php';
include_once 'functions.php';

$error_msg = "";
sec_session_start();

if(!login_check($mysqli)){
  exit(0);
}
$user_id = $_SESSION['user_id'];

if (isset($_POST['aid'],$_POST['statementName'])) {
    // Sanitize and validate the data passed in

    $statementName = filter_input(INPUT_POST, 'statementName', FILTER_SANITIZE_STRING);
    $aid = filter_input(INPUT_POST, 'aid', FILTER_SANITIZE_NUMBER_INT);

    $prep_stmt = "SELECT statementName FROM AccountTransaction WHERE aid = ? and statementName = ? and uid = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);

    // Query to Find if the Statment requesting deletion exists
    if ($stmt) {

        $stmt->bind_param('isi',$aid,$statementName,$user_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
          // Delete Statment
          $remove_stmt = "DELETE FROM AccountTransaction WHERE aid = ? and statementName = ? and uid = ?";
          $stmt = $mysqli->prepare($remove_stmt);

          if ($stmt) {
              $stmt->bind_param('isi',$aid,$statementName,$user_id);
              $stmt->execute();
              // Deletion Success
              header('Location: ../accountdetails.php?aid='.$aid.'&success=1');
          $stmt->close();
        }
    } else {
            $stmt->close();
    }
}
}else{
    // Database Error
    header('Location: ../accountdetails.php?aid='.$aid.'&error=Error 503');
  }

?>
