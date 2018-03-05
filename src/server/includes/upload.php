<?php 
include_once 'db_connect.php';

$csv = array();

// check there are no errors
if($_FILES['csv']['error'] == 0){
    $name = $_FILES['csv']['name'];
    $ext = strtolower(end(explode('.', $_FILES['csv']['name'])));
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
                $user_id =  $user_id = $_SESSION['user_id'];
                $account_id = $_SESSION['user_id'];
                
                
                // get the values from the csv
                $date = $data[0];
                $amount = $data[1];
                $desc = $data[2];
                $tid = hash("sha256", $user_id.$date.$amount); // Create a primary key for the upload
                // Insert data into AccountTransaction table
                $insert_stmt = $mysqli->prepare("INSERT INTO AccountTransaction (tid, uid, aid, date, amount, `desc`) VALUES (?,?,?,?,?,?)");
                $insert_stmt->bind_param('siisds', $tid, $user_id, $account_id, $date, $amount, $desc);
                // Execute the prepared statement.
                $insert_stmt->execute();
                // inc the row
                $row++;
            }
            fclose($handle);
        }
    }else{
        echo "<p class='help-block'>Only CSV files can be uploaded</p>";
    }
}else{
    echo "<p class='help-block'>We ran into a problem trying to process your file. Please make sure you've followed the checklist below and try again.</p>";
    echo "<h2>Checklist</h2>
          <p>In your CSV file make sure:</p>
          <ul>
            <li>You haven’t included a header row</li>
            <li>The date format is dd/mm/yyyy</li>
            <li>You've used a single 'amounts' column that contains both money paid out and money paid in</li>
            <li>There are no commas in your amounts columns</li>
            <li>You haven't included any quote marks (\")</li>
            <li>Each description is on a single line</li>
            <li>The file format is .csv (not .xls or .xlsx)</li>
            <li>A character delimiter of comma ',' is being used when you export your CSV file.</li>
          </ul>";
}
?>

    

