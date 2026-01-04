<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $student_id = $_POST['student_id'];
    $full_name  = $_POST['full_name'];
    $password   = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare(
        "INSERT INTO students (student_id, full_name, password_hash)
         VALUES (?, ?, ?)"
    );
    $stmt->execute([$student_id, $full_name, $password]);

    header("Location: login.php");
    exit();
}
?>

<h2>Register</h2>
<form method="post">
    Student ID: <input name="student_id" required><br><br>
    Full Name: <input name="full_name" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <button type="submit">Register</button>
</form>
