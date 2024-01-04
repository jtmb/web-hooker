<?php

// Set the path to the config file
$configFilePath = '/data/web-hooker/config.json';

// Get values from environment variables
$dashboardUser = getenv('DASHBOARD_USER');
$dashboardPassword = getenv('DASHBOARD_PASSWORD');

// Config file does not exist, create it with default values
$configData = [
    'DASHBOARD_USER' => $dashboardUser,
    'DASHBOARD_PASSWORD' => $dashboardPassword,
];

// Convert the array to JSON
$jsonData = json_encode($configData, JSON_PRETTY_PRINT);

// Save JSON data to the config file, always override
file_put_contents($configFilePath, $jsonData);

echo 'Config file created or updated successfully.';
?>
