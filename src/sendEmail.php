<?php
	if(isset($_POST['submit'])){
		$username=$_POST['username'];
		$email=$_POST['email'];
		$message=$_POST['subject'];

		$to='han246810@hotmail.com'; // Receiver Email ID, Replace with your email ID
		$subject='Form Submission';
		$message="Name :".$username."\n"."\n"."Wrote the following :"."\n\n".$subject;
		$headers="From: ".$email;

		if(mail($to, $subject, $message, $headers)){
			echo "<h1>Sent Successfully! Thank you"." ".$username.", We will contact you shortly!</h1>";
		}
		else{
			echo "Something went wrong!";
		}
	}
?>