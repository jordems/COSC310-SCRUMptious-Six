<?php
	include_once 'includes/db_connect.php';
	include_once 'includes/functions.php';
	include 'includes/fusioncharts.php';


	$tranSelection = $_POST['tranSelection'];

	//echo isset($_POST['tranSelection']);
	$tranInput = $_POST['tranInput'];
	//echo isset($_POST['tranInput']);



	if(isset($_POST['tranSelection']) && isset($_POST['tranInput']))
	{

			//$tranSelection = $_POST['tranSelection'];
			$user_id=$_POST['user_id'];
			$tranInput = floatval($_POST['tranInput']);
			$datetrack = $_POST['datetrack'];
			$aid = intval($_POST['aid']);
			$statementName = $_POST['statementName'];

			$seed = openssl_random_pseudo_bytes(5);
			$tid = hash("sha256", $user_id.$datetrack.$tranInput.$tranSelection.$aid.$seed); // Create a primary key for the upload

			//echo"<br>tid: ".$tid."<br>";
			//echo"uid: ".$user_id."<br>";
			//echo"aid: ".$aid."<br>";
			//echo"date: ".$datetrack."<br>";
			//echo"amount: ".$tranInput."<br>";
			//echo"statementName: ".$statementName."<br>";

			$insert_stmt = $mysqli->prepare("INSERT INTO AccountTransaction(`tid`, `uid`, `aid`, `date`, `amount`, `desc`, `statementName`) VALUES (?,?,?,?,?,?,?);");
			$insert_stmt->bind_param('siisdss', $tid, $user_id, $aid, $datetrack, $tranInput, $tranSelection, $statementName);
					// Execute the prepared statement.

		if($insert_stmt->execute()){
			echo "add data successfully";
			//echo '<script type="text/javascript"> alert("INSERT successfully") </script>';
			$insert_stmt->close();
		}else{
			//echo '<script type="text/javascript"> alert("insertion problem") </script>';
			$insert_stmt->close();
		}
		$mysqli->close();
	}else{
		echo "can not recieve selection and input value";
	}
