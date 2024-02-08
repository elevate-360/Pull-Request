<?php

// Your Git repository path
$repoPath = '/var/www/Money-Portal';

// Log file path
$logFilePath = '/var/www/logs/webhook_calls.log';

// Secret key for security (optional)
$secretKey = 'd19beeaced792668ef76bc0ff568c61a8da0139f84d97e00f7dc198afb259f4bf85994d1f3ca24fe352ef9db5baa7c7412c3fbbaeac63604ac9de9a7bf31eed8';

// Validate the request
$headers = getallheaders();
$signature = $headers['X-Hub-Signature'] ?? null;
$body = file_get_contents('php://input');

// if ($secretKey && !isValidSignature($body, $signature, $secretKey)) {
//     http_response_code(403);
    die('Invalid signature.');
// }

// Record the webhook call with date and time to the log file
$message = date('Y-m-d H:i:s', strtotime("+ 5:30")) . " - successfully pulled changes in Money Portal.\n";
file_put_contents($logFilePath, $message, FILE_APPEND);

// Pull changes from the Git repository
exec("cd $repoPath && sudo git pull");

// Respond to the webhook request
echo 'Webhook received successfully.';

// function isValidSignature($payload, $signature, $secretKey)
// {
//     list($algo, $hash) = explode('=', $signature, 2) + [null, null];
//     $expectedHash = hash_hmac($algo, $payload, $secretKey);

//     return hash_equals($hash, $expectedHash);
// }
