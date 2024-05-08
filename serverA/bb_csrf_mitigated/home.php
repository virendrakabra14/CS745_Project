<?php
session_start();
require_once('config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
else {
    if(!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    // echo "token " . $_SESSION['csrf_token'];
}

if(isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function validate_csrf_token() {
    // Check if CSRF token is present in both session and POST data
    return isset($_SESSION['csrf_token']) && isset($_POST['csrf_token']) && $_SESSION['csrf_token'] === $_POST['csrf_token'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!validate_csrf_token()) {
        echo "<script>alert('csrf attempted');</script>";
        exit;
    }

    $message = $_POST['message'];
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO messages (user_id, message) VALUES ($1, $2)";
    pg_query_params($db, $query, array($user_id, $message));
}

$query = "SELECT messages.*, users.username FROM messages JOIN users ON messages.user_id = users.id ORDER BY created_at DESC";
$result = pg_query($db, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bulletin Board</title>
</head>
<body>
    <h1>Welcome to the Bulletin Board, <?php echo $_SESSION['user_id']; ?></h1>

    <form action="" method="post">
        <textarea name="message" rows="4" cols="50" required></textarea><br>
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>"> <!-- send csrf token -->
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
