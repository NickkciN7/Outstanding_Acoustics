<?php 
require 'connectDB.php';
session_start();
if (!isset($_SESSION["emp_id"])) {
	header("Location: login.php");
	exit();
}
$emp_id = $_SESSION["emp_id"];
$emp_id = $_SESSION["emp_id"];
$nameQuery = mysqli_query($con, " SELECT first_name, last_name FROM employee WHERE emp_id = $emp_id ");
$arr = $nameQuery->fetch_assoc();
$fName = $arr["first_name"];
$lName = $arr["last_name"];
?>

<!DOCTYPE html>
<html>
<head>
	<title>View Entries</title>
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
	   	<h2>Lessons</h2><br><br>
		<table id="entriesTable"></table>
	</div>
</body>
</html>
<?php
$que = mysqli_query($con, "SELECT e.first_name AS efn, e.last_name AS eln, c.first_name AS cfn , c.last_name AS cln, l.instrument AS inst, l.start_time AS datet, l.duration AS dur, l.lesson_id AS id
FROM customer AS c, employee AS e, lesson AS l
WHERE l.emp_id = e.emp_id AND l.cust_id = c.cust_id;");
	
if ($que->num_rows > 0) {
	echo '<script>';
	echo 'document.getElementById("entriesTable").innerHTML = "<tr><th><u>Lesson ID</u></th><th><u>Teacher</u></th><th><u>Student</u></th><th><u>Instrument</u></th><th><u>Date</u></th><th><u>Duration(hours)</u></th></tr>"; ';
	while($row = $que->fetch_assoc()) { 
		echo 'document.getElementById("entriesTable").innerHTML += "<tr><td>'.$row["id"].'</td><td>'.$row["efn"].' '.$row["eln"].'</td><td>'. $row["cfn"].' '.$row["cln"].'</td><td>'. $row["inst"].'</td><td>'. $row["datet"].'</td><td>'. $row["dur"].'</tr>";';
	}
	echo '</script>';
}
else{
	echo '
		<script>
			document.getElementById("theOption").innerHTML += "<br><br>No Results"
		</script>
	'; 
}
mysqli_close($con);
?>