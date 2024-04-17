<?php
// Sertakan file koneksi database
require_once("dbConnection.php");

// Mulai sesi
session_start();

// Periksa apakah pengguna telah login, jika belum, arahkan ke halaman login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Periksa apakah form update telah dikirimkan
if (isset($_POST['update'])) {
    // Ambil data dari form
    $id = $_POST['id'];
    $name = $mysqli->real_escape_string($_POST['name']);
    $nim = (int)$_POST['nim']; // Casting usia menjadi integer
    $email = $mysqli->real_escape_string($_POST['email']);

    // Membuat query SQL langsung 
    $query = "UPDATE employees_sql SET name = '$name', nim = '$nim', email = '$email' WHERE id = $id";

    // Eksekusi query
    $result = $mysqli->query($query);

    // Cek apakah query berhasil dieksekusi atau tidak
    if ($result) {
        echo "<div style='margin-top: 100px; padding: 20px; background-color: #d4edda; color: #155724; border-radius: 8px; text-align: center;'>
                <p style='font-size: 18px; font-weight: bold;'>Data updated successfully!</p>
                <a href='index.php' style='display: inline-block; padding: 10px 20px; background-color: #28a745; color: white; border-radius: 4px; text-decoration: none; font-weight: bold; margin-top: 10px;'>View Result</a>
              </div>";
    } else {
        echo "<div style='margin-top: 100px; padding: 20px; background-color: #f8d7da; color: #721c24; border-radius: 8px; text-align: center;'>
                <p style='font-size: 18px; font-weight: bold;'>Data update failed: " . $mysqli->error . "</p>
                <a href='javascript:self.history.back();' style='display: inline-block; padding: 10px 20px; background-color: #dc3545; color: white; border-radius: 4px; text-decoration: none; font-weight: bold; margin-top: 10px;'>Go Back</a>
              </div>";
    }
}
?>
