<?php
session_start();
require_once('config.php');

if(isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if the username already exists
    $query = "SELECT id FROM users WHERE username = $1";
    $result = pg_query_params($db, $query, array($username));
    if (pg_num_rows($result) > 0) {
        echo "Username already exists. Please choose a different username.";
    } else {
        // Insert new user into the database
        $query = "INSERT INTO users (username, password) VALUES ($1, $2)";
        pg_query_params($db, $query, array($username, $hashed_password));
        echo "Registration successful. You can now <a href='index.php'>log in</a>.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
</head>
<body>
    <h1>User Registration</h1>
    <form action="" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <button type="submit">Register</button>
    </form>
</body>
</html>
