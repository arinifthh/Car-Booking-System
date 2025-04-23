<?php 
include('../mysession.php');
if(!session_id())
{
  session_start();
}
include('../dbconnect.php');

  $suic=$_SESSION['suic'];

  if(isset($_GET['id']))
{
    $fbid=$_GET['id'];
}

  $sql="  SELECT * FROM tb_booking 
          LEFT JOIN tb_vehicle ON tb_booking.b_req=tb_vehicle.v_reg
          LEFT JOIN tb_status ON tb_booking.b_status = tb_status.s_id
          LEFT JOIN tb_user ON tb_booking.b_ic = tb_user.u_ic
          WHERE b_id=$fbid";

  $result=mysqli_query($con,$sql);
  $row=mysqli_fetch_array($result);

?>
<!DOCTYPE html>
<html lang="en">

<?php include('head.php');?>

<body id="page-top">

 <?php include("nav.php");?>


 <div id="wrapper">

  <!-- Sidebar -->
  <?php include('sidebar.php');?>

  <div id="content-wrapper">

    <div class="container-fluid">

      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="bookingmanage.php">Manage Bookings</a>
        </li>
        <li class="breadcrumb-item active"> Booking Details</li>
      </ol>


<div class="container">

  <h1>Booking Details</h1>
  <table class="table table-hover">
    <tbody>
      <tr>
        <td>Booking ID</td>
        <td><?php echo $row['b_id'];?></td>
      </tr>
      <tr>
        <td>User ID</td>
        <td><?php echo $row['u_ic'];?></td>
      </tr>
      <tr>
        <td>User Name</td>
        <td><?php echo $row['u_name'];?></td>
      </tr>
      <tr>
        <td>Vehicle ID</td>
        <td><?php echo $row['b_req'];?></td>
      </tr>
      <tr>
        <td>Vehicle Model</td>
        <td><?php echo $row['v_model'];?></td>
      </tr>
      <tr>
        <td>Pickup Date</td>
        <td><?php echo $row['b_pdate'];?></td>
      </tr>
      <tr>
        <td>Return Date</td>
        <td><?php echo $row['b_rdate'];?></td>
      </tr>
      <tr>
        <td>Price per day</td>
        <td>RM<?php echo (number_format($row['v_price'],2));?></td>
      </tr>
      <tr>
        <td>Total Price</td>
        <td>RM<?php echo (number_format($row['b_total'],2));?></td>
      </tr>
      <tr>
        <td></td><td></td>
      </tr>
  <tbody>
    
</table>
</div>

<?php include("footer.php");?>
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
          <a class="btn btn-danger" href="admin-logout.php">Logout</a>
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
  <script src="../vendor/datatables/jquery.dataTables.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../vendor/js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="../vendor/js/demo/datatables-demo.js"></script>
  <script src="../vendor/js/demo/chart-area-demo.js"></script>

</body>

</html>
