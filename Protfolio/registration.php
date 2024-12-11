<?php
session_start();

if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = [];
}

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($password === $confirmPassword) {
        if (isset($_SESSION['users'][$username])) {
            $error = "Username already exists.";
        } else {
            $_SESSION['users'][$username] = [
                'password' => $password,
                'profile' => []
            ];
            $success = "Registration successful. Please log in.";
            header("Location: login.php");
            exit;
        }
    } else {
        $error = "Passwords do not match.";
    }
}
?>

<html>
<head>
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
            text-align: center;
            width: 300px;
        }
        h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #FFD700;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            background-color: #FFD700;
            color: #000;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #FFB800;
        }
        a {
            color: #FFD700;
            text-decoration: none;
            font-size: 14px;
        }
        a:hover {
            text-decoration: underline;
        }
        .error {
            color: #FF6347;
            font-size: 14px;
        }
        .success {
            color: #32CD32;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit" name="register">Register</button>
        </form>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <p><a href="login.php">Already have an account? Login</a></p>
    </div>
</body>
</html>