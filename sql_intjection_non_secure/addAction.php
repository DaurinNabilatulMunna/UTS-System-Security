<?php
session_start();

// Include the database connection file
require_once("dbConnection.php");

if (!isset($_SESSION['username'])) {
	header("Location: login.php");
	exit();
}

if (isset($_POST['submit'])) {
	$name = $_POST['name'];
	$nim = $_POST['nim'];
	$email = $_POST['email'];

	if (empty($name) || empty($nim) || empty($email)) {
		if (empty($name)) {
			echo "<font color='red'>Name field is empty.</font><br/>";
		}
		
		if (empty($nim)) {
			echo "<font color='red'>Aim field is empty.</font><br/>";
		}
		
		if (empty($email)) {
			echo "<font color='red'>Email field is empty.</font><br/>";
		}
		
		echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
	} else { 
		$result = mysqli_query($mysqli, "INSERT INTO employees_sql (`name`, `nim`, `email`) VALUES ('$name', '$nim', '$email')");
		
		if (!$result) {
    		echo "Error: " . mysqli_error($mysqli);
		} else {
    		echo "<div style='margin-top: 100px; padding: 20px; background-color: #d4edda; color: #155724; border-radius: 8px; text-align: center;'>
            	<p style='font-size: 18px; font-weight: bold;'>Data added successfully!</p>
            	<a href='index.php' style='display: inline-block; padding: 10px 20px; background-color: #28a745; color: white; border-radius: 4px; text-decoration: none; font-weight: bold; margin-top: 10px;'>View Result</a>
          		</div>";
		}
	}
}
?>
</body>
</html>
