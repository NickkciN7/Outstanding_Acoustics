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
	<title>Update Paycheck</title>
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
			<legend>Enter New Paycheck</legend>
			<strong>Employee:</strong>
				<select id = "optionsSelectEmployee" name="optionsSelectEmployee" class="optionSize"> 
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
			<strong>Start Date(yyyy-mm-dd):</strong>
				<input type="text" name="sdate" size="40"><br><br>
			<strong>End Date(yyyy-mm-dd):</strong>
				<input type="text" name="edate" size="40"><br><br>
			<strong>Hours:</strong>
				<input type="text" name="hours" size="40" ><br><br>
			<strong>Pay Rate:</strong>
				<input type="text" name="rate" size="40"><br><br>
			<div class="alignButtons">
				<input type="submit" value="Enter" name = "Enter">
			</div>
		</fieldset>
		<br><br>
		<fieldset>
			<legend>Delete Paycheck Info</legend>
			<strong>Select Paycheck:</strong>
				<select id = "optionsSelectDelete" name="optionsSelectDelete" class="optionSize"> 
					<?php
						$check = mysqli_query($con, "SELECT check_id, start_date FROM paycheck; ");
						if ($check->num_rows > 0) {
							while($row = $check->fetch_assoc()) { 
								echo '<option>Start Date: '.$row["start_date"].', ID:'.
								$row["check_id"].'</option>'; 
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
	if ( empty($_POST["sdate"]) || empty($_POST["edate"]) || empty($_POST["hours"]) || empty($_POST["rate"]) ) { 
			echo 
			'<div class="errorMessage">
				<h3>Error Message:</h3>  
     			All fields must be filled.
     		</div>'; 
     		echo '<script>window.scrollTo(0,document.body.scrollHeight);</script>'; //scroll to bottom to show message
	}else{
		$sdate = $_POST["sdate"];
		$edate = $_POST["edate"];
		$hours = $_POST["hours"];
		$rate = $_POST["rate"];
		
		$employee = $_POST["optionsSelectEmployee"];
		$chosen_emp = explode(':',$employee)[1];

		$insert = mysqli_query($con, "INSERT INTO paycheck(emp_id, start_date, end_date, hours, pay_rate) VALUES('$chosen_emp', '$sdate', '$edate', '$hours', '$rate')");
		if ($insert) {
			
     		echo '<script>
     				window.alert("Successfully Made Entry");
     				window.location.replace("updatePaycheck.php");
     			</script>'; 
     		
		} else{
		
     		echo '<script>
     				window.alert("Unable To Make Entry");
     				window.location.replace("updatePaycheck.php");
     			</script>';  
		}
	}

}
if(isset($_POST['Delete'])){
	$check = $_POST["optionsSelectDelete"];
	$check_id = explode(':',$check)[2];
	//echo $check;
	//echo '   asdadaasd '.$check_id;
	
	$delete = mysqli_query($con, "DELETE FROM paycheck WHERE check_id = $check_id");
	if ($delete) {
		
     	echo '<script>
     				window.alert("Successfully Deleted");
     				window.location.replace("updatePaycheck.php");
     			</script>';  
	} else {
		echo '<script>
     				window.alert("Unable To Delete");
     				window.location.replace("updatePaycheck.php");
     			</script>';
    }

    
}
?>