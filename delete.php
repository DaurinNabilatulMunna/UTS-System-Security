<?php
// Include the database connection file
require_once("dbConnection.php");

// Initialize the session
session_start();

// Periksa apakah pengguna sudah login, jika ya, arahkan dia ke halaman login
if (!isset($_SESSION['username'])) {
	header("Location: login.php");
	exit();
}


// Dapatkan nilai parameter id 
$id = $_GET['id'];

$stmt = $mysqli->prepare("DELETE FROM employees WHERE id = ?");

// memberikan parameter statement
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location:index.php");
} else {
    echo "<font color='red'>Data delete failed." . $stmt->error;
    echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
}

$stmt->close();

?>
