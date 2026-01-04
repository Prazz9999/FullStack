<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $student_id = $_POST['student_id'];
    $password   = $_POST['password'];

    $stmt = $pdo->prepare(
        "SELECT full_name, password_hash
         FROM students
         WHERE student_id = ?"
    );
    $stmt->execute([$student_id]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['logged_in'] = true;
        $_SESSION['name'] = $user['full_name'];
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Invalid login details!";
    }
}
?>

<h2>Login</h2>
<form method="post">
    Student ID: <input name="student_id" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <button type="submit">Login</button>
</form>
