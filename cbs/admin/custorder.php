<?php 
include('../mysession.php');
if(!session_id())
{
  session_start();
}
include('../dbconnect.php');
$title='Customer';

if(isset($_GET['id']))
{
    $uid=$_GET['id'];
}

$sql=" SELECT * FROM tb_user LEFT JOIN tb_booking ON tb_booking.b_ic = tb_user.u_ic
LEFT JOIN tb_vehicle ON tb_vehicle.v_reg = tb_booking.b_req LEFT JOIN tb_status ON tb_status.s_id = tb_booking.b_status WHERE u_ic=$uid"; 


$result=mysqli_query($con,$sql);

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
          <a href="customer.php">Customers</a>
        </li>
        <li class="breadcrumb-item active">Customer Order </li>
      </ol>

      <!--Bookings-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fas fa-table"></i>
        Customer Order</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th scope="col">Booking ID</th>
                  <th scope="col">Vehicle</th>
                  <th scope="col">Pickup Date</th>
                  <th scope="col">Return Date</th>
                  <th scope="col">Total Rent</th>
                  <th scope="col">Status</th>
                </tr>
              </thead>

              <tbody>
                <?php
                while ($row = mysqli_fetch_array($result)) {
                  echo "<tr>";
                  echo "<td>" . $row['b_id'] . "</td>";
                   echo"<td>".$row['v_model']."</td>";
                  echo "<td>" . $row['b_pdate'] . "</td>";
                  echo "<td>" . $row['b_rdate'] . "</td>";
                  echo "<td>RM " . number_format((double)$row['b_total'], 2) . "</td>";
                  echo "<td>" . $row['s_desc'] . "</td>";
                  echo "</tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer small text-muted">
        </div>
      </div>
      <!-- /.container-fluid -->

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
  <script src="../vendor/datatables/jquery.dataTables.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../vendor/js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="../vendor/js/demo/datatables-demo.js"></script>
  <script src="../vendor/js/demo/chart-area-demo.js"></script>

</body>

</html>
