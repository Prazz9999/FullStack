<?php
session_start();
require 'db.php';

$user_email = '';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Use prepared statement (more secure)
    $sql = "SELECT email FROM users WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    if ($user) {
        $user_email = $user['email'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>

<h1>Welcome to my site</h1>

<?php if ($user_email): ?>
    <p>Logged In User : <?php echo htmlspecialchars($user_email); ?></p>
<?php else: ?>
    <p>You are not logged in.</p>
<?php endif; ?>

<br>

<a href="login.php">
    <button>Login</button>
</a>

<a href="logout.php">
    <button>Logout</button>
</a>

</body>
</html>
