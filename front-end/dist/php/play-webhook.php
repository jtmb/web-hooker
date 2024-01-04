<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['filename'])) {
    $filename = $_GET['filename'];
    $jsonFile = '/data/web-hooker/webhooks/' . $filename;

    if (file_exists($jsonFile)) {
        $jsonData = json_decode(file_get_contents($jsonFile), true);

        // Extract data from the JSON file
        $name = $jsonData['Name'];
        $webhook = $jsonData['Discord_Webhook'];
        $botName = $jsonData['Bot_Name'];
        $botAvatar = $jsonData['Bot_Avatar'];
        $message = $jsonData['Message'];
        $tagUser = $jsonData['Tag_User'];

        // Construct the Discord webhook payload
        $payload = array(
            'content' => $message,
            'username' => $botName,
            'avatar_url' => $botAvatar,
            // ... (other fields you want to include)
        );

        // Convert payload to JSON
        $payloadJson = json_encode($payload);

        // Initialize cURL session
        $ch = curl_init($webhook);

        // Set cURL options
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadJson);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        // Execute cURL session
        curl_exec($ch);

        // Close cURL session
        curl_close($ch);

        echo 'Webhook sent successfully!';
    } else {
        echo 'Error: Webhook file not found!';
    }
} else {
    echo 'Invalid request!';
}
?>
