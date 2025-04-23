<?php
include('../mysession.php');
if (!session_id()) {
  session_start();
}
include('../dbconnect.php');

$b_id = $_SESSION['b_id'];
$daynum = $_SESSION['daynum'];
$totalprice = $_SESSION['totalprice'];

$sql = "SELECT * FROM tb_booking LEFT JOIN tb_status ON tb_booking.b_status = tb_status.s_id WHERE b_id='$b_id'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result); // Fetch the row as an associative array

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
echo "<p>Thank You For Your Booking. Here's your booking details!</p>";
echo "<div style='border: 1px solid #ccc; padding: 10px;'>";
echo "<h4>Booking Details</h4>";
echo "<p><strong>Customer ID:</strong> " . $row['b_ic'] . "</p>";
echo "<p><strong>Booking ID:</strong> " . $b_id . "</p>";
echo "<p><strong>Vehicle Registration Number:</strong> " . $row['b_req'] . "</p>";
echo "<p><strong>Pickup Date:</strong> " . $row['b_pdate'] . "</p>";
echo "<p><strong>Return Date:</strong> " . $row['b_rdate'] . "</p>";
echo "<p><strong>Duration:</strong> " . $daynum . "</p>";
echo "<p><strong>Status:</strong> " . $row['s_desc'] . "</p>";
echo "<p><strong>Total Price:</strong> " . $totalprice . "</p>";
echo "</div>";
echo "<br><p>Check Your Email For Booking Confirmation!</p>";
?>

</div>
    </div>
    <!-- /.content-wrapper -->
  </div>
  <!-- /#wrapper -->
</body>

</html>