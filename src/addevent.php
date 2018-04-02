<?php


	include_once 'includes/db_connect.php';
	include_once 'includes/functions.php';
	include 'includes/fusioncharts.php';
	
	
	$tranSelection = $_POST['tranSelection'];
	
	//echo isset($_POST['tranSelection']);
	$tranInput = $_POST['tranInput'];
	//echo isset($_POST['tranInput']);
	
	
	
	if(isset($_POST['tranSelection'])==1 && isset($_POST['tranInput'])==1)
	{
		
			//$tranSelection = $_POST['tranSelection'];
			$user_id=$_POST['user_id'];
			$tranInput = $_POST['tranInput'];
			$datetrack = $_POST['datetrack'];
			$aid = $_POST['aid'];
			$statementName = $_POST['statementName'];
			
			$seed = openssl_random_pseudo_bytes(5);
			$tid = hash("sha256", $user_id.$datetrack.$tranInput.$tranSelection .$aid.$seed); // Create a primary key for the upload
			
			//echo"<br>tid: ".$tid."<br>";
			//echo"uid: ".$user_id."<br>";
			//echo"aid: ".$aid."<br>";
			//echo"date: ".$datetrack."<br>";
			//echo"amount: ".$tranInput."<br>";
			//echo"statementName: ".$statementName."<br>";
			
			$sql_insert = "INSERT INTO accounttransaction(`tid`,`uid`,`aid`,`date`,`amount`,`desc`,`statementName`) VALUES('$tid','$user_id','$aid','$datetrack','$tranInput','$tranSelection','$statementName')";
							
			$insert=mysqli_query($mysqli,$sql_insert);
		if($insert){
			echo "add data successfully";
			//echo '<script type="text/javascript"> alert("INSERT successfully") </script>';
		}else{
			echo "insertion problem";
			//echo '<script type="text/javascript"> alert("insertion problem") </script>';
		}
	}else{
		echo "can not recieve selection and input value";
			
	}