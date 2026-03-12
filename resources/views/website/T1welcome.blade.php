<?php
// webhook.php

// Secret token from GitHub webhook settings (if set).
$secret = 'eldv2';

// Get the raw POST data
$payload = file_get_contents('php://input');

// Get the signature from the headers
$github_signature = isset($_SERVER['HTTP_X_HUB_SIGNATURE']) ? $_SERVER['HTTP_X_HUB_SIGNATURE'] : '';

// Verify the GitHub webhook signature (optional but recommended)

// Function to verify GitHub signature
function verify_signature($payload, $github_signature, $secret)
{
    $hash = 'sha1=' . hash_hmac('sha1', $payload, $secret);
    return hash_equals($hash, $github_signature);
}
// Check if the signature is valid
if (!verify_signature($payload, $github_signature, $secret)) {
    header('HTTP/1.1 400 Bad Request');
    echo "Invalid signature.";
    exit;
}

$data = json_decode($payload, true);
if (isset($data['commits'])) {
    $event = $data['commits'][0]["timestamp"];
    $log_message = "Event: " . $event . "\n";
    $log_message .= "Repository: " . $data['repository']['name'] . "\n";
    $log_message .= "Sender: " . $data['sender']['login'] . "\n";

    file_put_contents('E:\www\elandskapv2\webhook_log.txt', $log_message, FILE_APPEND);

    if (isset($data['sender']['login'])) {
        $repository_dir = 'E:\www\elandskapv2';
        $branch = 'main';
        // $command = "cd /d $repository_dir && git checkout $branch && git pull origin $branch";
        // $output = shell_exec($command);
        // $command = 'echo "Hello from shell_exec!"';
        // $output = shell_exec($command);
        // file_put_contents('E:\www\elandskapv2\git_pull_log.txt', $output, FILE_APPEND);
    }

    // Respond with a success message
    header('HTTP/1.1 200 OK');
    echo "Webhook received successfully.";
} else {
    // Invalid payload
    header('HTTP/1.1 400 Bad Request');
    echo "Invalid payload.";
}

?>