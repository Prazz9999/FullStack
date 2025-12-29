<?php
require 'db.php';

if(!isset($_GET['id'])){
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM students WHERE id=?");
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];

    $stmt = $pdo->prepare("UPDATE students SET name=?, email=?, course=? WHERE id=?");
    $stmt->execute([$name, $email, $course, $id]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
</head>
<body>
    <h2>Edit Student</h2>
    <form method="POST">
        Name: <input type="text" name="name" required value="<?= $student['name'] ?>"><br>
        Email: <input type="email" name="email" required value="<?= $student['email'] ?>"><br>
        Course: <input type="text" name="course" required value="<?= $student['course'] ?>"><br>
        <button type="submit">Update Student</button>
    </form>
    <br>
    <a href="index.php">Back to Student List</a>
</body>
</html>
