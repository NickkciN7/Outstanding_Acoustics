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
mysqli_close($con);

?>

<!DOCTYPE html>
<html>
<head>
	<title>View Store Information</title>
	<link href="styles.css" type="text/css" rel="stylesheet">
	<script>
		
		function customer(){
			window.location.href = "viewCustomer.php";
		}
		
		function lesson(){
			window.location.href = "viewLesson.php";
		}
		
		function employee(){
			window.location.href = "viewEmployee.php";
		}

		function paycheck(){
			window.location.href = "viewPaycheck.php";
		}

		function inventory(){
			window.location.href = "viewInventory.php";
		}

		function purchase(){
			window.location.href = "viewPurchase.php";
		}

		function shipment(){
			window.location.href = "viewShipment.php";
		}

	</script>
</head>
<body>
	<div class="someDivs home">
		<img src="imgs/logoBlueRedoutline.png"><br>
		<b><?php echo $fName." ".$lName.", emp_id: ".$emp_id;?></b>
		<br><br>
		<div class="homeButton viewHomeButton">
	    	<a href="home.php"><img src="imgs/home.png" alt="home picture"><br>Home</a>
	   	</div>
		<br><br><br><br><br><br>
		Please Select an option below<br><br><br>
		<button onclick="customer()">View Customers</button><br><br>
		<button onclick="lesson()">View Lessons</button><br><br>
		<button onclick="employee()">View Employees</button><br><br>
		<button onclick="paycheck()">View Paychecks</button><br><br>
		<button onclick="inventory()">View Inventory</button><br><br>
		<button onclick="purchase()">View Purchases</button><br><br>
		<button onclick="shipment()">View Shipments</button><br><br>
		<br><br><br><br>
	</div>
</body>
</html>

<?php
	
?>
