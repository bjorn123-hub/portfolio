<!DOCTYPE html>
<html>
<head>
    <title>Portfolio</title>
</head>
<body>
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
    <?php if (isset($success)) echo "<p style='color: green;'>$success</p>"; ?>

    <h2>Your Profile</h2>
    <?php $profile = $_SESSION['users'][$loggedInUser]['profile'] ?? null; ?>
    <?php if ($profile): ?>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($profile['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($profile['email']); ?></p>
        <p><strong>Age:</strong> <?php echo htmlspecialchars($profile['age']); ?></p>
        <p><strong>Bio:</strong> <?php echo nl2br(htmlspecialchars($profile['bio'])); ?></p>
        <p><strong>Skills:</strong> <?php echo htmlspecialchars($profile['skills']); ?></p>
        <p><strong>Location:</strong> <?php echo htmlspecialchars($profile['location']); ?></p>
    <?php else: ?>
        <p>No profile data available.</p>
    <?php endif; ?>
</body>
</html>
