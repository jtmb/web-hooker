<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST['name'];
    $webhook = $_POST['webhook'];
    $botName = $_POST['bot_name'];
    $botAvatar = $_POST['bot_avatar'];
    $message = $_POST['message'];
    $tagUser = $_POST['tag_user'];

    // Create an associative array with form data
    $webhookData = array(
        'Name' => $name,
        'Discord_Webhook' => $webhook,
        'Bot_Name' => $botName,
        'Bot_Avatar' => $botAvatar,
        'Message' => $message,
        'Tag_User' => $tagUser
    );

    // Convert the array to JSON
    $jsonData = json_encode($webhookData, JSON_PRETTY_PRINT);

    // Set the directory where the file will be saved
    $saveDirectory = '/data/web-hooker/webhooks/';

    // Save JSON data to a file with the name as "Name.json" in the specified directory
    $fileName = $saveDirectory . $name . '.json';

    // Add explicit error handling
    if (file_put_contents($fileName, $jsonData) !== false) {
        // Successful file save, redirect to dashboard.php or any desired page
        header('Location: dashboard');
        echo 'Debug info: ' . print_r($_POST, true);
        exit;
    } else {
        // Error saving file, display an error message
        echo 'Error saving file!';
    }
} else {
    // Invalid request, display an error message
    echo 'Invalid request!';
}
?>
