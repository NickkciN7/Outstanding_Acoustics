<?php 
require 'connectDB.php';
session_start();
if (!isset($_SESSION["emp_id"])) {
	header("Location: login.php");
	exit();
}
$emp_id = $_SESSION["emp_id"];
$emp_id = $_SESSION["emp_id"];
$nameQuery = mysqli_query($con, " SELECT first_name, last_name FROM employee WHERE emp_id = $emp_id ");
$arr = $nameQuery->fetch_assoc();
$fName = $arr["first_name"];
$lName = $arr["last_name"];
?>

<!DOCTYPE html>
<html>
<head>
	<title>View Entries</title>
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
	   	<h2>Customers</h2><br><br>
		<table id="entriesTable"></table>
	</div>
</body>
</html>
<?php
$que = mysqli_query($con, "SELECT * FROM customer;");
	
if ($que->num_rows > 0) {
	echo '<script>';
	echo 'document.getElementById("entriesTable").innerHTML = "<tr><th><u>Customer ID</u></th><th><u>First Name</u></th><th><u>Last Name</u></th><th><u>Email</u></th><th><u>Phone Number</u></th></tr>"; ';
	while($row = $que->fetch_assoc()) { 
		echo 'document.getElementById("entriesTable").innerHTML += "<tr><td>'.$row["cust_id"] .'</td><td>'.$row["first_name"] .'</td><td>'. $row["last_name"].'</td><td>'. $row["email"].'</td><td>'. $row["phone_number"].'</td></tr>";';
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