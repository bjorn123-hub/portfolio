<?php
session_start();
$loggedInUser = $_SESSION['logged_in_user'] ?? null;

if (!$loggedInUser) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['update_profile'])) {
    $_SESSION['users'][$loggedInUser]['profile'] = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'age' => $_POST['age'],
        'bio' => $_POST['bio'],
        'skills' => $_POST['skills'],
        'location' => $_POST['location']
    ];
    $success = "Profile updated successfully.";
}

if (isset($_GET['logout'])) {
    unset($_SESSION['logged_in_user']);
    header("Location: login.php");
    exit;
}
?>

<html>
<head>
    <title>Portfolio</title>
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
            color: white;
        }
        .container {
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
            text-align: left;
            width: 400px;
        }
        h1, h2 {
            color: #FFD700;
        }
        input, textarea {
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
        .success {
            color: #32CD32;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($loggedInUser); ?></h1>
        <a href="?logout=true">Logout</a>

        <h2>Update Profile</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Full Name" value="<?php echo $_SESSION['users'][$loggedInUser]['profile']['name'] ?? ''; ?>" required>
            <input type="email" name="email" placeholder="Email" value="<?php echo $_SESSION['users'][$loggedInUser]['profile']['email'] ?? ''; ?>" required>
            <input type="number" name="age" placeholder="Age" value="<?php echo $_SESSION['users'][$loggedInUser]['profile']['age'] ?? ''; ?>" required>
            <textarea name="bio" placeholder="Short Bio"><?php echo $_SESSION['users'][$loggedInUser]['profile']['bio'] ?? ''; ?></textarea>
            <input type="text" name="skills" placeholder="Skills" value="<?php echo $_SESSION['users'][$loggedInUser]['profile']['skills'] ?? ''; ?>" required>
            <input type="text" name="location" placeholder="Location" value="<?php echo $_SESSION['users'][$loggedInUser]['profile']['location'] ?? ''; ?>" required>
            <button type="submit" name="update_profile">Save Profile</button>
        </form>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>

        <h2>Your Profile</h2>
        <?php $profile = $_SESSION['users'][$loggedInUser]['profile'] ?? null; ?>
