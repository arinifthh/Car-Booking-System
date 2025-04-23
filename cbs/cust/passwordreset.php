<?php
include('../mysession.php');
if (!session_id()) {
  session_start();
}
include('../dbconnect.php');

$suic=$_SESSION['suic'];
  
  if(isset($_POST['change_pwd']))
    {
$error = [];

$sql = "SELECT * FROM tb_user
        WHERE u_ic = '$suic'";

//Execute SQL
$result = mysqli_query($con, $sql);

//Retrieve row/data
$row = mysqli_fetch_array($result);

            $oldpassword = $_POST['oldpwd'];
            $password = $_POST['a_pwd'];
            $confirmpassword = $_POST['cfmpwd'];
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if (!password_verify($oldpassword, $row['u_pwd']))
    {
      $error['oldpwd'] = 'Wrong Old Password';
    }

    if ($password !== $confirmpassword) {
        $error['cfmpwd'] = 'Passwords do not match';
    }

if(empty($error)){
            $query=" UPDATE tb_user SET u_pwd = ? WHERE u_ic = ?";
            $stmt = $con->prepare($query);
            $rc=$stmt->bind_param('si', $hashed_password, $suic);
            $stmt->execute();
                if($stmt->affected_rows>0)
                {
                    $succ = "Password Changed";
                }
                else 
                {
                    $err = "Please Try Again Later";
                }
            }
          }
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
        <h5 class="breadcrumb-item active">Change Password</h5>
      </ol>

        <hr>
        <div class="card col-md-12">
        <!-- <img src="../vendor/img/services_banner.jpg" class="card-img-top" alt="..."> -->
        <div class="card-body">
        <div class="card">
        <h2> Change Password</h2>
            <div class="card-body">
               
                <form method ="post">                    
                    <div class="form-group">
                        <label for="exampleInputPassword1">Old Password</label>
<?php if (!empty($error['oldpwd'])) {
                  echo '<p class="text-danger">' . $error['oldpwd'] . '</p>';
                } ?>
                        <input type="password" name="oldpwd" class="form-control" id="passwordField">
                        <input type="checkbox" id="showPasswordCheckbox">
              <label class="form-check-label" for="passwordField">Show password</label>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">New Password</label>
                        <input type="password" name="a_pwd" class="form-control" id="confirmPasswordField">
                        <input type="checkbox" id="showConfirmPasswordCheckbox">
              <label class="form-check-label" for="confirmPasswordField">Show password</label>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Confirm New Password</label>
                        <input type="password" class="form-control" name="cfmpwd" id="newPasswordField"required>
                        <?php if (!empty($error['cfmpwd'])) {
                  echo '<p class="text-danger">' . $error['cfmpwd'] . '</p>';
                } ?>
                        <input type="checkbox" id="shownewPasswordCheckbox">
              <label class="form-check-label" for="newPasswordField">Show password</label>
                    </div>
                     <button type="submit" name="change_pwd" class="btn btn-success">Submit</button>
                </form>
            </div>
        </div>
        </div>
        </div>
      </div>      
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
          <a class="btn btn-danger" href="../logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

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

 <script>
  // Get references to the password fields and the show password checkboxes
  const passwordField = document.getElementById('passwordField');
  const confirmPasswordField = document.getElementById('confirmPasswordField');
  const newPasswordField = document.getElementById('newPasswordField');
  const showPasswordCheckbox = document.getElementById('showPasswordCheckbox');
  const showConfirmPasswordCheckbox = document.getElementById('showConfirmPasswordCheckbox');
  const shownewPasswordCheckbox = document.getElementById('shownewPasswordCheckbox');

  // Add event listener to the show password checkbox
  showPasswordCheckbox.addEventListener('change', function() {
    if (showPasswordCheckbox.checked) {
      // If the checkbox is checked, show the password
      passwordField.type = 'text';
    } else {
      // If the checkbox is unchecked, hide the password
      passwordField.type = 'password';
    }
  });

  // Add event listener to the show confirm password checkbox
  showConfirmPasswordCheckbox.addEventListener('change', function() {
    if (showConfirmPasswordCheckbox.checked) {
      // If the checkbox is checked, show the confirm password
      confirmPasswordField.type = 'text';
    } else {
      // If the checkbox is unchecked, hide the confirm password
      confirmPasswordField.type = 'password';
    }
  });

  shownewPasswordCheckbox.addEventListener('change', function() {
    if (shownewPasswordCheckbox.checked) {
      // If the checkbox is checked, show the confirm password
      newPasswordField.type = 'text';
    } else {
      // If the checkbox is unchecked, hide the confirm password
      newPasswordField.type = 'password';
    }
  });

</script>

</body>

</html>
