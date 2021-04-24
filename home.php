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
mysqli_close($con);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Home Page</title>
	<link href="styles.css" type="text/css" rel="stylesheet">
	<script>
		
		function view(){
			window.location.href = "viewEntries.php";
		}
		
		function update(){
			window.location.href = "updateEntries.php";
		}
		
		function purchase(){
			window.location.href = "makePurchase.php";
		}

	</script>
</head>
<body>
	<div class="someDivs home">
		<img src="imgs/logoBlueRedoutline.png"><br>
		<b><?php echo $fName." ".$lName.", emp_id: ".$emp_id;?></b>
		<br><br><br><br><br><br>
		Please Select an option below<br><br><br>
		<button onclick="view()">View Store Information</button><br><br>
		<button onclick="update()">Update Store Information</button><br><br>
		<button onclick="purchase()">Make Purchase</button><br><br><br><br><br><br>
		<form action="" method="post">
			<input type="submit" value="Sign Out" name = "signout">
		</form>
	</div>
</body>
</html>

<?php
	//unsets session variable and returns to login/signup page. without the session variable userID these pages won't run
	if(isset($_POST['signout'])){
		unset($_SESSION['emp_id']);
		header("Location: login.php");
    	exit();
	}
?>
