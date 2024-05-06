<?php
session_start();
require_once('config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST['message'];
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO messages (user_id, message) VALUES ($1, $2)";
    pg_query_params($db, $query, array($user_id, $message));
}

$query = "SELECT messages.*, users.username FROM messages JOIN users ON messages.user_id = users.id ORDER BY created_at DESC";
$result = pg_query($db, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <h1>Welcome to the Bulletin Board, <?php echo $_SESSION['user_id']; ?></h1>

    <form action="" method="post">
        <textarea name="message" rows="4" cols="50" required></textarea><br>
        <button type="submit">Post Message</button>
    </form>

    <h2>Messages:</h2>
    <ul>
        <?php while ($row = pg_fetch_assoc($result)) { ?>
            <li>
                <strong><?php echo $row['username']; ?>:</strong> <?php echo $row['message']; ?>
            </li>
        <?php } ?>
    </ul>

    <form action="" method="post">
        <button type="submit" name="logout">Logout</button>
    </form>
</body>
</html>
