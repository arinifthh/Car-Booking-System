<?php 
include('../mysession.php');
if(!session_id())
{
  session_start();
}
include('../dbconnect.php');
$title='Vehicles';

$ret="SELECT * FROM tb_vehicle";
$result=mysqli_query($con,$ret);

if (isset($_GET['v_reg']) && isset($_GET['action']) && $_GET['action'] === 'delete') {
    $v_reg = $_GET['v_reg'];
    $status = 0;

    // Update the b_status column in the database
    $sql = "UPDATE tb_vehicle SET v_status = $status WHERE v_reg = '$v_reg'";
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
        <h5 class="breadcrumb-item active"> Vehicles</h5>
      </ol>

      <!-- DataTables Example -->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fas fa-bus"></i>
        Vehicles</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Model</th>
                  <th>Registration Number</th>
                  <th>Type</th>
                  <th>Colour</th>
                  <th>Price (per Day)</th>
                  <th>Status</th>
                  <th>Operation</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $cnt=1;
                while ($row = mysqli_fetch_array($result)) {
                  echo "<tr>";
                  echo "<td>" . $cnt . "</td>";
                  echo "<td>" . $row['v_model'] . "</td>";
                  echo "<td>" . $row['v_reg'] . "</td>";
                  echo "<td>" . $row['v_type'] . "</td>";
                  echo "<td>" . $row['v_colour'] . "</td>";
                  echo "<td>RM " . number_format((double)$row['v_price'], 2) . "</td>";
                  echo "<td>";
                  if ($row['v_status'] == 0) {
                    echo "<span class=\"badge badge-secondary\">Inactive</span>";
                  } elseif ($row['v_status'] == 1) {
                    echo "<span class=\"badge badge-success\">Available</span>";
                  }
                  elseif ($row['v_status'] == 2) {
                    echo "<span class=\"badge badge-success\"> Available</span>";
                  }
                  echo "</td>";
                  echo "<td>";
                  echo "<div class='dropdown mb-4'>
                  <a class='btn btn-outline-dark dropdown-toggle' href='#' role='button' data-toggle='dropdown'>
                  Action
                  </a>
                  <div class='dropdown-menu dropdown-menu-right'>
                  <a class='dropdown-item' href='vehicleview.php?v_reg=" . $row['v_reg'] . "'>View Detail</a>";

                  if ($row['v_status'] != 0) {
                    echo "<a class='dropdown-item' href='vehiclemodify.php?v_reg=" . $row['v_reg'] . "'>Modify</a>";
                    echo "<a class='dropdown-item' href='?v_reg=" . $row['v_reg'] . "&action=delete' onclick='return confirm(\"Are you sure you want to delete this vehicle?\")'>Delete</a>";
                  } 

                  echo "</div>
                  </div>";
                  echo "</td>";
                  echo "</tr>";
                $cnt = $cnt +1; }
                ?>
              </tbody>
            </table>
          </div>
        </div>
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
<script src="../js/sb-admin.min.js"></script>

<!-- Demo scripts for this page-->
<script src="../vendor/js/demo/datatables-demo.js"></script>
  <script src="../vendor/js/demo/chart-area-demo.js"></script>

</body>

</html>
