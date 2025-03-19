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

// Decode the payload (GitHub sends JSON data)
$data = json_decode($payload, true);

// Handle the event types based on what GitHub sends
if (isset($data['action'])) {
    $action = $data['action'];
    
    // Example: Log the event to a file (you can do any logic here)
    $log_message = "Event: " . $action . "\n";
    $log_message .= "Repository: " . $data['repository']['name'] . "\n";
    $log_message .= "Sender: " . $data['sender']['login'] . "\n";

    // Save the log message in a file
    file_put_contents('webhook_log.txt', $log_message, FILE_APPEND);

    // Custom action after receiving the webhook, such as triggering an action
    if ($action === 'push') {
        // Handle push event, perform git pull to get the latest code
        $repository_dir = 'D:/ePokok/laravel/eLANDSKAP'; // Set the path to your Git repository (not the public folder)
        $branch = 'main'; // Set your branch (e.g., 'main', 'master', etc.)

        // Perform the git pull command
        $command = "cd $repository_dir && git checkout $branch && git pull origin $branch";

        // Execute the command
        $output = shell_exec($command);

        // Optionally log the output of the command to check for any issues
        file_put_contents('git_pull_log.txt', $output, FILE_APPEND);
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
