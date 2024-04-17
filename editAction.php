<?php
// Include the database connection file
require_once("dbConnection.php");



session_start();

if (!isset($_SESSION['username'])) {
	header("Location: login.php");
	exit();
}

if (isset($_POST['update'])) {
	//mysqli_real_escape_string() digunakan untuk melindungi dari serangan SQL injection.
	// htmlspecialchars() digunakan untuk melindungi dari serangan cross-site scripting (XSS).
	$id = htmlspecialchars(mysqli_real_escape_string($mysqli, $_POST['id']));
	$name = htmlspecialchars(mysqli_real_escape_string($mysqli, $_POST['name']));
	$nim = htmlspecialchars(mysqli_real_escape_string($mysqli, $_POST['nim']));
	$email = htmlspecialchars(mysqli_real_escape_string($mysqli, $_POST['email']));	

	$stmt = $mysqli->prepare("UPDATE employees SET `name` = ?, `nim` = ?, `email` = ? WHERE `id` = ?");

	// Bind parameter ke statement
	$stmt->bind_param("sisi", $name, $nim, $email, $id);

	
	// Cek apakah query berhasil dieksekusi atau tidak
	if ($stmt->execute()) {
		echo "<div style='margin-top: 100px; padding: 20px; background-color: #d4edda; color: #155724; border-radius: 8px; text-align: center;'>
				<p style='font-size: 18px; font-weight: bold;'>Data updated successfully!</p>
				<a href='index.php' style='display: inline-block; padding: 10px 20px; background-color: #28a745; color: white; border-radius: 4px; text-decoration: none; font-weight: bold; margin-top: 10px;'>View Result</a>
			  </div>";
	} else {
		echo "<div style='margin-top: 100px; padding: 20px; background-color: #f8d7da; color: #721c24; border-radius: 8px; text-align: center;'>
				<p style='font-size: 18px; font-weight: bold;'>Data update failed: " . htmlspecialchars($stmt->error) . "</p>
				<a href='javascript:self.history.back();' style='display: inline-block; padding: 10px 20px; background-color: #dc3545; color: white; border-radius: 4px; text-decoration: none; font-weight: bold; margin-top: 10px;'>Go Back</a>
			  </div>";
	}
	
}
