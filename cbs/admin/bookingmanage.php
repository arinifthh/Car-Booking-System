<?php 
include('../mysession.php');
if(!session_id())
{
  session_start();
}
include('../dbconnect.php');
$title='Bookings';

$sql=" SELECT * FROM tb_booking 
LEFT JOIN tb_vehicle ON tb_booking.b_req=tb_vehicle.v_reg
LEFT JOIN tb_status ON tb_booking.b_status = tb_status.s_id WHERE tb_booking.b_rdate >= CURDATE() ";

$result=mysqli_query($con,$sql);

if (isset($_GET['b_id']) && isset($_GET['action']) && $_GET['action'] === 'approve') {
    $b_id = $_GET['b_id'];
    $status = 2;

    // Update the b_status column in the database
    $sql = "UPDATE tb_booking SET b_status = $status WHERE b_id = $b_id";
    mysqli_query($con, $sql);
}

if (isset($_GET['b_id']) && isset($_GET['action']) && $_GET['action'] === 'reject') {
    $b_id = $_GET['b_id'];
    $status = 3;

    // Update the b_status column in the database
    $sql = "UPDATE tb_booking SET b_status = $status WHERE b_id = $b_id";
    mysqli_query($con, $sql);

}

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
        <h5 class="breadcrumb-item active">Manage Bookings </h5>
      </ol>

      <!--Bookings-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fas fa-table"></i>
        Bookings</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th scope="col">Booking ID</th>
                  <th scope="col">Customer ID</th>
                  <th scope="col">Vehicle</th>
                  <th scope="col">Pickup Date</th>
                  <th scope="col">Return Date</th>
                  <th scope="col">Total Rent</th>
                  <th scope="col">Status</th>
                  <th scope="col">Operation</th>
                </tr>
              </thead>

              <tbody>
                <?php
                while ($row = mysqli_fetch_array($result)) {
                  echo "<tr>";
                  echo "<td>" . $row['b_id'] . "</td>";
                   echo"<td>".$row['b_ic']."</td>";
                  echo "<td>" . $row['v_model'] . "</td>";
                  echo "<td>" . $row['b_pdate'] . "</td>";
                  echo "<td>" . $row['b_rdate'] . "</td>";
                  echo "<td>RM". number_format($row['b_total'], 2) . "</td>";
                  echo "<td>" . $row['s_desc'] . "</td>";
                  echo "<td>";
                  echo "<div class='dropdown mb-4'>
                  <a class='btn btn-outline-dark dropdown-toggle' href='#' role='button' data-toggle='dropdown'>
                  Action
                  </a>
                  <div class='dropdown-menu dropdown-menu-right'>
                  <a class='dropdown-item' href='bookingdetail.php?id=" . $row['b_id'] . "'>View Detail</a>";
                  
                    if ($row['b_status'] == 2) {
                    echo "<a class='dropdown-item' href='?b_id=" . $row['b_id'] . "&action=reject' onclick='return confirm(\"Are you sure you want to reject this booking?\")'>Reject</a>";
                  }

                  

                  echo "</div>
                  </div>";
                  echo "</td>";
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
