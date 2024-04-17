<?php
require_once("dbConnection.php");



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $username = $username;
    $password = $password;
    $email = $email;

    if (empty($username) || empty($password)) {
        $errorMessage = "Please enter both username and password.";
    } else {
        $username =  $username;
        $email = $email;
        $password = $password;

        // Simpan password dalam bentuk plaintext
        $hashedPassword = $password;

        $stmt = $mysqli->prepare("SELECT * FROM users_sql WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errorMessage = "Username already exists. Please choose a different username.";
        } else {
            $stmt = $mysqli->prepare("INSERT INTO users_sql (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashedPassword);
            if ($stmt->execute()) {
                header('Location: login.php');
                exit();
            } else {
                $errorMessage = "Failed to register user.";
                header("Location: register.php?errorMessage=" . urlencode($errorMessage));
            }
        }
    }
}

$mysqli->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* CSS untuk mempercantik tampilan */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f8ff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0);
            width: 30%;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        form {
            width: 100%;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
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
            width: 104%;
            
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        p.error {
            color: red;
            margin-bottom: 10px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Register</h2>

        <?php if (isset($errorMessage)) { ?>
            <p class="error"><?php echo $errorMessage; ?></p>
        <?php } ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" onsubmit="showSuccessPopup()">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <input type="submit" value="Register">
        </form>

        <p>Have an account? <a href="login.php">Login</a></p>
    </div>
</body>

</html>
