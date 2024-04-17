<?php
// Comment out the following lines when deploying to production
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// Include the database connection file
require_once("dbConnection.php");


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the submitted username and password
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Validate and sanitize the inputs
    $username = trim($username);
    $password = trim($password);
    $email = trim($email);

    // Validate the inputs
    if (empty($username) || empty($password)) {
        $errorMessage = "Please enter both username and password.";
    } else {
        //mysqli_real_escape_string adalah fungsi di dalam PHP yang digunakan untuk escaping 
        // atau menghindari karakter khusus dalam string yang akan dimasukkan ke dalam kueri SQL
        //mysqli mendukung prepared statements dan parameterized queries
        //yang merupakan metode yang dapat membantu menghindari serangan SQL injection.

        $username = mysqli_real_escape_string($mysqli, $username);
        $email = mysqli_real_escape_string($mysqli, $email);
        $password = mysqli_real_escape_string($mysqli, $password);

        // menyimpan password dengan enkripsi
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Check if the username already exists in the database
        $stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errorMessage = "Username already exists. Please choose a different username.";
        } else {
            // Insert the new user into the database
            $stmt = $mysqli->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashedPassword);
            if ($stmt->execute()) {
                // User registration successful
                header('Location: login.php'); // Redirect to the login page
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
