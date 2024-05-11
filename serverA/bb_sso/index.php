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
    <script src="https://accounts.google.com/gsi/client" async defer></script>
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
    
    <div id="g_id_onload"
        data-client_id="<google-client-id>" //to be entered, or via an environemtal variable
        data-callback="handleCredentialResponse"
        data-auto_prompt="false">
    </div>
        <div class="g_id_signin"
        data-type="standard"
        data-size="large"
        data-text="sign_in_with"
        data-shape="rectangular"
        data-theme="outline"
        data-logo_alignment="left">
    </div>

<script>
        function handleCredentialResponse(response) {
            // Send the ID token to your server for verification
            fetch('google_auth.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({credential: response.credential})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'home.php'; 
                } else {
                    console.error('Google Sign-In failed:', data.error);
                }
            });
        }
    </script>

</body>
</html>
