<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to = $_POST["to"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    $mail = new PHPMailer;
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.hostinger.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'support@de1fl.com';                 // SMTP username
    $mail->Password = 'An940822?';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to
    $mail->From = 'support@de1fl.com';
    $mail->FromName = 'Support';
    //$mail->addAddress('Tony.Toniolo@duke-energy.com', 'Tony Toniolo');     // Add a recipient
    //$mail->addAddress('Tony.Toniolo@duke-energy.com');       // Name is optional
    $mail->addAddress('ghecu@hotmail.com', 'Giac Dinh');     // Add a recipient
    $mail->addAddress('ghecu@hotmail.com');       // Name is optional
    $mail->addReplyTo('support@de1fl.com', 'support@de1fl.com');
    //$mail->addCC('Gerald.Rooks@duke-energy.com');
    $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject; 
    $mail->Body    = $message;
    if(!$mail->send()) {
        file_put_contents("Log.txt", date('H:i:s m/d/Y',$now)." ".$mail->ErrorInfo." SMTP: Sending mail failed\n", FILE_APPEND | LOCK_EX);
        echo "Email sent successfully!";
    } else {
        file_put_contents("Log.txt", date('H:i:s m/d/Y',$now)."SMTP: Sending mail passed\n", FILE_APPEND | LOCK_EX);
        echo "Error sending email.";
    }
}
?>

