<?php 
/**
   We have to require the path to the PHPMailer classes.
*/
require 'PHPmailer/Exception.php';
require 'PHPmailer/PHPMailer.php';
require 'PHPmailer/SMTP.php';
/**
 * We have to put the PHPMailer namespaces at the top of the page.
*/

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
 
/*
   We have to require the config.php file to use our 
   Gmail account login details.
*/
require 'configPHPmailer.php';

function sendMailWithResend($email, $subject, $message)
{
   $from = RESEND_FROM !== '' ? RESEND_FROM : SEND_FROM;
   $replyTo = RESEND_REPLY_TO !== '' ? RESEND_REPLY_TO : REPLY_TO;

   $payload = [
      'from' => $from,
      'to' => [$email],
      'subject' => $subject,
      'html' => $message,
      'reply_to' => $replyTo,
   ];

   $endpoint = 'https://api.resend.com/emails';
   $headers = [
      'Authorization: Bearer ' . RESEND_API_KEY,
      'Content-Type: application/json',
   ];

   if (function_exists('curl_init')) {
      $ch = curl_init($endpoint);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_TIMEOUT, max(5, RESEND_TIMEOUT));

      $response = curl_exec($ch);
      $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
      $curlError = curl_error($ch);
      curl_close($ch);

      if ($response === false || $curlError) {
         error_log('Resend cURL error: ' . $curlError);
         return false;
      }

      if ($httpCode < 200 || $httpCode >= 300) {
         error_log('Resend HTTP error ' . $httpCode . ': ' . (string) $response);
         return false;
      }

      return true;
   }

   $context = stream_context_create([
      'http' => [
         'method' => 'POST',
         'header' => "Authorization: Bearer " . RESEND_API_KEY . "\r\n" . "Content-Type: application/json\r\n",
         'content' => json_encode($payload),
         'timeout' => max(5, RESEND_TIMEOUT),
      ],
   ]);

   $response = @file_get_contents($endpoint, false, $context);
   if ($response === false) {
      error_log('Resend stream error: request failed');
      return false;
   }

   return true;
}

function sendMailWithBrevo($email, $subject, $message)
{
   // Debug: Verificar que la API key esté configurada
   if (empty(BREVO_API_KEY)) {
      error_log('BREVO_API_KEY está vacío o no definido');
      return false;
   }

   if (empty(SEND_FROM) || empty(SEND_FROM_NAME)) {
      error_log('SEND_FROM o SEND_FROM_NAME están vacíos');
      return false;
   }

   $payload = [
      'sender' => [
         'email' => SEND_FROM,
         'name' => SEND_FROM_NAME,
      ],
      'to' => [
         [
            'email' => $email,
         ],
      ],
      'subject' => $subject,
      'htmlContent' => $message,
      'replyTo' => [
         'email' => REPLY_TO,
         'name' => REPLY_TO_NAME,
      ],
   ];

   $endpoint = 'https://api.brevo.com/v3/smtp/email';
   $headers = [
      'api-key: ' . BREVO_API_KEY,
      'Content-Type: application/json',
   ];

   error_log('Brevo: Enviando email a ' . $email . ' desde ' . SEND_FROM);

   if (function_exists('curl_init')) {
      $ch = curl_init($endpoint);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_TIMEOUT, max(5, BREVO_TIMEOUT));

      $response = curl_exec($ch);
      $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
      $curlError = curl_error($ch);
      curl_close($ch);

      error_log('Brevo cURL - HTTP Code: ' . $httpCode . ', Response: ' . (string) $response);

      if ($response === false || $curlError) {
         error_log('Brevo cURL error: ' . $curlError);
         return false;
      }

      if ($httpCode < 200 || $httpCode >= 300) {
         error_log('Brevo HTTP error ' . $httpCode . ': ' . (string) $response);
         return false;
      }

      error_log('Brevo email enviado exitosamente');
      return true;
   }

   $context = stream_context_create([
      'http' => [
         'method' => 'POST',
         'header' => "api-key: " . BREVO_API_KEY . "\r\n" . "Content-Type: application/json\r\n",
         'content' => json_encode($payload),
         'timeout' => max(5, BREVO_TIMEOUT),
      ],
   ]);

   $response = @file_get_contents($endpoint, false, $context);
   
   error_log('Brevo stream - Response: ' . (string) $response);

   if ($response === false) {
      error_log('Brevo stream error: request failed (possible API key issue or network)');
      return false;
   }

   error_log('Brevo email enviado exitosamente (stream fallback)');
   return true;
}
 

 
/**
 * The function uses the PHPMailer object to send an email 
 * to the address we specify.
 * @param  [string] $email, [Where our email goes]
 * @param  [string] $subject, [The email's subject]
 * @param  [string] $message, [The message]
 * @return [string]          [Error message, or success]
 */
