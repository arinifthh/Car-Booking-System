<?php
//Parameters
date_default_timezone_set('Asia/Kuala_Lumpur');
$servername="localhost";
$username="root";
$password="";
$dbname="db_cbs";

$phpMailerHost = 'smtp.gmail.com';
$phpMailerPassword = 'wyyq dxpv nmuw tgbl';
$phpMailerUsername = 'airilfahim@gmail.com';

//Connection
$con=mysqli_connect($servername,$username,$password,$dbname);

if ($con->connect_errno) {
    die("Failed to connect with MySQL: " . $con->connect_error);
}

$baseUrl = 'http://localhost/cbs/';

/*function base_url($url = null)
{
    global $baseUrl;
    return $baseUrl . $url;
}

function alert($message, $type = 'info')
{
    // bootsrap 4 alert
    $text = '<div class="alert alert-' . $type . ' alert-dismissible fade show" role="alert">';
    $text .= $message;
    $text .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
    $text .= '<span aria-hidden="true">&times;</span>';
    $text .= '</button>';
    $text .= '</div>';
    return $text;
}*/

?>