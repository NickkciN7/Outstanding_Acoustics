<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link href="styles.css" type="text/css" rel="stylesheet">
</head>
<body>
	<form action="" method="post">
		<fieldset>
			<legend>Login</legend>
			<strong>ENTER EMPLOYEE PIN:</strong>
				<input type="text" name="pin" size="20"><br><br>
			<div class="alignButtons">
				<input type="submit" value="Login" name = "Login">
			</div>
		</fieldset>
	</form>
	<br><br><br>

</body>
</html>

<?php
	require 'connectDB.php';
	session_start();

	if(isset($_POST['Login'])){
		//echo "Login pressed<br>";
		if ( empty($_POST["pin"]) ) { 
			echo 
			'<div class="errorMessage">
				<h3>Error Message:</h3>  
     			Pin number must be entered.
     		</div>'; 
		}
		else{
			$pin = $_POST["pin"];
			
			$credentialsCheck = mysqli_query($con, "SELECT emp_id FROM employee WHERE emp_pin = '$pin' ");
			//if rows returned is 0, means that no such employee exists and you cannot sign in
			if ($credentialsCheck->num_rows == 0){
				echo 
				'<div class="errorMessage">
					<h3>Error Message:</h3>  
	     			There is no Employee with this PIN number.
	     		</div>'; 
			}
			else{
				//query credentialsCheck returns the emp_id so set the emp_id to session variable
				$_SESSION["emp_id"] = $credentialsCheck->fetch_assoc()["emp_id"];
				
				mysqli_close($con);
				header("Location: home.php");
    			exit();
				//echo 'emp_id: '.$_SESSION["emp_id"];
			}
		}
	}
?>