function sendMail($email, $subject, $message){
   error_log('sendMail() called - BREVO_API_KEY: ' . (empty(BREVO_API_KEY) ? 'EMPTY' : 'SET'));
   error_log('sendMail() called - RESEND_API_KEY: ' . (empty(RESEND_API_KEY) ? 'EMPTY' : 'SET'));
   
   // Try Brevo first (best for students without domain)
   if (!empty(BREVO_API_KEY)) {
      error_log('Using Brevo email service');
      return sendMailWithBrevo($email, $subject, $message);
   }

   // Fallback to Resend
   if (!empty(RESEND_API_KEY)) {
      error_log('Using Resend email service');
      return sendMailWithResend($email, $subject, $message);
   }

   // Final fallback to SMTP (traditional method)
   try {
      // Creating a new PHPMailer object.
      $mail = new PHPMailer(true);

      if (MAIL_DEBUG) {
         $mail->SMTPDebug = max(0, min(4, MAIL_DEBUG_LEVEL));
         $mail->Debugoutput = 'error_log';
      }
 
   // If you want to see the email process uncomment the 
   // SMTPDebug property.  
   // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
 
   // Using the SMTP protocol to send the email.
   $mail->isSMTP();
 
   /* 
      Setting the SMTPAuth property to true, so we can use 
      our Gmail login	details to send the mail.
   */	
      $mail->SMTPAuth = true;
 
   /*  
      Setting the Host property to the MAILHOST value 
      that we define in the config file.
   */	
      $mail->Host = MAILHOST;
 
   /*  Setting the Username property to the USERNAME value 
      that we define in the config file.
   */	
      $mail->Username = USERNAME;
 
   /*
      Setting the Password property to the PASSWORD value 
      that we define in the config file.
   */	
      $mail->Password = PASSWORD;

      // Prevent long hangs on network/auth issues
      $mail->Timeout = max(5, MAIL_TIMEOUT);
      $mail->SMTPKeepAlive = false;
    
   /*
      By setting SMTPSecure to PHPMailer::ENCRYPTION_STARTTLS, 
      we are telling PHPMailer to use the STARTTLS encryption 
      method when connecting to the SMTP server. 
      This helps ensure that the communication between your 
      PHP application and the SMTP server is encrypted, adding a 
      layer of security to your	email sending process.
   */
      if (MAIL_ENCRYPTION === 'smtps' || MAIL_ENCRYPTION === 'ssl') {
         $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
      } elseif (MAIL_ENCRYPTION === 'none' || MAIL_ENCRYPTION === '') {
         $mail->SMTPSecure = false;
         $mail->SMTPAutoTLS = false;
      } else {
         $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      }
 
   // TCP port to connect with the SMTP server.
      $mail->Port = MAILPORT;
 
   /*
      Who is sending the email. Again we use the constants 
      that we define in	the config file.
    */
      $mail->setFrom(SEND_FROM, SEND_FROM_NAME);
 
   /*
      Where the mail goes. We use the $email function's 
      parameter that holds the email address that we type 
      in the email input field. 
    */
      $mail->addAddress($email);
 
   /*
      The 'addReplyTo' property specifies where the 
      recipient can reply to.
      Again we use the constants from the config file.
    */
      $mail->addReplyTo(REPLY_TO, REPLY_TO_NAME);
 
   /*
      By setting $mail->IsHTML(true), we inform PHPMailer that 
      the email message	we're constructing will include 
      HTML markup. 
      This is important when we want to send emails with 
      HTML formatting, which allow us to include things like 
      hyperlinks, images, formatting, 
      and other HTML elements in our email content.
    */
      $mail->IsHTML(true);
 
   /*
      Assigning the incoming subject to the 
      $mail->subject property. 	
    */
      $mail->Subject = $subject;
 
   /*
      Assigning the incoming message to the $mail->body property.
    */
      $mail->Body = $message;
 
   /*
      When we set $mail->AltBody, we are providing 
      a plain text alternative to the HTML version of our email. 
      This is important for compatibility with email clients 
      that may not support or display HTML content. 
      In such cases, the email client will display 
      the plain text content instead of the HTML content.
    */
      $mail->AltBody = $message;
   
   /*
      And last we send the email.
      If something goes wrong the function will return an error,
      else the function returns the string success.
      We are going to catch the returned value in the index file,
      and display it in the HTML form.
    */
      if (!$mail->send()) {
         error_log('SMTP send error: ' . $mail->ErrorInfo);
         return false;
      }

      return true;
   } catch (Exception $e) {
      error_log('SMTP exception: ' . $e->getMessage());
      return false;
   } catch (\Throwable $e) {
      error_log('SMTP throwable: ' . $e->getMessage());
      return false;
   }
}