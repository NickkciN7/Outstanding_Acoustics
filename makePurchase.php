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
	<title>Make Purchase</title>
	<link href="styles.css" type="text/css" rel="stylesheet">
	<script type="text/javascript">
		var items_sum = 0;
		var countItems = 0.0;
		function addToList(){
			//get item chosen
			countItems++;
			var selectOption = document.getElementById("optionsSelectItem");
			var item = selectOption.value;
			//remove that item from options once selected
			for (var i=0; i<selectOption.length; i++) {
			    if (selectOption.options[i].value == item)
			        selectOption.remove(i);
			}
			

			//split by comma into array to focus on price and id
			var itemSplit = item.split(",");
			//3rd index is price, split by :, 1 index is actual number, substring to get rid of $ sign
			var price  = itemSplit[3].split(":")[1].substring(1);
			//add to total
			items_sum += parseFloat(price);
		
			document.getElementById("total").innerHTML = "Number of Items: "+countItems+"<br>Total Price: $"+items_sum ;

			//id is 4th index, and after the colon
			var curr_id = itemSplit[4].split(":")[1];
			
			//add id to hidden object(will be used to add to purchase group/item table in database)
			var hiddentObject = document.getElementById("hiddenIDS");
			hiddentObject.value += curr_id +",";
			//console.log(hiddentObject.value);
			//console.log(item_ids);


			//print out the item selected below for reference
			document.getElementById("items").innerHTML += item;
			document.getElementById("items").innerHTML += "<br>";
			//return false;
		}
	</script>
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
				<legend>Add Item To Purchase</legend><br>
				<strong class="strongPurchase">Customer:</strong><br>
				<select id = "optionsSelectStudent" name="optionsSelectStudent" class="optionSize"> 
					<?php
						$cust = mysqli_query($con, "SELECT first_name, last_name, cust_id FROM customer; ");
						if ($cust->num_rows > 0) {
							while($row = $cust->fetch_assoc()) { 
								echo '<option>'.$row["first_name"].' '.$row["last_name"].', ID:'.
								$row["cust_id"].'</option>'; 
							}
						}
					?>
				</select><br><br><br><br>
				<strong class="strongPurchase">Item:</strong><br>
					<select id = "optionsSelectItem" name="optionsSelectItem" class="optionSizePurchase"> 
						<?php
							$inventory = mysqli_query($con, "SELECT * 
															FROM inventory
															WHERE inv_id NOT IN(
																			 SELECT inv_id FROM purchase_items
																			 );");
							if ($inventory->num_rows > 0) {
								while($row = $inventory->fetch_assoc()) { 
									echo '<option>Type:'.$row["item_type"].', Model:'.$row["item_model"].', Company:'.$row["item_company"].', Price:$'.$row["price"].', ID:'.$row["inv_id"].'</option>'; 
								}
							}
						?>
					</select><br><br>
				<button type="button" class="addButton" onclick="addToList()">Add</button><br><br>
			</fieldset>
			<br><br>
			<div id="items">
			</div>
			<br><br>
			<div id="total">
				Number of Items: 0<br>
				Total: $0
			</div>
			<input type="hidden" name="hiddenIDS" id="hiddenIDS" value = "">
			<div class="alignButtons">
				<input type="submit" value="Make Purchase" name = "Enter">
			</div>
		</form>
	</div>
</body>
</html>
<?php
if(isset($_POST['Enter'])){
	if ( empty($_POST["hiddenIDS"]) ) { 
			echo 
			'<div class="errorMessage">
				<h3>Error Message:</h3>  
     			Choose At least One Item.
     		</div>'; 
     		echo '<script>window.scrollTo(0,document.body.scrollHeight);</script>'; //scroll to bottom to show message
	}else{
		$customer = $_POST["optionsSelectStudent"];
		$cust_id = explode(':',$customer)[1];
		
		
		$ids = $_POST["hiddenIDS"];
		$ids_split = explode(',',$ids);

		date_default_timezone_set('America/New_York');
		$date = date('Y-m-d H:i:s');
		
		//print_r($ids_split);

		//make purchaseGroup
		$insertGroup = mysqli_query($con, "INSERT INTO purchase_group(emp_id, cust_id, purchase_time) VALUES('$emp_id', '$cust_id', '$date')");
		$groupID = mysqli_insert_id($con);
		//echo 'asdasdas '.count($ids_split);
		$arrayInsertion = true; //boolean
		for ($i = 0; $i < count($ids_split)-1; $i++) {
			$curr_id = $ids_split[$i];
			$insertPurchaseItem = mysqli_query($con, "INSERT INTO purchase_items(group_id, inv_id) VALUES('$groupID', '$curr_id')");
			if(!$insertPurchaseItem){
				$arrayInsertion = false;
				break;
			}
		}

		if ($insertGroup && $arrayInsertion) {
     		echo '<script>
     				window.alert("Successfully Made Purchase");
     				window.location.replace("makePurchase.php");
     			</script>'; 
     		
		} else{
		
     		echo '<script>
     				window.alert("Unable To Make Purchase");
     				window.location.replace("makePurchase.php");
     			</script>';  
		}
	}

}

?>