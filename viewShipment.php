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
	<title>View Shipments</title>
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
	   	<h2>Shipments</h2><br><br>
		<table id="entriesTable"></table>
	</div>
</body>
</html>
<?php
$que = mysqli_query($con, "SELECT * FROM shipment;");
	
if ($que->num_rows > 0) {
	echo '<script>';
	echo 'document.getElementById("entriesTable").innerHTML = "<tr><th><u>Shipment ID</u></th><th><u>Delivery Company</u></th><th><u>Arrival Date</u></th><th><u>Item Count</u></th></tr>"; ';
	while($row = $que->fetch_assoc()) { 
		echo 'document.getElementById("entriesTable").innerHTML += "<tr><td>'.$row["shipment_id"] .'</td><td>'. $row["shipping_company_name"].'</td><td>'. $row["arrival_date"].'</td><td>'. $row["item_count"].'</td></tr>";';
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