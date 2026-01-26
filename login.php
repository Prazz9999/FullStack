<?php

session_start();
require 'db.php';

ini_set("log_error", 1);

ini_set("error_log","error.log");

// Generation of CSRF Token
if(!isset($_SESSION['csrf_token'])){

$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

}

$error = '';

try {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Check if Token is Valid. CSRF attack doesnot have CSRF token or token is invalid

        $isCSRFvalid = isset($_POST['csrf_token']) && isset($_SESSION['csrf_token'])&& hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']);

        if(!$isCSRFvalid){
            $error = "Some error occurred. Please try again!";
        }else{

        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE email=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                header('Location: dashboard.php');
                exit;
            } else {
                $error = "Incorrect password";
            }
        } else {
            $error = "Email does not exist";
        }
    }
    }
} catch (Exception $e) {
    $error = "Something went wrong.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

<?php if ($error): ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>

<form method="POST">
    <label>Email:</label><br>
    <input type="text" name="email"><br><br>

    <label>Password:</label><br>
    <input type="password" name="password"><br><br>

    <!-- Send Via Post Request -->

    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'])?>">

    <button type="submit">Login</button>
</form>
<br>
<a href="signup.php">Go to Signup</a>
</body>
</html>
