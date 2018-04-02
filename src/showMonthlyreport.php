<!DOCTYPE html>
<html>
<head>
<style>
.report {
    border-collapse: collapse;
	padding-left: 30px;
	width="100%";
}

.report td  {
    border: 1px solid black;
	color: black;
	padding-left: 30px;
	width="80px";
}
.report th {
    border: 1px solid black;
	color: black;
	padding-left: 30px;
	width="80px";
}

div#text {
    width: 500px;
    height: 320px;
    overflow: scroll;
}

</style>
</head>
<body>
<?php
	include_once 'includes/db_connect.php';
	include_once 'includes/functions.php';
	include 'includes/fusioncharts.php';


	if(isset($_POST['user_id']))
	{

			$user_id= $_POST['user_id'];
			$firstDate=$_POST['firstDate'];
			$LastDate=$_POST['LastDate'];

			$sql_searchByDate = "select Users.username,AccountTransaction.* from AccountTransaction, Users where AccountTransaction.uID= Users.uID and AccountTransaction.uID = '$user_id' and '$firstDate' <=`date` and `date` < '$LastDate'  ORDER BY date ASC";
			//$sql_searchByDate = "select Users.username,AccountTransaction.* from AccountTransaction, Users where AccountTransaction.uID= Users.uID and AccountTransaction.uID = 10 and date= '2018-03-03'";
			$searchByDate=mysqli_query($mysqli,$sql_searchByDate);
		if($searchByDate){
			//echo " serach data success";
		}else{
			echo"searchByDate query problem";
		}

		//echo "<p>YYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY</p>";
		echo "<table class =\"report\" >

			<tr>
			<th>username&nbsp;</th>
			<th>date&nbsp;</th>
			<th>amount&nbsp;</th>
			<th>desc&nbsp;</th>
			<th>statementName&nbsp;</th>
			</tr>";


		if($searchByDate=mysqli_query($mysqli,$sql_searchByDate))
		{
			while($row = mysqli_fetch_assoc($searchByDate)){
			//echo "<p>TTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTT</p>";
			$name=$row['username'];
			$date=$row['date'];
			$amount=$row['amount'];
			$desc=$row['desc'];
			$statementName=$row['statementName'];

  ?>

		<tr>
		<td><?php echo $name; ?></td>
		<td><?php echo $date; ?></td>
		<td><?php echo $amount; ?></td>
		<td><?php echo $desc; ?></td>
		<td><?php echo $statementName; ?></td>
		</tr>



	<?php
			}echo "</table>";}else{
			echo "<p>NO record</p>";
		}
	?>
  <?php

exit;
	}

?>
</body>
</html>
