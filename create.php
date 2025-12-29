<?php
require 'db.php';

try {    
    if($_SERVER['REQUEST_METHOD']==="POST" && isset($_POST['add_student'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $course = $_POST['course'];

        $sql = "INSERT INTO students (name, email, course) VALUES(?,?,?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $email, $course]);
        
        header("Location: index.php");
        exit;
    }
} catch(PDOException $e){
    die("Failed to insert student: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
</head>
<body>
    <h2>Add Student</h2>
    <form method="POST">
        Name: <input type="text" name="name" required><br>
        Email: <input type="email" name="email" required><br>
        Course: <input type="text" name="course" required><br>
        <button type="submit" name="add_student">Add Student</button>
    </form>
    <br>
    <a href="index.php">Go to Student List</a>
</body>
</html>
