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
	<title>Update Lessons</title>
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
			<legend>Enter New Lesson</legend>
			<strong>Teacher:</strong>
				<select id = "optionsSelectTeacher" name="optionsSelectTeacher" class="optionSize"> 
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
			<strong>Student:</strong>
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
				</select><br><br>
			<strong>Instrument:</strong>
				<input type="text" name="instrument" size="40"><br><br>
			<strong>Time(yyyy-mm-dd hh:mm:ss):</strong>
				<input type="text" name="time" size="40"><br><br><br>
			<strong>Duration(hours)</strong>
				<input type="text" name="duration" size="40"><br><br>
			<div class="alignButtons">
				<input type="submit" value="Enter" name = "Enter">
			</div>
		</fieldset>
		<br><br>
		<fieldset>
			<legend>Delete Lesson</legend>
			<strong>Select Lesson:</strong>
				<select id = "optionsSelectDelete" name="optionsSelectDelete" class="optionSize"> 
					<?php
						$lesson = mysqli_query($con, "SELECT lesson_id, start_time FROM lesson; ");
						if ($lesson->num_rows > 0) {
							while($row = $lesson->fetch_assoc()) { 
								echo '<option>'.$row["start_time"].', ID:'.
								$row["lesson_id"].'</option>'; 
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
	if ( empty($_POST["instrument"]) || empty($_POST["time"]) || empty($_POST["duration"]) ) { 
			echo 
			'<div class="errorMessage">
				<h3>Error Message:</h3>  
     			All fields must be filled.
     		</div>'; 
     		echo '<script>window.scrollTo(0,document.body.scrollHeight);</script>'; //scroll to bottom to show message
	}else{
		$instrument = $_POST["instrument"];
		$time = $_POST["time"];
		$duration = $_POST["duration"];
		
		$employee = $_POST["optionsSelectTeacher"];
		$chosen_emp = explode(':',$employee)[1];

		$customer = $_POST["optionsSelectStudent"];
		$cust_id = explode(':',$customer)[1];

		$insert = mysqli_query($con, "INSERT INTO lesson(emp_id, cust_id, instrument, start_time, duration) VALUES('$chosen_emp', '$cust_id', '$instrument', '$time', '$duration')");
		if ($insert) {
			
     		echo '<script>
     				window.alert("Successfully Made Entry");
     				window.location.replace("updateLesson.php");
     			</script>'; 
     		
		} else{
		
     		echo '<script>
     				window.alert("Unable To Make Entry");
     				window.location.replace("updateLesson.php");
     			</script>';  
		}
	}

}
if(isset($_POST['Delete'])){
	$lesson = $_POST["optionsSelectDelete"];
	$lesson_id = explode(':',$lesson)[3];
	//echo $lesson;
	//echo '   asdadaasd '.$lesson_id;

	$delete = mysqli_query($con, "DELETE FROM lesson WHERE lesson_id = $lesson_id");
	if ($delete) {
		
     	echo '<script>
     				window.alert("Successfully Deleted");
     				window.location.replace("updateLesson.php");
     			</script>';  
	} else {
		echo '<script>
     				window.alert("Unable To Delete");
     				window.location.replace("updateLesson.php");
     			</script>'; 
	}
}
?>