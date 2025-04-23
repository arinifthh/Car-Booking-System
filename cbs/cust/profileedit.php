<?php
include('../mysession.php');
if (!session_id()) {
  session_start();
}
include('../dbconnect.php');

$suic=$_SESSION['suic'];

$sql_user = "SELECT * FROM `tb_user` WHERE `tb_user`.`u_ic` = '$suic'";
$result_user = $con->query($sql_user);
$user = $result_user->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $add = $_POST['add'];
  $license = $_POST['license'];

  $sql_update = "UPDATE `tb_user` SET `u_name` = '$name', `u_phone` = '$phone', `u_email` = '$email', `u_add` = '$add', `u_lic` = '$license' WHERE `u_ic` = '$suic'";
  if ($con->query($sql_update)) {
    $_SESSION['message'] = '<script>swal("Success!", "Profile has been updated successfully", "success");</script>';
    
  } else {
    $_SESSION['message'] = '<script>swal("Failed!", "Failed to update profile", "error");</script>';
    
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>
<body id="page-top">
  <?php include("nav.php"); ?>
  <div id="wrapper">
    <?php include("sidebar.php"); ?>
    <div id="content-wrapper">
      <div class="container-fluid">
        <?php if (isset($_SESSION['message'])) {
          echo $_SESSION['message'];
          unset($_SESSION['message']);
        } ?>
        <ol class="breadcrumb">
        <h5 class="breadcrumb-item active">Edit Profile</h5>
      </ol>
        <hr>
        <div class="card col-md-12">
          <div class="card-body">
            <div class="card">
              <h2>Edit Profile</h2>
              <div class="card-body">
                <?php if ($user !== null) { ?>
                  <form method="POST">
                    <fieldset>
                      <div class="form-group">
                        <label for="exampleInputPassword" class="form-label mt-4">Name</label>
                        <input type="text" value="<?php echo $user['u_name']; ?>" name="name" class="form-control" id="exampleInputPassword1" placeholder="Password" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword" class="form-label mt-4">Phone</label>
                        <input type="text" value="<?php echo $user['u_phone']; ?>" name="phone" class="form-control" id="exampleInputPassword1" placeholder="Password" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword" class="form-label mt-4">Email</label>
                        <input type="text" value="<?php echo $user['u_email']; ?>" name="email" class="form-control" id="exampleInputPassword1" placeholder="Password" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword" class="form-label mt-4">Address</label>
                        <input type="text" value="<?php echo $user['u_add']; ?>" name="add" class="form-control" id="exampleInputPassword1" placeholder="Password" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword" class="form-label mt-4">License Number</label>
                        <input type="text" value="<?php echo $user['u_lic']; ?>" name="license" class="form-control" id="exampleInputPassword1" placeholder="Password" autocomplete="off" required>
                      </div>
                    </fieldset>
                    <br><br>
                    <button type="submit" class="btn btn-warning">Edit</button>
                    <button type="reset" class="btn btn-dark">Reset</button>
                  </form>
                <?php } else { ?>
                  <p>User not found.</p>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <hr>
      <?php include("footer.php"); ?>
    </div> <!-- /.content-wrapper --> 
  </div> <!-- /#wrapper --> <!-- Scroll to Top Button--> 
  <a class="scroll-to-top rounded" href="#page-top"> 
    <i class="fas fa-angle-up"></i> 
  </a> <!-- Logout Modal--> 
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
    <div class="modal-dialog" role="document"> 
      <div class="modal-content"> 
        <div class="modal-header"> 
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5> 
          <button class="close" type="button" data-dismiss="modal" aria-label="Close"> 
            <span aria-hidden="true">×</span> </button> </div> 
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div> 
            <div class="modal-footer"> 
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button> 
              <a class="btn btn-danger" href="../logout.php">Logout</a> </div> </div> </div> </div> <!-- Bootstrap core JavaScript--> 
              <script src="../vendor/jquery/jquery.min.js"></script> 
              <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script> <!-- Core plugin JavaScript--> 
              <script src="../vendor/jquery-easing/jquery.easing.min.js"></script> <!-- Page level plugin JavaScript--> 
              <script src="../vendor/chart.js/Chart.min.js"></script> 
              <script src="../vendor/datatables/jquery.dataTables.js"></script> 
              <script src="../vendor/datatables/dataTables.bootstrap4.js"></script> <!-- Custom scripts for all pages--> 
              <script src="../vendor/js/sb-admin.min.js"></script> <!-- Demo scripts for this page--> 
              <script src="../vendor/js/demo/datatables-demo.js"></script> 
              <script src="../vendor/js/demo/chart-area-demo.js"></script> <!--INject Sweet alert js--> <script src="../vendor/js/swal.js"></script> </body> </html>