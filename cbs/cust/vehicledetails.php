<?php
include('../mysession.php');
if (!session_id()) {
    session_start();
}

if (isset($_GET['v_reg'])) {
    $vid = $_GET['v_reg'];
}
$title='Vehicles';
include('../dbconnect.php');

$sqlr = "SELECT * FROM tb_vehicle WHERE v_reg=?";
$stmt = $con->prepare($sqlr);
$stmt->bind_param('s', $vid);
$stmt->execute();
$resultr = $stmt->get_result();
$rowr = $resultr->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<?php include('head.php');?>

<style>
.value-container {
    border: 1px solid #ccc;
    padding: 10px;
    background-color: #f9f9f9;
    height:50px;
    width: 200px;
    text-align: center;
}
</style>

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

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="vehicleview.php">Vehicles</a>
          </li>
          <li class="breadcrumb-item active">Vehicle Details</li>
        </ol>



        <hr>
        <div class="card">
        <div class="card-header">
            View Vehicle Details
        </div>

        <div class="card form-group mx-auto d-flex justify-content-center" style="width: 30rem">
    <img src="../vendor/img/<?php echo isset($rowr) ? $rowr['v_pic'] : ''; ?>" class="card-img-top">
    <div class="card-body">
        <h5 class="card-title">Model : <?php echo isset($rowr) ? $rowr['v_model'] : ''; ?></h5>
        <h5 class="card-title">Registration Number : <?php echo isset($rowr) ? $rowr['v_reg'] : ''; ?></h5>
        <h5 class="card-title">Category : <?php echo isset($rowr) ? $rowr['v_type'] : ''; ?></h5>
        <h5 class="card-title">Colour : <?php echo isset($rowr) ? $rowr['v_colour'] : ''; ?></h5>
        <h5 class="card-title">Price Per Day : RM<?php echo isset($rowr) ? number_format($rowr['v_price'], 2) : ''; ?></h5>
    </div>
</div></div>
     
<hr>
      <!-- Sticky Footer -->
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

</body>

</html>
