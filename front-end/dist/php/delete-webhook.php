<?php
// Set the directory where the files are stored
$webhooksDirectory = '/data/web-hooker/webhooks/';

// Check if the filename is provided in the query parameters
if (isset($_GET['filename'])) {
    // Get the filename from the query parameters
    $filename = $_GET['filename'];

    // Construct the full path to the JSON file
    $filePath = $webhooksDirectory . $filename;

    // Check if the file exists before attempting to delete
    if (file_exists($filePath)) {
        // Attempt to delete the file
        if (unlink($filePath)) {
            // Redirect back to the dashboard
            header('Location: /dashboard.php');
            exit;
        } else {
            echo 'Error deleting file.';
        }
    } else {
        echo 'File not found.';
    }
} else {
    echo 'Invalid request. Filename not provided.';
}
?>