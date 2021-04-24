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
$fName = $arr["first_name"];
$lName = $arr["last_name"];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Update Store Information</title>
	<link href="styles.css" type="text/css" rel="stylesheet">
	<script>
		
		function customer(){
			window.location.href = "updateCustomer.php";
		}
		
		function lesson(){
			window.location.href = "updateLesson.php";
		}
		
		function employee(){
			window.location.href = "updateEmployee.php";
		}

		function paycheck(){
			window.location.href = "updatePaycheck.php";
		}

		function inventory(){
			window.location.href = "updateInventory.php";
		}

		function purchase(){
			window.location.href = "updatePurchase.php";
		}

		function shipment(){
			window.location.href = "updateShipment.php";
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
		<button onclick="customer()">Update Customers</button><br><br>
		<button onclick="lesson()">Update Lessons</button><br><br>
		<button onclick="inventory()">Update Inventory</button><br><br>
		<button onclick="shipment()">Update Shipments</button><br><br>

		<?php
			if ($managerBool == 1) {
				echo 'Manager Options: <br>';
				echo '<button onclick="employee()">Update Employees</button><br><br>
				<button onclick="paycheck()">Update Paychecks</button><br><br>';
			}
		?>
	</div>
</body>
</html>

<?php
	
?>
