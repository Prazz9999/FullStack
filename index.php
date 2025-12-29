<?php
require 'db.php';

// Fetch all students
$students = $pdo->query("SELECT * FROM students")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student List</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin-top: 2rem; }
        th, td { border: 1px solid #ccc; padding: 0.5rem; text-align: left; }
        a { text-decoration: none; padding: 0.3rem 0.5rem; border: 1px solid #ccc; background: #f0f0f0; margin-right: 0.3rem; }
    </style>
</head>
<body>
    <h2>Student List</h2>
    <a href="create.php">Add New Student</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Course</th>
            <th>Actions</th>
        </tr>
        <?php foreach($students as $student): ?>
        <tr>
            <td><?= $student['id'] ?></td>
            <td><?= $student['name'] ?></td>
            <td><?= $student['email'] ?></td>
            <td><?= $student['course'] ?></td>
            <td>
                <a href="edit.php?id=<?= $student['id'] ?>">Edit</a>
                <a href="delete.php?id=<?= $student['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
