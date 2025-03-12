<?php
// webhook.php

// Secret token from GitHub webhook settings (if set).
$secret = 'eldv2';

// Get the raw POST data
$rawPostData = file_get_contents('php://input');

// Get the signature from the headers
$signature = isset($_SERVER['HTTP_X_HUB_SIGNATURE']) ? $_SERVER['HTTP_X_HUB_SIGNATURE'] : '';

// Verify the GitHub webhook signature (optional but recommended)
$hash = 'sha1=' . hash_hmac('sha1', $rawPostData, $secret);

// Check if the signature is valid
if ($signature !== $hash) {
    header('HTTP/1.1 400 Bad Request');
    echo 'Invalid signature';
    exit();
}

// Decode the incoming JSON data
$data = json_decode($rawPostData, true);

// Check if the data is valid
if (is_array($data)) {
    // Do something with the payload (like logging the push event)
    // Example: Log the repository name and the latest commit message
    $repoName = $data['repository']['full_name'];
    $pusher = $data['pusher']['name'];
    $commits = $data['commits'];

    echo "Push received from $pusher to repository $repoName\n";
    foreach ($commits as $commit) {
        echo "Commit: {$commit['message']}\n";
    }

    // You can now perform any further actions (e.g., trigger a deployment).
} else {
    header('HTTP/1.1 400 Bad Request');
    echo 'Invalid payload';
    exit();
}

header('HTTP/1.1 200 OK');
echo 'Webhook processed successfully';
