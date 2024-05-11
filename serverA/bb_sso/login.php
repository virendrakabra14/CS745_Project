<?php
session_start();
require_once('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "SELECT id, username, password FROM users WHERE username = $1";
    $result = pg_query_params($db, $query, array($username));
    $row = pg_fetch_assoc($result);

    if ($row && password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $row['id'];
        header("Location: home.php");
        exit;
    } else {
        echo "Invalid username or password";
    }
}
?>
