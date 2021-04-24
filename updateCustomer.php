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
	<title>Update Customers</title>
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
			<legend>Enter New Customer</legend>
			<strong>First Name:</strong>
				<input type="text" name="fname" size="20"><br><br>
			<strong>Last Name:</strong>
				<input type="text" name="lname" size="20"><br><br>
			<strong>Email:</strong>
				<input type="text" name="email" size="20"><br><br>
			<strong>Phone Number:</strong>
				<input type="text" name="pnumber" size="20"><br><br>
			<div class="alignButtons">
				<input type="submit" value="Enter" name = "Enter">
			</div>
		</fieldset>
		<br><br>
		<fieldset>
			<legend>Delete Customer Information</legend>
			<strong>Select Customer:</strong>
				<select id = "optionsSelectDelete" name="optionsSelectDelete" class="optionSize"> 
					<?php
						$cust = mysqli_query($con, "SELECT first_name, last_name, cust_id FROM customer; ");
						if ($cust->num_rows > 0) {
							while($row = $cust->fetch_assoc()) { 
								echo '<option>'.$row["first_name"].' '.$row["last_name"].', ID:'.
								$row["cust_id"].'</option>'; 
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
	if ( empty($_POST["fname"]) || empty($_POST["lname"]) || empty($_POST["email"]) || empty($_POST["pnumber"])) { 
			echo 
			'<div class="errorMessage">
				<h3>Error Message:</h3>  
     			All fields must be filled.
     		</div>'; 
     		echo '<script>window.scrollTo(0,document.body.scrollHeight);</script>'; //scroll to bottom to show message
	}else{
		$fname = $_POST["fname"];
		$lname = $_POST["lname"];
		$email = $_POST["email"];
		$pnumber = $_POST["pnumber"];

		$insert = mysqli_query($con, "INSERT INTO customer(emp_id, first_name, last_name, email, phone_number) VALUES('$emp_id', '$fname', '$lname', '$email', '$pnumber')");
		if ($insert) {
			
     		echo '<script>
     				window.alert("Successfully Made Entry");
     				window.location.replace("updateCustomer.php");
     			</script>'; 
     		
		} else{
		
     		echo '<script>
     				window.alert("Unable To Make Entry");
     				window.location.replace("updateCustomer.php");
     			</script>';  
		}
	}

}
if(isset($_POST['Delete'])){
	$customer = $_POST["optionsSelectDelete"];
	$cust_id = explode(':',$customer)[1];
	echo $customer;
	echo '   '.$cust_id;

	$delete = mysqli_query($con, "DELETE FROM customer WHERE cust_id = $cust_id");
	if ($delete) {
		
     	echo '<script>
     				window.alert("Successfully Deleted");
     				window.location.replace("updateCustomer.php");
     			</script>';  
	} else {
		echo '<script>
     				window.alert("Unable To Delete");
     				window.location.replace("updateCustomer.php");
     			</script>'; 
	}
}
?>