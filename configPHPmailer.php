<?php
// Load environment variables
require_once __DIR__ . '/config/Load.php';

// Define the Gmail smtp server
define('MAILHOST', env('MAIL_HOST'));

// Define SMTP port (587 for STARTTLS, 465 for SMTPS)
define('MAILPORT', (int) env('MAIL_PORT', 587));

// Define SMTP encryption mode: starttls|smtps|none
define('MAIL_ENCRYPTION', strtolower((string) env('MAIL_ENCRYPTION', 'starttls')));

// SMTP debug flags (for Railway logs)
define('MAIL_DEBUG', filter_var(env('MAIL_DEBUG', 'false'), FILTER_VALIDATE_BOOLEAN));
define('MAIL_DEBUG_LEVEL', (int) env('MAIL_DEBUG_LEVEL', 2));

// SMTP timeout in seconds to avoid hanging requests
define('MAIL_TIMEOUT', (int) env('MAIL_TIMEOUT', 20));
 
// Define as a username the email that you use in your Gmail account.
define('USERNAME', env('MAIL_USER'));
 
// Define your 16 digit Gmail app-password.
define('PASSWORD', env('MAIL_PASSWORD'));
 
// Define the email address from which the email is sent.
define('SEND_FROM', env('MAIL_FROM'));
 
// Define the name of the website from which the email is sent. 
define('SEND_FROM_NAME', env('MAIL_FROM_NAME'));
 
// Define the reply-to address.
define('REPLY_TO', env('MAIL_REPLY_TO'));
 
// Define the reply-to name.
define('REPLY_TO_NAME', env('MAIL_REPLY_TO_NAME'));

// Validar que todas las variables de entorno estén configuradas
if (!MAILHOST || !MAILPORT || !USERNAME || !PASSWORD || !SEND_FROM || !SEND_FROM_NAME || !REPLY_TO || !REPLY_TO_NAME) {
    trigger_error('Error: Variables de entorno de email no configuradas. Definilas en Railway o en el archivo .env local.', E_USER_ERROR);
}

?>