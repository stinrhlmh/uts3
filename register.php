<?php
include "conn.php"; // connect to database

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    // check if passwords match
    if ($password !== $confirm) {
        echo "<p style='color:red;'>❌ Passwords do not match!</p>";
    } else {
        // check if username already exists
        $checkUser = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
        if (mysqli_num_rows($checkUser) > 0) {
            echo "<p style='color:red;'>⚠️ Username already taken!</p>";
        } else {
            // hash the password
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            // insert user data dengan role default 'user'
            $query = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$hashed', 'user')";
            $result = mysqli_query($conn, $query);

            if ($result) {
                echo "<p style='color:green;'>✅ Registration successful! You can now <a href='index.php?page=login'>Login</a>.</p>";
            } else {
                echo "<p style='color:red;'>❌ Registration failed: " . mysqli_error($conn) . "</p>";
            }
        }
    }
}
?>

<h2>Register</h2>
<form method="post" action="">
    <label>Username</label>
    <input type="text" name="username" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <label>Confirm Password</label>
    <input type="password" name="confirm_password" required>

    <button type="submit" name="register">Register</button>
</form>