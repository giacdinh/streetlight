<html>
    <head>
    </head>
    <body>
    </body>
</html>
<?php
$poleid = $_GET['name'];
$issue = $_GET['report'];
$contact = $_GET['contact'];
$subdiv = $_GET['group'];
  
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
    sendemail($issue,$contact,$poleid,$subdiv);
$conn->close();

//Send email
function sendemail($issue,$contact,$poleid,$subdiv){
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    $from = "bacsonteam@bacson.tech";
    // Screen production ID and send to different email for monitoring
    // Remove when install after customer site
    $to = "deoneflsl@duke-energy.com";
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
    } else {
        //echo 'Unable to send email. Please try again.';
        http_response_code(503);
    }
}

?>
