<?php
include_once 'db_connect.php';
include_once 'functions.php';
include_once 'psl-config.php';
sec_session_start();
$csv = array();

if(isset($_POST['Account'])){
$aid = filter_input(INPUT_POST, 'Account', $filter = FILTER_SANITIZE_NUMBER_INT);



// check there are no errors
if($_FILES['csv']['error'] == 0){
    $name = $_FILES['csv']['name'];
    $path = $_FILES['csv']['name'];
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $type = $_FILES['csv']['type'];
    $tmpName = $_FILES['csv']['tmp_name'];

    // check the file is a csv
    if($ext === 'csv'){
        if(($handle = fopen($tmpName, 'r')) !== FALSE) {
            // necessary if a large csv file
            set_time_limit(0);

            $row = 0;

            while(($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                // number of fields in the csv
                $col_count = count($data);
                $user_id =  $_SESSION['user_id'];
                $seed = openssl_random_pseudo_bytes(5);

                // get the values from the csv
                $date = $data[0];
                $amount = floatval($data[1]);
                $desc = $data[2];
                $statementName = filter_input(INPUT_POST, 'statement', FILTER_SANITIZE_STRING);
                $tid = hash("sha256", $user_id.$date.$amount.$desc.$aid.$seed); // Create a primary key for the upload
                // Insert data into AccountTransaction table
                $insert_stmt = $mysqli->prepare("INSERT INTO AccountTransaction (tid, uid, aid, date, statementName, amount, `desc`) VALUES (?,?,?,?,?,?,?)");

                $insert_stmt->bind_param('siissds', $tid, $user_id, $aid, $date, $statementName, $amount, $desc);
                // Execute the prepared statement.
                $insert_stmt->execute();

                // inc the row
                $row++;
            }
            fclose($handle);
            header('Location:../addCSV.php?message=Upload Successful!');
        }
    }else{
        header('Location: ../addCSV.php?error=Only CSV files can be uploaded.');
    }
}else{
    header('Location: ../addCSV.php?error=An error occured. Go over the checklist and try again.');
}
}else{
    header('Location:../addCSV.php?error=You must add an account.');
}
?>
