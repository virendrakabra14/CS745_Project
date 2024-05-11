<?php
session_start();
require_once('config.php');
require_once('vendor/autoload.php'); 

$client = new Google_Client(['client_id' => '<Google client id>']); //need to pull from GCP, put as environmental var  

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['credential'])) {
    $id_token = $_POST['credential'];

    try {
        $payload = $client->verifyIdToken($id_token);

        if ($payload) {
            $user_id = $payload['sub'];
            $email = $payload['email'];
            $_SESSION['user_id'] = $user_id; // Set user ID in session
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Invalid ID token']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>
