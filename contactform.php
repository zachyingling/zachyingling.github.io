<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Loading dotenv to create environment variables
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$dotenv->required('GOOGLE_PASS')->notEmpty();

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

if (isset($_POST['submit'])) {
  try {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $fullname = $name.' '.$surname;
    $email = $_POST['email'];
    $message = $_POST['message'];

    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->SMTPSecure = 'tls';
    $mail->Username   = 'zachyingling9559@gmail.com';                     // SMTP username
    $mail->Password   = $_ENV['GOOGLE_PASS'];                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom($email, $fullname);
    $mail->addAddress('zachyingling9559@gmail.com');     // Add a recipient

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $fullname;
    $mail->Body = 'From: '.$email.'<br/><br/>'.$message;

    $mail->send();
    echo 'Message has been sent';
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}
