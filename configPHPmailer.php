<?php
// Load environment variables
require_once __DIR__ . '/config/Load.php';

// Define the Gmail smtp server
define('MAILHOST', env('MAIL_HOST'));
 
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
if (!MAILHOST || !USERNAME || !PASSWORD || !SEND_FROM || !SEND_FROM_NAME || !REPLY_TO || !REPLY_TO_NAME) {
    trigger_error('Error: Variables de entorno de email no configuradas. Definilas en Railway o en el archivo .env local.', E_USER_ERROR);
}

?>