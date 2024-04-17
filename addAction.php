<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Include the database connection file
require_once("dbConnection.php");

if (!isset($_SESSION['username'])) {
	header("Location: login.php");
	exit();
}

if (isset($_POST['submit'])) {
	//mysqli_real_escape_string() digunakan untuk melindungi dari serangan SQL injection.
	// htmlspecialchars() digunakan untuk melindungi dari serangan cross-site scripting (XSS).
	$name = htmlspecialchars(mysqli_real_escape_string($mysqli, $_POST['name']));
	$nim = htmlspecialchars(mysqli_real_escape_string($mysqli, $_POST['nim']));
	$email = htmlspecialchars(mysqli_real_escape_string($mysqli, $_POST['email']));

		
	// Check for empty fields
	if (empty($name) || empty($nim) || empty($email)) {
		if (empty($name)) {
			echo "<font color='red'>Name field is empty.</font><br/>";
		}
		
		if (empty($nim)) {
			echo "<font color='red'>NIM field is empty.</font><br/>";
		}
		
		if (empty($email)) {
			echo "<font color='red'>Email field is empty.</font><br/>";
		}
		
		// Show link to the previous page
		echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
	} else { 
		// If all the fields are filled (not empty) 

			// Insert data into database
			$result = mysqli_query($mysqli, "INSERT INTO employees (`name`, `nim`, `email`) VALUES ('$name', '$nim', '$email')");
			
			// Check for errors
if (!$result) {
    echo "Error: " . mysqli_error($mysqli);
} else {
    // Menampilkan pesan sukses dengan pengalihan
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
