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
	<title>Update Inventory</title>
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
			<legend>Enter New Item</legend>
			<strong>Shipment:</strong>
				<select id = "optionsSelectShipment" name="optionsSelectShipment" class="optionSize"> 
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
			<strong>Item Type:</strong>
				<input type="text" name="type" size="40"><br><br>
			<strong>Item Model:</strong>
				<input type="text" name="model" size="40"><br><br>
			<strong>Item Company:</strong>
				<input type="text" name="company" size="40"><br><br>
			<strong>Price:</strong>
				<input type="text" name="price" size="40"><br><br>
			<div class="alignButtons">
				<input type="submit" value="Enter" name = "Enter">
			</div>
		</fieldset>
		<br><br>
		<fieldset>
			<legend>Delete Item</legend>
			<strong>Select Item:</strong>
				<select id = "optionsSelectDelete" name="optionsSelectDelete" class="optionSize"> 
					<?php
						$inventory = mysqli_query($con, "SELECT * 
														FROM inventory
														WHERE inv_id NOT IN(
																		 SELECT inv_id FROM purchase_items
																		 );");
						if ($inventory->num_rows > 0) {
							while($row = $inventory->fetch_assoc()) { 
								echo '<option>'.$row["item_model"].' '.$row["item_type"].', ID:'.
								$row["inv_id"].'</option>'; 
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
	if ( empty($_POST["type"]) || empty($_POST["model"]) || empty($_POST["company"])|| empty($_POST["price"]) ) { 
			echo 
			'<div class="errorMessage">
				<h3>Error Message:</h3>  
     			All fields must be filled.
     		</div>'; 
     		echo '<script>window.scrollTo(0,document.body.scrollHeight);</script>'; //scroll to bottom to show message
	}else{
		$type = $_POST["type"];
		$model = $_POST["model"];
		$company = $_POST["company"];
		$price = $_POST["price"];
		
		$shipment = $_POST["optionsSelectShipment"];
		$ship_id = explode(':',$shipment)[2];

		$insert = mysqli_query($con, "INSERT INTO inventory(shipment_id, emp_id, item_type, item_model, item_company, price) VALUES('$ship_id', '$emp_id', '$type', '$model', '$company', '$price')");
		if ($insert) {
			
     		echo '<script>
     				window.alert("Successfully Made Entry");
     				window.location.replace("updateInventory.php");
     			</script>'; 
     		
		} else{
		
     		echo '<script>
     				window.alert("Unable To Make Entry");
     				window.location.replace("updateInventory.php");
     			</script>';  
		}
	}

}
if(isset($_POST['Delete'])){
	$inventory = $_POST["optionsSelectDelete"];
	$inv_id = explode(':',$inventory)[1];
	//echo $inventory;
	//echo '   asdadaasd '.$inv_id;

	$delete = mysqli_query($con, "DELETE FROM inventory WHERE inv_id = $inv_id");
	if ($delete) {
		
     	echo '<script>
     				window.alert("Successfully Deleted");
     				window.location.replace("updateInventory.php");
     			</script>';  
	} else {
		echo '<script>
     				window.alert("Unable To Delete");
     				window.location.replace("updateInventory.php");
     			</script>'; 
	}
}
?>