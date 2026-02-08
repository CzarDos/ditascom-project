<?php
/**
 * SMTP Connection Test for Gmail
 * This script tests the SMTP connection directly
 */

require_once 'vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "=== SMTP Connection Test ===\n";

$host = $_ENV['MAIL_HOST'] ?? 'smtp.gmail.com';
$port = $_ENV['MAIL_PORT'] ?? 587;
$username = $_ENV['MAIL_USERNAME'] ?? '';
$password = $_ENV['MAIL_PASSWORD'] ?? '';

echo "Testing connection to: {$host}:{$port}\n";
echo "Username: {$username}\n";
echo "Password: " . str_repeat('*', strlen($password)) . "\n\n";

// Test socket connection
echo "1. Testing socket connection...\n";
$socket = @fsockopen($host, $port, $errno, $errstr, 10);
if ($socket) {
    echo "✅ Socket connection successful\n";
    fclose($socket);
} else {
    echo "❌ Socket connection failed: {$errstr} ({$errno})\n";
    exit(1);
}

// Test SMTP with PHPMailer
echo "\n2. Testing SMTP authentication...\n";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = $host;
    $mail->SMTPAuth   = true;
    $mail->Username   = $username;
    $mail->Password   = $password;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = $port;
    
    // Enable verbose debug output
    $mail->SMTPDebug = SMTP::DEBUG_CONNECTION;
    
    // Test connection
    if ($mail->smtpConnect()) {
        echo "✅ SMTP authentication successful!\n";
        $mail->smtpClose();
    } else {
        echo "❌ SMTP authentication failed\n";
    }
    
} catch (Exception $e) {
    echo "❌ SMTP Error: {$mail->ErrorInfo}\n";
    echo "Exception: " . $e->getMessage() . "\n";
}

echo "\n=== Test Complete ===\n";
