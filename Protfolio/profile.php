<?php
session_start();
$loggedInUser = $_SESSION['logged_in_user'] ?? null;

if (!$loggedInUser) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['update_profile'])) {
    // Validate and handle the form submission
    $profilePicture = $_SESSION['users'][$loggedInUser]['profile']['profile_picture'] ?? ''; // Default to existing picture

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        // Handle file upload
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['profile_picture']['name']);
        
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadFile)) {
            $profilePicture = $_FILES['profile_picture']['name'];
        } else {
            $error = "Error uploading the profile picture.";
        }
    }

    // Update profile data in session
    $_SESSION['users'][$loggedInUser]['profile'] = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'age' => $_POST['age'],
        'bio' => $_POST['bio'],
        'skills' => $_POST['skills'],
        'location' => $_POST['location'],
        'profile_picture' => $profilePicture
    ];

    $success = "Profile updated successfully.";
}

// Handle logout
if (isset($_GET['logout'])) {
    unset($_SESSION['logged_in_user']);
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        .error {
            color: #FF6347;
            font-size: 14px;
        }
        .profile-picture {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($loggedInUser); ?></h1>
        <a href="?logout=true">Logout</a>

        <h2>Update Profile</h2>
        
        <?php 
            $profile = $_SESSION['users'][$loggedInUser]['profile'] ?? null; 
            if (isset($profile['profile_picture']) && $profile['profile_picture'] !== ''):
        ?>
            <img src="uploads/<?php echo htmlspecialchars($profile['profile_picture']); ?>" alt="Profile Picture" class="profile-picture">
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Full Name" value="<?php echo $_SESSION['users'][$loggedInUser]['profile']['name'] ?? ''; ?>" required>
            <input type="email" name="email" placeholder="Email" value="<?php echo $_SESSION['users'][$loggedInUser]['profile']['email'] ?? ''; ?>" required>
            <input type="number" name="age" placeholder="Age" value="<?php echo $_SESSION['users'][$loggedInUser]['profile']['age'] ?? ''; ?>" required>
            <textarea name="bio" placeholder="Short Bio"><?php echo $_SESSION['users'][$loggedInUser]['profile']['bio'] ?? ''; ?></textarea>
            <input type="text" name="skills" placeholder="Skills" value="<?php echo $_SESSION['users'][$loggedInUser]['profile']['skills'] ?? ''; ?>" required>
            <input type="text" name="location" placeholder="Location" value="<?php echo $_SESSION['users'][$loggedInUser]['profile']['location'] ?? ''; ?>" required>

            <!-- Profile Picture Upload -->
            <input type="file" name="profile_picture" accept="image/*">
            <button type="submit" name="update_profile">Save Profile</button>
        </form>

        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <h2>Your Profile</h2>
<?php if ($profile): ?>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($profile['name'] ?? ''); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($profile['email'] ?? ''); ?></p>
    <p><strong>Age:</strong> <?php echo htmlspecialchars($profile['age'] ?? ''); ?></p>
    <p><strong>Bio:</strong> <?php echo htmlspecialchars($profile['bio'] ?? ''); ?></p>
    <p><strong>Skills:</strong> <?php echo htmlspecialchars($profile['skills'] ?? ''); ?></p>
    <p><strong>Location:</strong> <?php echo htmlspecialchars($profile['location'] ?? ''); ?></p>
    <?php if (!empty($profile['profile_picture'])): ?>
        <p><strong>Profile Picture:</strong></p>
        <img src="uploads/<?php echo htmlspecialchars($profile['profile_picture']); ?>" alt="Profile Picture" class="profile-picture">
    <?php endif; ?>
<?php else: ?>
    <p>No profile data available.</p>
<?php endif; ?>
