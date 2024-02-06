<html>
    <head>
    </head>
    <body>
    </body>
</html>
<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require './PHPMailer/src/Exception.php';
    require './PHPMailer/src/PHPMailer.php';
    require './PHPMailer/src/SMTP.php';

$poleid = $_GET['name'];
$issue = $_GET['report'];
$contact = $_GET['contact'];
$subdiv = $_GET['group'];
$note = $_GET['note'];
  
echo "PoleID: $poleid with $issue <br>";
$now = time();
//get database config information
    $json = file_get_contents('./backend.json');
    $json_data = json_decode($json,true);
    $server    = $json_data["servername"];
    $database  = $json_data["database"];
    $username  = $json_data["username"];
    $password  = $json_data["password"];

$conn = mysqli_connect($server, $username, $password, $database);
if(!$conn) {
        echo "DBase connect failed";
        die("Connection failed: " . mysqli_connect_error());
        echo "DBase connect failed";
}
$rquery = "UPDATE `sub_light` set report='$issue',rport_time=$now,cust_resp='$contact',notes='$note' where poleid=\"$poleid\" AND groupname=\"$subdiv\"";

$result = mysqli_query($conn, $rquery);
if(!$result) {
        echo "<div style='font-size:75px ;color:red'>DBase update failed.</div>";
        die("DBase insert failed: " . mysqli_query_error());
}
echo "<div style='font-size:75px ;color:green'>Update pole issue report successed</div>";
file_put_contents("Log.txt", date('H:i:s m/d/Y',$now)."Entering send mail from save pole issue\n", FILE_APPEND | LOCK_EX);
//sendemail($issue,$contact,$poleid,$subdiv);
sendsmtp($issue,$contact,$poleid,$subdiv);
$conn->close();

//Send email
function sendemail($issue,$contact,$poleid,$subdiv){
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    $from = "bacsonteam@de1fl.com";
    // Screen production ID and send to different email for monitoring
    // Remove when install after customer site
    $to = "ghecu@hotmail.com";
    $subject = "StreetLight Issue report";


    // To send HTML mail, the Content-type header must be set
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    // Create email headers
    $headers .= 'From: ' . $from . "\r\n" .
        'Reply-To: ' . $from . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    $message = '<html><body>';
    $message .= '<p style="color:#3498DB;font-size:18px;">Subdivision:' . $subdiv . '</p>';
    $message .= '<p style="color:#3498DB;font-size:18px;">PoleID:' . $poleid . '</p>';
    $message .= '<p style="color:#3498DB;font-size:18px;">Issue:' . $issue . '</p>';
    $message .= '<p style="color:#3498DB;font-size:18px;">Contact:' . $contact. '</p>';
    $message .= '</body></html>';

    if (mail($to, $subject, $message, $headers)) {
        //echo 'Your mail has been sent successfully.';
        http_response_code(200);
	file_put_contents("Log.txt", date('H:i:s m/d/Y',$now)."Polereport: Sending mail passed\n", FILE_APPEND | LOCK_EX);
    } else {
        //echo 'Unable to send email. Please try again.';
        http_response_code(503);
	file_put_contents("Log.txt", date('H:i:s m/d/Y',$now)."Polereport: Sending mail failed\n", FILE_APPEND | LOCK_EX);
    }
}
function sendsmtp($issue,$contact,$poleid,$subdiv) {
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
    $mail->Subject = 'Email send from Support@DE1FL.COM';
    $message = '<html><body>';
    $message .= '<p style="color:#3498DB;font-size:18px;">Subdivision:' . $subdiv . '</p>';
    $message .= '<p style="color:#3498DB;font-size:18px;">PoleID:' . $poleid . '</p>';
    $message .= '<p style="color:#3498DB;font-size:18px;">Issue:' . $issue . '</p>';
    $message .= '<p style="color:#3498DB;font-size:18px;">Contact:' . $contact. '</p>';
    $message .= '</body></html>';
    $mail->Body    = $message;
    if(!$mail->send()) {
        file_put_contents("Log.txt", date('H:i:s m/d/Y',$now)." ".$mail->ErrorInfo." SMTP: Sending mail failed\n", FILE_APPEND | LOCK_EX);
    } else {
        file_put_contents("Log.txt", date('H:i:s m/d/Y',$now)."SMTP: Sending mail passed\n", FILE_APPEND | LOCK_EX);
    }
}
?>
