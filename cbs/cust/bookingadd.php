<?php
include('../mysession.php');
if (!session_id()) {
  session_start();
}
include('../dbconnect.php');
$title='Bookings';

require '../vendor/autoload.php'; // Include PHPMailer autoloader
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

error_reporting(E_ALL);

function base_url($url = null)
{
    global $baseUrl;
    return $baseUrl . $url;
}

$error = []; // Initialize the error array

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve data registration from form
  $fvehicle = $_POST['fvehicle'];
  $fpdate = $_POST['fpdate'];
  $frdate = $_POST['frdate'];

  // Check if pickup date is earlier than the current date
  if (date('Y-m-d') > $fpdate) {
    $error['b_pdate'] = 'Pickup date cannot be earlier than today\'s date';
  }

  // Check if return date is earlier than pickup date
  if (strtotime($frdate) < strtotime($fpdate)) {
    $error['b_rdate'] = 'Return date cannot be earlier than pickup date';
  }

  $sql = "SELECT * FROM tb_vehicle LEFT JOIN tb_booking ON tb_booking.b_req = tb_vehicle.v_reg WHERE v_reg = '$fvehicle' AND b_status=2";
  $result = mysqli_query($con, $sql);
  $row = mysqli_fetch_array($result);

if (strtotime($frdate) >= strtotime($row['b_pdate']) && strtotime($fpdate) <= strtotime($row['b_rdate'])) {
  $error['availability'] = 'The chosen vehicle is not available on the selected dates.';
}

  // If there are no errors, proceed with booking
  if (empty($error)) {

    // Calculate total rent price
    // 1. Convert form date to ISOB...
    $start = date('Y-m-d H:i:s', strtotime($fpdate));
    $end = date('Y-m-d H:i:s', strtotime($frdate));
    // 2. Calculate number of days
    $daydiff = abs(strtotime($start) - strtotime($end)); //abs xde negative e.g. distance, time
    $daynum = $daydiff / (60 * 60 * 24); //in days (86400 sec per day)
    // 3. Get vehicle price from table
    $sqlp = "SELECT v_price FROM tb_vehicle WHERE v_reg='$fvehicle'";
    $resultp = mysqli_query($con, $sqlp);
    $rowp = mysqli_fetch_array($resultp);
    $totalprice = $daynum * ($rowp['v_price']);

    $suic = $_SESSION['suic'];
    $sql = "INSERT INTO tb_booking(b_ic, b_req, b_pdate, b_rdate, b_total, b_status)
      VALUES ('$suic', '$fvehicle', '$fpdate', '$frdate', '$totalprice', '2')";

      if (mysqli_query($con, $sql)) {
        $succ = "Booking successful.";
      $_SESSION['b_id'] = mysqli_insert_id($con); // Store the last inserted booking ID
      $_SESSION['daynum'] = $daynum; // Store the calculated number of days
      $_SESSION['totalprice'] = $totalprice; // Store the total price
      $dateRangeQuery = "UPDATE tb_vehicle SET v_status = 2 WHERE v_reg = '$fvehicle' AND v_reg IN (
  SELECT b_req FROM tb_booking WHERE (b_pdate <= '$frdate' AND b_rdate >= '$fpdate')
)";
mysqli_query($con, $dateRangeQuery);

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
$mail->Subject = 'New Booking Confirmation';
    $mail->Body = "
    <html>
    <body>
      <p>Dear Customer,</p>
      <p>Your booking has been confirmed. Thank you for choosing our service. Here's your booking details!</p>
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
    echo 'Email sent successfully.';
} else {
    echo 'Error sending email: ' . $mail->ErrorInfo;
}



      header('Location: bookingsuccess.php');
      exit;
    } else {
      $err = "Failed to process booking.";
    }
  }
}

include('head.php');
?>

<!DOCTYPE html>
<html lang="en">

<?php include('head.php');?>

<body id="page-top">
 <!--Start Navigation Bar-->
 <?php include("nav.php");?>
 <!--Navigation Bar-->

 <div id="wrapper">

  <!-- Sidebar -->
  <?php include("sidebar.php");?>
  <!--End Sidebar-->
  <div id="content-wrapper">

    <div class="container-fluid">
      <?php if(isset($succ)) {?>
        <!--This code for injecting an alert-->
        <script>
          setTimeout(function () 
          { 
            swal("Success!","<?php echo $succ;?>!","success");
          },
          100);
        </script>

      <?php } ?>
      <?php if(isset($err)) {?>
        <!--This code for injecting an alert-->
        <script>
          setTimeout(function () 
          { 
            swal("Failed!","<?php echo $err;?>!","Failed");
          },
          100);
        </script>

      <?php } ?>

      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="bookingview.php">Manage Bookings</a>
        </li>
        <li class="breadcrumb-item active">Add Booking</li>
      </ol>
      <hr>
      <div class="card">
        <div class="card-header">
          Confirm Booking
        </div>
        <div class="card-body">
          <!--Add User Form-->
              <form method ="POST">
                <div class="form-group">
                  <label for="exampleInputPassword1" class="form-label mt-4">Select Vehicle</label>

                  <?php
                  $sql="SELECT * FROM tb_vehicle WHERE v_status!=0";
                  $result=mysqli_query($con,$sql);

                  echo'<select name="fvehicle" class="form-control" id="exampleSelect1">';
                  while($row=mysqli_fetch_array($result))
                  {
                    echo"<option value='".$row['v_reg']."'>".$row['v_model'].",RM".$row['v_price']."</option>";
                  }
                  
                  echo '</select>';
                  ?>

                </div>

                <div class="form-group">
                  <label for="exampleInputPassword1" class="form-label mt-4">Pickup Date</label>
                  <input type="date" name="fpdate" class="form-control" id="exampleInputPassword1" placeholder="Select Pickup Date" autocomplete="off" required>
                  <?php if (!empty($error['b_pdate'])) {
                  echo '<p class="text-danger">' . $error['b_pdate'] . '</p>';
                } ?>
                </div>

                <div class="form-group">
                  <label for="exampleInputPassword1" class="form-label mt-4">Return Date</label>
                  <input type="date" name="frdate" class="form-control" id="exampleInputPassword1" placeholder="Select Return Date" autocomplete="off" required>
                  <?php if (!empty($error['b_rdate'])) {
                  echo '<p class="text-danger">' . $error['b_rdate'] . '</p>';
                } ?>
                </div>
                
                <button type="submit" class="btn btn-primary">Book</button>
                <button type="reset" class="btn btn-dark">Reset</button>
              </form>
              <!-- End Form-->
          </div>
        </div></div>
        
        <hr>

        <!-- Sticky Footer -->
        

        </div>
      <!-- /.content-wrapper -->

</div>
    <!-- /#wrapper -->
        
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-danger" href="../logout.php">Logout</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Page level plugin JavaScript-->
    <script src="../vendor/chart.js/Chart.min.js"></script>
    <script src="../vendor/datatables/jquery.dataTables.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../vendor/js/sb-admin.min.js"></script>

    <!-- Demo scripts for this page-->
    <script src="../vendor/js/demo/datatables-demo.js"></script>
    <script src="../vendor/js/demo/chart-area-demo.js"></script>
    <!--INject Sweet alert js-->
    <script src="../vendor/js/swal.js"></script>
    <?php if (isset($error['availability'])): ?>
  <script>alert('<?php echo $error['availability']; ?>');</script>
<?php endif; ?>

  </body>

  </html>
