<?php
include_once 'db_connect.php';
include_once 'functions.php';

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
                    if($col_count > 3){
                        header('Location:../addCSV.php?error=Amount of columns is incorrect, please read through the checklist!');
                        fclose($handle);
                        mysqli_close($mysqli);
                        exit(0);
                    }
                    $user_id =  $_SESSION['user_id'];
                    $seed = openssl_random_pseudo_bytes(5);

                    // get the values from the csv
                    $predate = $data[0];
                    $date = filter_var($data[0], FILTER_SANITIZE_URL);
                    if(strcmp($predate, $date) != 0 || $date == NULL){
                        header('Location:../addCSV.php?error=Error in date column on row '.($row+1).'!');
                        fclose($handle);
                        mysqli_close($mysqli);
                        exit(0);
                    }
                    $preamount = $data[1];
                    $amount = filter_var($data[1], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    if(strcmp($preamount,strval($amount)) != 0 || $preamount == NULL){
                        header('Location:../addCSV.php?error=Error in amount column on row '.($row+1).'!');
                        fclose($handle);
                        mysqli_close($mysqli);
                        exit(0);
                    }
                    $predesc = $data[2];
                    $desc = filter_var($data[2], FILTER_SANITIZE_STRING);
                    if(strcmp($predesc, $desc) != 0 || $desc == NULL){
                        header('Location:../addCSV.php?error=Error in description column on row '.($row+1).'!');
                        fclose($handle);
                        mysqli_close($mysqli);
                        exit(0);
                    }
                    $statementName = filter_input(INPUT_POST, 'statement', FILTER_SANITIZE_STRING);
                    $tid = hash("sha256", $user_id.$date.$amount.$desc.$aid.$seed); // Create a primary key for the upload

                    // Insert data into AccountTransaction table
                    if($insert_stmt = $mysqli->prepare("INSERT INTO AccountTransaction (tid, uid, aid, `date`, statementName, amount, `desc`) VALUES (?,?,?,?,?,?,?)")){

                    $insert_stmt->bind_param('siissds', $tid, $user_id, $aid, $date, $statementName, $amount, $desc);
                    // Execute the prepared statement.
                    $insert_stmt->execute();
                    }else{
                        header('Location:../addCSV.php?error=Database error, try again later!');
                        fclose($handle);
                        mysqli_close($mysqli);
                        exit(0);
                    }
                    // inc the row
                    $row++;
                }

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
fclose($handle);
mysqli_close($mysqli);
?>
