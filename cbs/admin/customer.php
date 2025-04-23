<?php 
include('../mysession.php');
if(!session_id())
{
  session_start();
}
include('../dbconnect.php');
$title='Customer';

$sql=" SELECT * FROM tb_user WHERE u_type=2"; 


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
        <h5 class="breadcrumb-item active">Customers </h5>
      </ol>

      <!--Bookings-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fas fa-table"></i>
        Customers</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th scope="col">Customer IC</th>
                  <th scope="col">Customer Name</th>
                  <th scope="col">Customer License</th>
                  <th scope="col">Customer Phone</th>
                  <th scope="col">Customer Email</th>
                  <th scope="col">Customer Address</th>
                  <th scope="col">Customer Order</th>
                </tr>
              </thead>

              <tbody>
                <?php
                while ($row = mysqli_fetch_array($result)) {
                  echo "<tr>";
                  echo "<td>" . $row['u_ic'] . "</td>";
                   echo"<td>".$row['u_name']."</td>";
                  echo "<td>" . $row['u_lic'] . "</td>";
                  echo "<td>" . $row['u_phone'] . "</td>";
                  echo "<td>" . $row['u_email'] . "</td>";
                  echo "<td>" . $row['u_add'] . "</td>";
                  echo "<td>";
echo "<a href='custorder.php?id=" . $row['u_ic'] . "' class='btn btn-dark'>View Order</a>";
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
