<?php
class Student {
private $conn;


public function __construct($db) {
$this->conn = $db;
}


public function all() {
return $this->conn->query("SELECT * FROM students");
}


public function find($id) {
return $this->conn->query("SELECT * FROM students WHERE id=$id")->fetch_assoc();
}


public function create($name, $email, $course) {
return $this->conn->query("INSERT INTO students VALUES (NULL,'$name','$email','$course')");
}


public function update($id, $name, $email, $course) {
return $this->conn->query("UPDATE students SET name='$name', email='$email', course='$course' WHERE id=$id");
}


public function delete($id) {
return $this->conn->query("DELETE FROM students WHERE id=$id");
}
}
