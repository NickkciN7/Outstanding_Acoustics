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
if ($managerBool == 0) {
	header("Location: updateEntries.php");
	exit();
}
$fName = $arr["first_name"];
$lName = $arr["last_name"];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Update Employee</title>
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
			<legend>Enter New Employee</legend>
			<strong>First Name:</strong>
				<input type="text" name="fname" size="20"><br><br>
			<strong>Last Name:</strong>
				<input type="text" name="lname" size="20"><br><br>
			<strong>Gender:</strong>
				<input type="text" name="gender" size="40" maxlength="1"><br><br>
			<strong>Pin Number:</strong>
				<input type="text" name="pin" size="40"><br><br>
			<strong>Address:</strong>
				<input type="text" name="address" size="40"><br><br>
			<strong>City:</strong>
				<input type="text" name="city" size="40"><br><br>
			<strong>Hire Date(yyyy-mm-dd):</strong>
				<input type="text" name="hire_date" size="40"><br><br>
			<div class="alignButtons">
				<input type="submit" value="Enter" name = "Enter">
			</div>
		</fieldset>
		<br><br>
		<fieldset>
			<legend>Delete Employee Info</legend>
			<strong>Select Employee:</strong>
				<select id = "optionsSelectDelete" name="optionsSelectDelete" class="optionSize"> 
					<?php
						$emp = mysqli_query($con, "SELECT first_name, last_name, emp_id FROM employee; ");
						if ($emp->num_rows > 0) {
							while($row = $emp->fetch_assoc()) { 
								echo '<option>'.$row["first_name"].' '.$row["last_name"].', ID:'.
								$row["emp_id"].'</option>'; 
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
	if ( empty($_POST["fname"]) || empty($_POST["lname"]) || empty($_POST["gender"]) || empty($_POST["pin"]) || empty($_POST["address"])|| empty($_POST["city"])|| empty($_POST["hire_date"]) ) { 
			echo 
			'<div class="errorMessage">
				<h3>Error Message:</h3>  
     			All fields must be filled.
     		</div>'; 
     		echo '<script>window.scrollTo(0,document.body.scrollHeight);</script>'; //scroll to bottom to show message
	}else{
		$fname = $_POST["fname"];
		$lname = $_POST["lname"];
		$gender = $_POST["gender"];
		$pin = $_POST["pin"];
		$address = $_POST["address"];
		$city = $_POST["city"];
		$hire_date = $_POST["hire_date"];
		
		$insert = mysqli_query($con, "INSERT INTO employee(first_name, last_name, gender, emp_pin, address, city, hired_date, is_manager) VALUES('$fname', '$lname', '$gender', '$pin', '$address', '$city', '$hire_date', '0')");
		if ($insert) {
			
     		echo '<script>
     				window.alert("Successfully Made Entry");
     				window.location.replace("updateEmployee.php");
     			</script>'; 
     		
		} else{
		
     		echo '<script>
     				window.alert("Unable To Make Entry");
     				window.location.replace("updateEmployee.php");
     			</script>';  
		}
	}

}
if(isset($_POST['Delete'])){
	$employee = $_POST["optionsSelectDelete"];
	$chosen_emp = explode(':',$employee)[1];
	//echo $employee;
	//echo '   asdadaasd '.$chosen_emp;

	$delete = mysqli_query($con, "DELETE FROM employee WHERE emp_id = $chosen_emp");
	if ($delete) {
		
     	echo '<script>
     				window.alert("Successfully Deleted");
     				window.location.replace("updateEmployee.php");
     			</script>';  
	} else {
		echo '<script>
     				window.alert("Unable To Delete");
     				window.location.replace("updateEmployee.php");
     			</script>';
    }
}
?>