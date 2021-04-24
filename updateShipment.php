<?php 
require 'connectDB.php';
session_start();
if (!isset($_SESSION["emp_id"])) {
	header("Location: login.php");
	exit();
}
$emp_id = $_SESSION["emp_id"];
$nameQuery = mysqli_query($con, " SELECT first_name, last_name FROM employee WHERE emp_id = $emp_id ");
$arr = $nameQuery->fetch_assoc();
$fName = $arr["first_name"];
$lName = $arr["last_name"];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Update Shipment</title>
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
	   	<form id="theForm" action="" method="post">
		<fieldset>
			<legend>Enter New Shipment</legend>
			<strong>Delivery Company:</strong>
				<input type="text" name="company" size="40"><br><br>
			<strong>Arrival Date:</strong>
				<input type="text" name="theDate" size="40"><br><br>
			<strong>Item Count:</strong>
				<input type="text" name="count" size="40"><br><br>
			<div class="alignButtons">
				<input type="submit" value="Enter" name = "Enter">
			</div>
		</fieldset>
		<br><br>
		<fieldset>
			<legend>Delete Shipment Info</legend>
			<strong>Select Shipment:</strong>
				<select id = "optionsSelectDelete" name="optionsSelectDelete" class="optionSize"> 
					<?php
						$ship = mysqli_query($con, "SELECT shipment_id, arrival_date FROM shipment; ");
						if ($ship->num_rows > 0) {
							while($row = $ship->fetch_assoc()) { 
								echo '<option>Date: '.$row["arrival_date"].', ID:'.
								$row["shipment_id"].'</option>'; 
							}
						}
					?>
				</select><br><br>
			<div class="alignButtons">
				<input type="submit" value="Delete" name = "Delete">
			</div>
		</fieldset>
	</form>
	</div>
</body>
</html>
<?php
if(isset($_POST['Enter'])){
	if ( empty($_POST["company"]) || empty($_POST["theDate"]) || empty($_POST["count"]) ) { 
			echo 
			'<div class="errorMessage">
				<h3>Error Message:</h3>  
     			All fields must be filled.
     		</div>'; 
     		echo '<script>window.scrollTo(0,document.body.scrollHeight);</script>'; //scroll to bottom to show message
	}else{
		$company = $_POST["company"];
		$date = $_POST["theDate"];
		$count = $_POST["count"];
		
		$insert = mysqli_query($con, "INSERT INTO shipment(shipping_company_name, arrival_date, item_count) VALUES('$company', '$date', '$count')");
		if ($insert) {
			
     		echo '<script>
     				window.alert("Successfully Made Entry");
     				window.location.replace("updateShipment.php");
     			</script>'; 
     		
		} else{
		
     		echo '<script>
     				window.alert("Unable To Make Entry");
     				window.location.replace("updateShipment.php");
     			</script>';  
		}
	}

}
if(isset($_POST['Delete'])){
	$shipment = $_POST["optionsSelectDelete"];
	$ship_id = explode(':',$shipment)[2];
	//echo $shipment;
	//echo '   asdadaasd '.$ship_id;

	$delete = mysqli_query($con, "DELETE FROM shipment WHERE shipment_id = $ship_id");
	if ($delete) {
		
     	echo '<script>
     				window.alert("Successfully Deleted");
     				window.location.replace("updateShipment.php");
     			</script>';  
	} else {
		echo '<script>
     				window.alert("Unable To Delete");
     				window.location.replace("updateShipment.php");
     			</script>';
    }
}
?>