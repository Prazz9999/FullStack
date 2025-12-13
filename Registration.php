<?php
$nameErr = $emailErr = $passwordErr = $confirmPasswordErr = "";
$name = $email = $password = $confirm_password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = htmlspecialchars($_POST["name"]);
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = htmlspecialchars($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = $_POST["password"];
        if (strlen($password) < 6) {
            $passwordErr = "Password must be at least 6 characters";
        } elseif (!preg_match("/[!@#$%^&*]/", $password)) {
            $passwordErr = "Password must contain a special character";
        }
    }

    if (empty($_POST["confirm_password"])) {
        $confirmPasswordErr = "Confirm password required";
    } else {
        $confirm_password = $_POST["confirm_password"];
        if ($confirm_password !== $password) {
            $confirmPasswordErr = "Passwords do not match";
        }
    }

    if (!$nameErr && !$emailErr && !$passwordErr && !$confirmPasswordErr) {

        $file = "users.json";
        $users = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

        $users[] = [
            "name" => $name,
            "email" => $email,
            "password" => password_hash($password, PASSWORD_DEFAULT)
        ];

        file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));

        echo "<h2>Registration Successful</h2>";
        echo "<a href='Registration.html'>Go to Login</a>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <link rel="stylesheet" href="registration.css">

    <!-- ✅ JS INSIDE SAME FILE -->
    <script>
        function validateForm() {
            let isValid = true;

            document.getElementById("nameErr").innerHTML = "";
            document.getElementById("emailErr").innerHTML = "";
            document.getElementById("passwordErr").innerHTML = "";
            document.getElementById("confirmPasswordErr").innerHTML = "";

            const name = document.getElementById("name").value.trim();
            const email = document.getElementById("email").value.trim();
            const password = document.getElementById("password").value.trim();
            const confirmPassword = document.getElementById("confirm_password").value.trim();

            if (name === "") {
                document.getElementById("nameErr").innerHTML = "Name is required";
                isValid = false;
            }

            if (email === "") {
                document.getElementById("emailErr").innerHTML = "Email is required";
                isValid = false;
            } else {
                const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,}$/;
                if (!emailPattern.test(email)) {
                    document.getElementById("emailErr").innerHTML = "Invalid email format";
                    isValid = false;
                }
            }

            if (password.length < 6) {
                document.getElementById("passwordErr").innerHTML = "Password must be at least 6 characters";
                isValid = false;
            } else if (!/[!@#$%^&*]/.test(password)) {
                document.getElementById("passwordErr").innerHTML = "Must contain a special character";
                isValid = false;
            }

            if (confirmPassword !== password) {
                document.getElementById("confirmPasswordErr").innerHTML = "Passwords do not match";
                isValid = false;
            }

            return isValid;
        }
    </script>
</head>

<body>

<div class="container">
<h2>User Registration</h2>

<form method="POST" onsubmit="return validateForm();">

<label>Name</label>
<input type="text" name="name" id="name">
<p class="error" id="nameErr"><?php echo $nameErr; ?></p>

<label>Email</label>
<input type="text" name="email" id="email">
<p class="error" id="emailErr"><?php echo $emailErr; ?></p>

<label>Password</label>
<input type="password" name="password" id="password">
<p class="error" id="passwordErr"><?php echo $passwordErr; ?></p>

<label>Confirm Password</label>
<input type="password" name="confirm_password" id="confirm_password">
<p class="error" id="confirmPasswordErr"><?php echo $confirmPasswordErr; ?></p>

<button type="submit">Register</button>

</form>
</div>

</body>
</html>
