<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
        } else {
            $error = "Invalid password";
        }
    } else {
        $error = "User not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Movies Review</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Global Dark Theme */
        body {
            background-color: #121212;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
        }

        /* Navigation Bar */
        .navbar {
            background-color: #1f1f1f;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        .navbar .logo {
            color: white;
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
        }
        .navbar ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }
        .navbar ul li {
            margin-left: 15px;
        }
        .navbar ul li a {
            color: #00bcd4;
            text-decoration: none;
            font-size: 16px;
        }
        .navbar ul li a:hover {
            color: #0097a7;
        }

        /* Form Container */
        .form-container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #1f1f1f;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #00bcd4;
        }
        .form-container .form-group {
            margin-bottom: 15px;
        }
        .form-container .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #ccc;
        }
        .form-container .form-group input {
            width: 100%;
            padding: 10px;
            background-color: #2c2c2c;
            border: 1px solid #444;
            border-radius: 5px;
            color: white;
            font-size: 16px;
        }
        .form-container .form-group input:focus {
            border-color: #00bcd4;
            background-color: #3a3a3a;
            outline: none;
        }
        .form-container .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: #00bcd4;
            border: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .form-container .btn-submit:hover {
            background-color: #0097a7;
        }

        /* Error Message */
        .form-container p {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 20px 0;
            background-color: #1f1f1f;
            color: #ccc;
            margin-top: 50px;
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar">
    <a href="index.php" class="logo">Movies Review</a>
    <ul>
        <li><a href="register.php">Register</a></li>
    </ul>
</nav>

<!-- Login Form -->
<div class="form-container">
    <h2>Login</h2>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form action="login.php" method="POST">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>
        <button type="submit" class="btn-submit">Login</button>
    </form>
</div>

<!-- Footer -->
<footer>
    <p>&copy; 2024 Movies Review. All Rights Reserved.</p>
</footer>

</body>
</html>
