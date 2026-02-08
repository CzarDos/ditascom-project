<?php
/**
 * Check environment variables
 */

require_once 'vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "=== Environment Variables Check ===\n";

$mailVars = [
    'MAIL_MAILER',
    'MAIL_HOST', 
    'MAIL_PORT',
    'MAIL_USERNAME',
    'MAIL_PASSWORD',
    'MAIL_ENCRYPTION',
    'MAIL_FROM_ADDRESS',
    'MAIL_FROM_NAME'
];

foreach ($mailVars as $var) {
    $value = $_ENV[$var] ?? 'NOT SET';
    $display = ($var === 'MAIL_PASSWORD') ? str_repeat('*', strlen($value)) : $value;
    echo "{$var} = '{$display}'\n";
}

echo "\n=== Raw Config Values ===\n";
echo "Config mail.default = " . config('mail.default') . "\n";
echo "Config mail.mailers.smtp.host = " . config('mail.mailers.smtp.host') . "\n";
echo "Config mail.mailers.smtp.port = " . config('mail.mailers.smtp.port') . "\n";
echo "Config mail.mailers.smtp.username = " . config('mail.mailers.smtp.username') . "\n";
