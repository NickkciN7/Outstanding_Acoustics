<?php 
require 'connectDB.php';
session_start();
if (!isset($_SESSION["emp_id"])) {
	header("Location: login.php");
	exit();
}
$emp_id = $_SESSION["emp_id"];
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
	<title>View Inventory</title>
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
	   	<br><br><br><br><br>
	   	Please Select an option below<br><br>
	
		<form action="" method="post">
			<select id = "optionsSelect" name="optionsSelect"> 
				<option>Display All Inventory</option>
				<option>Display Inventory By Item Type</option>
			</select><br>
			<select id = "extraOption" name="extraOption"></select>
			<br><br>
			<input type="submit" value="Enter" name = "Enter">
		</form>
	   	<br><br><br><br>
	   	<div id="theOption"></div><br><br>
		<table id="entriesTable"></table>
	</div>
</body>
</html>


<script>
	//for showing item type option

	document.getElementById('optionsSelect').onchange = function() {
		var index = this.selectedIndex;
		var inputText = this.children[index].innerHTML.trim();
		//only show types if user selects option display by item type
		if(inputText == "Display Inventory By Item Type"){
			document.getElementById("extraOption").style.display = "initial";
		}
		else{
			document.getElementById("extraOption").style.display = "none";
		}
	}	
</script>


<?php
$types = mysqli_query($con, "SELECT DISTINCT item_type FROM inventory");//all the distinct item types in inventory table

//appends types to select input in form
if ($types->num_rows > 0) {
	echo '<script>';
	while($row = $types->fetch_assoc()) { 
		echo 'document.getElementById("extraOption").innerHTML += "<option>'.$row["item_type"].'</option>";'; 
	}
	echo '</script>';
}



if(isset($_POST['Enter'])){
	$optionSelected = $_POST["optionsSelect"];
	$typeOption;
	$que;
	//shows the option you selected
	echo '
			<script>
				document.getElementById("theOption").style.display = "block";
				document.getElementById("theOption").innerHTML = "<h2>'; 

	if($optionSelected == 'Display All Inventory'){
		echo 'All Inventory';
		//sets the correct query for all inventory that hasnt been purchased
		$que = mysqli_query($con, " SELECT * 
									FROM inventory
									WHERE inv_id NOT IN(
													 SELECT inv_id FROM purchase_items
													 );");
	}else{
		$typeOption = $_POST["extraOption"];

		echo 'Inventory By Type: '.$typeOption;
		$que = mysqli_query($con, "SELECT * FROM inventory
									WHERE item_type = '$typeOption' AND 
									inv_id NOT IN(
											   SELECT inv_id FROM purchase_items
											   );");
	}
	echo '</h2>"</script>'; 




	//filling table
	if ($que->num_rows > 0) {
		echo '<script>';
		echo 'document.getElementById("entriesTable").innerHTML = "<tr><th><u>Inventory ID</u></th><th><u>Shipment Number</u></th><th><u>Type</u></th><th><u>Model</u></th><th><u>Company</u></th><th><u>Price</u></th></tr>"; ';
		while($row = $que->fetch_assoc()) { 
			echo 'document.getElementById("entriesTable").innerHTML += "<tr><td>'.$row["inv_id"].'</td><td>'.$row["shipment_id"].'</td><td>'. $row["item_type"].'</td><td>'. $row["item_model"].'</td><td>'. $row["item_company"].'</td><td>'. '$'.$row["price"].'</td></tr>";';
		}
		echo '</script>';
	} else {
		echo '
			<script>
				document.getElementById("theOption").innerHTML += "<br><br>No Results"
			</script>
		'; 
	}
}


?>