<?php 
require 'connectDB.php';
session_start();
if (!isset($_SESSION["emp_id"])) {
	header("Location: login.php");
	exit();
}
$emp_id = $_SESSION["emp_id"];

$nameQuery = mysqli_query($con, " SELECT first_name, last_name, is_manager FROM employee WHERE emp_id = $emp_id ");
$arr = $nameQuery->fetch_assoc();
$managerBool = $arr["is_manager"];
if ($managerBool == 1) {
	header("Location: viewPaycheckManager.php");
	exit();
}
$fName = $arr["first_name"];
$lName = $arr["last_name"];
?>

<!DOCTYPE html>
<html>
<head>
	<title>View Paychecks</title>
	<link href="styles.css" type="text/css" rel="stylesheet">
</head>
<body>
	<div class="someDivs viewEntriesDiv">
		<img src="imgs/logoBlueRedoutline.png"><br>
		<b><?php echo $fName." ".$lName.", emp_id: ".$emp_id;?></b>
		<br><br>
		<div class="homeButton viewHomeButton">
	    	<a href="home.php"><img src="imgs/home.png" alt="home picture"><br>Home</a>
	   	</div>
	   	<br><br><br><br><br><br>
	   	<h2>Your Paychecks</h2><br><br>
		<table id="entriesTable"></table>
	</div>
</body>
</html>
<?php
$que = mysqli_query($con, " SELECT first_name, last_name, hours, pay_rate, hours*pay_rate AS pay, start_date, end_date
							FROM employee AS e, paycheck
							WHERE e.emp_id = paycheck.emp_id AND e.emp_id = $emp_id;");
	
if ($que->num_rows > 0) {
	echo '<script>';
	echo 'document.getElementById("entriesTable").innerHTML = "<tr><th><u>Name</u></th><th><u>Hours</u></th><th><u>Pay Rate</u></th><th><u>Total Pay</u></th><th><u>Start</u></th><th><u>End</u></th></tr>"; ';
	while($row = $que->fetch_assoc()) { 
		echo 'document.getElementById("entriesTable").innerHTML += "<tr><td>'.$row["first_name"].' '. $row["last_name"].'</td><td>'. $row["hours"].'</td><td>'. $row["pay_rate"].'</td><td>'. '$'.$row["pay"].'</td><td>'. $row["start_date"].'</td><td>'. $row["end_date"].'</td></tr>";';
	}
	echo '</script>';
}
else{
	echo '
		<script>
			document.getElementById("theOption").innerHTML += "<br><br>No Results"
		</script>
	'; 
}
mysqli_close($con);
?>