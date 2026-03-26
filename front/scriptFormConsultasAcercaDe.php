<?php
require_once __DIR__ . '/../scriptPHPmailer.php';

function sendContactMail($email, $name, $message)
{
   $subject = 'Consulta de: ' . $name;
   $htmlMessage = '<p><strong>Nombre:</strong> ' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '</p>'
      . '<p><strong>Email:</strong> ' . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . '</p>'
      . '<p><strong>Consulta:</strong><br>' . nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8')) . '</p>';

   $sent = sendMail(USERNAME, $subject, $htmlMessage);
   if (!$sent) {
      return 'No se pudo enviar la consulta. Intenta nuevamente.';
   }

   return 'success';
}