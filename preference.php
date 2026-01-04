<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Preferences</title>
</head>
<body>

<h2>Student Preferences</h2>

<p><strong>Name:</strong> <?php echo htmlspecialchars($_SESSION['name']); ?></p>

<hr>

<form method="post">
    <label>
        <input type="checkbox" name="dark_mode">
        Enable Dark Mode
    </label>
    <br><br>

    <label>
        <input type="checkbox" name="email_notify">
        Receive Email Notifications
    </label>
    <br><br>

    <button type="submit">Save Preferences</button>
</form>

<br>
<a href="dashboard.php">Back to Dashboard</a> |
<a href="logout.php">Logout</a>

</body>
</html>
