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
	<title>View Purchases</title>
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
				<option>Display All Purchases</option>
				<option>Display Purchases By Employee</option>
				<option>Display Purchases By Customer</option>
			</select><br>
			<select id = "extraOption" name="extraOption"></select>
			<select id = "extraOption2" name="extraOption2"></select>
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
		if(inputText == "Display All Purchases"){
			document.getElementById("extraOption").style.display = "none";
			document.getElementById("extraOption2").style.display = "none";
		}
		else if(inputText == "Display Purchases By Employee"){
			document.getElementById("extraOption").style.display = "initial";
			document.getElementById("extraOption2").style.display = "none";
		} else {
			document.getElementById("extraOption2").style.display = "initial";
			document.getElementById("extraOption").style.display = "none";
		}
	}	
</script>


<?php
$emp = mysqli_query($con, "SELECT first_name, last_name, emp_id FROM employee; ");//all the distinct item types in inventory table
$cust = mysqli_query($con, "SELECT first_name, last_name, cust_id FROM customer; ");//all the distinct item types in inventory table
//appends types to select input in form
if ($emp->num_rows > 0) {
	echo '<script>';
	while($row = $emp->fetch_assoc()) { 
		echo 'document.getElementById("extraOption").innerHTML += "<option>'.$row["first_name"].' '.$row["last_name"].', ID:'.
		$row["emp_id"].'</option>";'; 
	}
	echo '</script>';
}
if ($cust->num_rows > 0) {
	echo '<script>';
	while($row = $cust->fetch_assoc()) { 
		echo 'document.getElementById("extraOption2").innerHTML += "<option>'.$row["first_name"].' '.$row["last_name"].', ID:'.
		$row["cust_id"].'</option>";'; 
	}
	echo '</script>';
}


if(isset($_POST['Enter'])){
	$optionSelected = $_POST["optionsSelect"];
	$emp_or_cust;
	$que;
	//shows the option you selected
	echo '
			<script>
				document.getElementById("theOption").style.display = "block";
				document.getElementById("theOption").innerHTML = "<h2>'; 

	if($optionSelected == 'Display All Purchases'){
		echo 'All Purchases';
		//sets the correct query for all inventory that hasnt been purchased
		$que = mysqli_query($con, " SELECT pi.group_id AS gid, e.first_name AS efn, e.last_name AS eln, e.emp_id AS eid, c.first_name AS cfn, c.last_name AS cln, c.cust_id AS cid, purchase_time, inv.item_type AS type, inv.item_model AS model, inv.price AS price
									FROM purchase_items AS pi, purchase_group AS g, customer AS c, employee AS e, inventory AS inv
									WHERE pi.group_id = g.group_id AND g.emp_id = e.emp_id AND g.cust_id = c.cust_id AND pi.inv_id = inv.inv_id
									ORDER BY g.group_id;");
	}elseif($optionSelected == "Display Purchases By Employee"){
		//echo 'HEREEEE';
		$emp_or_cust = $_POST["extraOption"];
		$emp_chosen = explode(':',$emp_or_cust)[1];
		echo 'Purchases Made With Employee: '.$emp_or_cust;
		$que = mysqli_query($con, "SELECT pi.group_id AS gid, e.first_name AS efn, e.last_name AS eln, e.emp_id AS eid, c.first_name AS cfn, c.last_name AS cln, c.cust_id AS cid, purchase_time, inv.item_type AS type, inv.item_model AS model, inv.price AS price
									FROM purchase_items AS pi, purchase_group AS g, customer AS c, employee AS e, inventory AS inv
									WHERE pi.group_id = g.group_id AND g.emp_id = e.emp_id AND g.cust_id = c.cust_id AND pi.inv_id = inv.inv_id
									AND g.emp_id = $emp_chosen
									ORDER BY g.group_id;");
	} else{
		$emp_or_cust = $_POST["extraOption2"];
		$cust_chosen = explode(':',$emp_or_cust)[1];
		echo 'Purchases Made With Customer: '.$emp_or_cust;
		$que = mysqli_query($con, "SELECT pi.group_id AS gid, e.first_name AS efn, e.last_name AS eln, e.emp_id AS eid, c.first_name AS cfn, c.last_name AS cln, c.cust_id AS cid, purchase_time, inv.item_type AS type, inv.item_model AS model, inv.price AS price
									FROM purchase_items AS pi, purchase_group AS g, customer AS c, employee AS e, inventory AS inv
									WHERE pi.group_id = g.group_id AND g.emp_id = e.emp_id AND g.cust_id = c.cust_id AND pi.inv_id = inv.inv_id
									AND g.cust_id = $cust_chosen
									ORDER BY g.group_id;");
	}
	echo '</h2>"</script>'; 




	//filling table
	if ($que->num_rows > 0) {
		echo '<script>';
		echo 'document.getElementById("entriesTable").innerHTML = "<tr><th><u>Purchase Group</u></th><th><u>Employee</u></th><th><u>Customer</u></th><th><u>Time</u></th><th><u>Item</u></th><th><u>Price</u></th></tr>"; ';
		while($row = $que->fetch_assoc()) { 
			echo 'document.getElementById("entriesTable").innerHTML += "<tr><td>'.$row["gid"].'</td><td>'. $row["efn"].' '. $row["eln"].'</td><td>'. $row["cfn"].' '.$row["cln"]. '</td><td>'. $row["purchase_time"].'</td><td>'. $row["type"].': '.$row["model"].'</td><td>'. '$'.$row["price"].'</td></tr>";';
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