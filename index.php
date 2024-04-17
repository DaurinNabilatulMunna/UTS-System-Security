<?php

// Turn off all error reporting (for production use, not for development)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
require_once("dbConnection.php");

// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to index.php
if (!isset($_SESSION['username'])) {
	header("Location: login.php");
	exit();
}


// Fetch data in descending order (lastest entry first)
$result = mysqli_query($mysqli, "SELECT * FROM employees ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* CSS untuk mempercantik tampilan */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f8ff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 50vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            text-align: center;
        }

        h2 {
            color: #333;
        }

        a {
            color: #007bff;
            text-decoration: none;
            margin: 0 10px;
        }

        a:hover {
            text-decoration: underline;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .action-links {
            display: flex;
            margin: 20px 0;
        }

        .action-links a {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            font-size: 14px;
        }

        .action-links a:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Homepage</h2>

        <div class="action-links">
            <a href="add.php">Add New Data</a>
            <a href="logout.php">Logout</a>
        </div>

        <table class="table">
            <thead>
                <tr bgcolor='#DDDDDD'>
					<th>Id Pengguna</th>
                    <th>Name</th>
                    <th>NIM</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch the next row of a result set as an associative array
                while ($res = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
					echo "<td>".$res['id']."</td>";
                    echo "<td>".$res['name']."</td>";
                    echo "<td>".$res['nim']."</td>";
                    echo "<td>".$res['email']."</td>";
                    echo "<td><a href=\"edit.php?id=$res[id]\">Edit</a> | 
                    <a href=\"delete.php?id=$res[id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>
