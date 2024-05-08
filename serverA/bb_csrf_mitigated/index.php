<?php
session_start();
require_once('config.php');

if(isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin Board</title>
</head>
<body>
    <h1>Welcome to the Bulletin Board</h1>
    If you don't have an account, <a href="register.php">register here</a>.
    Else login:
    <form action="login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <button type="submit">Log In</button>
    </form>
</body>
</html>
