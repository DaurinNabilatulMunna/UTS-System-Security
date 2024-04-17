<?php

// Include the database connection file
require_once("dbConnection.php");

// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to index.php
if (!isset($_SESSION['username'])) {
	header("Location: login.php");
	exit();
}

// Get id from URL parameter
$id = $_GET['id'];

// Siapkan statement untuk placeholder ID
$stmt = $mysqli->prepare("SELECT * FROM employees WHERE id = ?");

// memberikan parameter statement
$stmt->bind_param("i", $id);

// Jalankan query
$stmt->execute();

// Ambil hasil query
$result = $stmt->get_result();

// Ambil data dari hasil query
$resultData = $result->fetch_assoc();

$name = $resultData['name'];
$nim = $resultData['nim'];
$email = $resultData['email'];

// tutup statement
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* CSS untuk mempercantik tampilan */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            padding: 100px;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 50%;
            text-align: center;
            margin: 0 auto;
        }

        h2 {
            color: #333;
        }

        a {
            color: #007bff;
            text-decoration: none;
            margin-bottom: 10px;
        }

        a:hover {
            text-decoration: underline;
        }

        table {
            margin-top: 20px;
            width: 100%;
        }

        table td {
            padding: 10px;
            text-align: left;
        }

        input[type="text"],
        input[type="number"],
        input[type="email"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Edit Data</h2>

        <p>
            <a href="index.php">Home</a>
        </p>

        <form name="edit" method="post" action="editAction.php">
            <table border="0">
                <tr>
                    <td>Name</td>
                    <td><input type="text" name="name" value="<?php echo $name; ?>"></td>
                </tr>
                <tr>
                    <td>nim</td>
                    <td><input type="number" name="nim" value="<?php echo $nim; ?>" min="0"></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type="email" name="email" value="<?php echo $email; ?>"></td>
                </tr>
                <tr>
                    <td><input type="hidden" name="id" value=<?php echo $id; ?>></td>
                    <td><input type="submit" name="update" value="Update"></td>
                </tr>
            </table>
        </form>
    </div>
</body>

</html>
