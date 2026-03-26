<?php
// Load environment variables
require_once __DIR__ . '/config/Load.php';

if (!function_exists('mailEnv')) {
    function mailEnv($key, $default = '')
    {
        $value = env($key, $default);
        if ($value === null) {
            return $default;
        }

        // Railway vars sometimes include wrapping quotes when pasted manually.
        return trim((string) $value, " \t\n\r\0\x0B\"'");
    }
}

// Define the Gmail smtp server
define('MAILHOST', mailEnv('MAIL_HOST'));

// Define SMTP port (587 for STARTTLS, 465 for SMTPS)
define('MAILPORT', (int) mailEnv('MAIL_PORT', 587));

// Define SMTP encryption mode: starttls|smtps|none
define('MAIL_ENCRYPTION', strtolower(mailEnv('MAIL_ENCRYPTION', 'starttls')));

// SMTP debug flags (for Railway logs)
define('MAIL_DEBUG', filter_var(mailEnv('MAIL_DEBUG', 'false'), FILTER_VALIDATE_BOOLEAN));
define('MAIL_DEBUG_LEVEL', (int) mailEnv('MAIL_DEBUG_LEVEL', 2));

// SMTP timeout in seconds to avoid hanging requests
define('MAIL_TIMEOUT', (int) mailEnv('MAIL_TIMEOUT', 20));

// Optional Resend API config (preferred in cloud environments)
define('RESEND_API_KEY', mailEnv('RESEND_API_KEY'));
define('RESEND_FROM', mailEnv('RESEND_FROM', ''));
define('RESEND_REPLY_TO', mailEnv('RESEND_REPLY_TO', ''));
define('RESEND_TIMEOUT', (int) mailEnv('RESEND_TIMEOUT', 20));
 
// Define as a username the email that you use in your Gmail account.
define('USERNAME', mailEnv('MAIL_USER'));
 
// Define your 16 digit Gmail app-password.
define('PASSWORD', mailEnv('MAIL_PASSWORD'));
 
// Define the email address from which the email is sent.
define('SEND_FROM', mailEnv('MAIL_FROM'));
 
// Define the name of the website from which the email is sent. 
define('SEND_FROM_NAME', mailEnv('MAIL_FROM_NAME'));
 
// Define the reply-to address.
define('REPLY_TO', mailEnv('MAIL_REPLY_TO'));
 
// Define the reply-to name.
define('REPLY_TO_NAME', mailEnv('MAIL_REPLY_TO_NAME'));

// Validar configuración: se necesita Resend o SMTP
$smtpConfigured = MAILHOST && MAILPORT && USERNAME && PASSWORD && SEND_FROM && SEND_FROM_NAME && REPLY_TO && REPLY_TO_NAME;
$resendConfigured = !empty(RESEND_API_KEY);

if (!$smtpConfigured && !$resendConfigured) {
    trigger_error('Error: Configuración de email incompleta. Definí RESEND_API_KEY o las variables SMTP.', E_USER_ERROR);
}

?>