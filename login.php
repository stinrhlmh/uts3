<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "conn.php";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user['role'];
        $_SESSION['user_id'] = $user['id']; // ✅ TAMBAH INI
        header("Location: index.php?page=dashboard");
        exit;
    } else {
        echo "<p style='color:red;'>❌ Username atau password salah!</p>";
    }
}
?>

<h2>Login</h2>
<form method="post" action="">
    <label>Username</label>
    <input type="text" name="username" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <button type="submit" name="login">Login</button>
</form>