<?php
if (isset($_GET['logout'])) {
    unset($_SESSION['logged_in_user']);
    header("Location: login.php");
    exit;
}
?>

