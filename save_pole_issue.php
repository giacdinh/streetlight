<html>
    <head>
    </head>
    <body>
    </body>
</html>
<?php
/* ************************ NOTE **********************************/
/* This save pole issue use QR code page */
$poleid = $_GET['poleid'];
$issue = $_GET['poleissue'];
$contact = $_GET['cinfo'];
$subdiv = $_GET['groupname'];
  
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
$rquery = "UPDATE `sub_light` set report='$issue',rport_time=$now,cust_resp='$contact' where poleid=\"$poleid\"";
echo $rquery;
$result = mysqli_query($conn, $rquery);
if(!$result) {
        echo "<div style='font-size:75px ;color:red'>DBase update failed.</div>";
        die("DBase insert failed: " . mysqli_query_error());
}
echo "<div style='font-size:75px ;color:green'>Update pole issue report successed</div>";
file_put_contents("Log.txt", date('H:i:s m/d/Y',$now)."Entering send mail from save pole issue\n", FILE_APPEND | LOCK_EX);
sendemail($issue,$contact,$poleid,$subdiv);

$conn->close();

function sendemail($issue,$contact,$poleid,$subdiv){
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    //$from = "bacsonteam@bacson.tech";
    $from = "ghecu@hotmail.com";
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
	file_put_contents("Log.txt", date('H:i:s m/d/Y',$now)."Poleissue: Sending mail passed\n", FILE_APPEND | LOCK_EX);
    } else {
        //echo 'Unable to send email. Please try again.';
	file_put_contents("Log.txt", date('H:i:s m/d/Y',$now)."Poleissue: Sending mail failed\n", FILE_APPEND | LOCK_EX);
        http_response_code(503);
    }
}

?>
