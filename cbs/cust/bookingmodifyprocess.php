<?php
include('../mysession.php');
if (!session_id()) {
  session_start();
}
include('../dbconnect.php');

require '../vendor/autoload.php'; // Include PHPMailer autoloader
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

error_reporting(E_ALL);

function base_url($url = null)
{
    global $baseUrl;
    return $baseUrl . $url;
}

// Assuming $_SESSION['b_id'], $_SESSION['daynum'], and $_SESSION['totalprice'] are set elsewhere
$suic = $_SESSION['suic'];
// Fetch the booking details
$fbid = $_SESSION['fbid'];
$daynum = $_SESSION['daynum'];
$totalprice = $_SESSION['totalprice'];

$sql = "SELECT * FROM tb_booking LEFT JOIN tb_status ON tb_booking.b_status = tb_status.s_id WHERE b_id='$fbid'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result); // Fetch the row as an associative array

$sqlem = "SELECT * FROM tb_user LEFT JOIN tb_booking ON tb_booking.b_ic = tb_user.u_ic WHERE u_ic = '$suic'";
$resultem = mysqli_query($con, $sqlem);
$rowem = mysqli_fetch_array($resultem);

$to = $rowem['u_email'];
$bid = $_SESSION['b_id'];

$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = $phpMailerHost;
$mail->SMTPAuth = true;
$mail->Username = $phpMailerUsername;
$mail->Password = $phpMailerPassword;
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->isHTML(true);
$mail->setFrom($mail->Username, 'ABC Car Rental');
$mail->addAddress($to);

// Set the email subject and body
$mail->Subject = 'Update Booking Confirmation';
    $mail->Body = "
    <html>
    <body>
      <p>Dear Customer,</p>
      <p>Your updated booking has been confirmed. Thank you for choosing our service. Here's your new booking details!</p>
      <div style='border: 1px solid #ccc; padding: 10px;'>
        <h4>Booking Details</h4>
        <p><strong>Customer ID:</strong> " . $rowem['b_ic'] . "</p>
        <p><strong>Booking ID :</strong> " . $bid . "</p>
        <p><strong>Vehicle Registration Number:</strong> " . $rowem['b_req'] . "</p>
        <p><strong>Pickup Date :</strong> " . $rowem['b_pdate'] . "</p>
        <p><strong>Return Date :</strong> " . $rowem['b_rdate'] . "</p>
        <p><strong>Total Price :</strong> " . $totalprice . "</p>
      </div>
    </body>
    </html>
";

$headers = "From: ABC Rental";

// Send the email
if ($mail->send()) {
    echo "<script>alert('Email sent successfully.');</script>";
} else {
    echo "<script>alert('Error sending email: " . $mail->ErrorInfo . "');</script>";
}

include('head.php');
?>

<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>

<body id="page-top">
  <!--Start Navigation Bar-->
  <?php include("nav.php"); ?>
  <!--Navigation Bar-->

  <div id="wrapper">

    <!-- Sidebar -->
    <?php include("sidebar.php"); ?>
    <!--End Sidebar-->

    <div id="content-wrapper">
      <div class='container'>
<?php        
echo "<p>Thank You For Your Booking. Here's your new booking details!</p>";
echo "<div style='border: 1px solid #ccc; padding: 10px;'>";
echo "<h4>Booking Details</h4>";
echo "<p><strong>Customer ID:</strong> " . $row['b_ic'] . "</p>";
echo "<p><strong>Booking ID:</strong> " . $fbid . "</p>";
echo "<p><strong>Vehicle Registration Number:</strong> " . $row['b_req'] . "</p>";
echo "<p><strong>Pickup Date:</strong> " . $row['b_pdate'] . "</p>";
echo "<p><strong>Return Date:</strong> " . $row['b_rdate'] . "</p>";
echo "<p><strong>Duration:</strong> " . $daynum . "</p>";
echo "<p><strong>Status:</strong> " . $row['s_desc'] . "</p>";
echo "<p><strong>Total Price:</strong> " . $totalprice . "</p>";
echo "</div><br>";
echo "<p>Check Your Email For Updated Booking Confirmation!</p>";
?>

</div>
    </div>
  </div>
  <!-- /#wrapper -->
</body>

</html>