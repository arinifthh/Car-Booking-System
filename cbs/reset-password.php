<?php require_once 'dbconnect.php'; 

// redirect url

function alert($message, $type = 'info')
{
    // bootsrap 4 alert
    $text = '<div class="alert alert-' . $type . ' alert-dismissible fade show" role="alert">';
    $text .= $message;
    $text .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
    $text .= '<span aria-hidden="true">&times;</span>';
    $text .= '</button>';
    $text .= '</div>';
    return $text;
}


function redirect($url = null)
{
    echo "<script>window.location.href='" . $url . "'</script>";
    die;
}

if (isset($_GET['token'])) {
    session_start();
    $token = $_GET['token'];

    // 30 minutes
    $current_date = date('Y-m-d H:i:s');
    $sql = "SELECT * FROM `password_resets` WHERE `password_reset_token` = '$token' AND `password_reset_status` = '1' AND `password_reset_created_at` >= DATE_SUB('$current_date', INTERVAL 30 MINUTE)";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $password_reset = $result->fetch_assoc();

        $user = $password_reset['password_reset_user_id'];

        $sql_user = "SELECT * FROM `tb_user` WHERE `u_ic` = '$user'";
        $result_user = $con->query($sql_user);

        if ($result_user->num_rows > 0) {
            $user = $result_user->fetch_assoc();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $password = $_POST['fpwd'];
                $confirm_password = $_POST['fcpwd'];

                $error = [];



                if (empty($password)) {
                    $error['fpwd'] = 'Password is required';
                } else if (strlen($password) < 8) {
                    $error['fpwd'] = 'Password must be at least 8 characters';
                }

                if (empty($confirm_password)) {
                    $error['fcpwd'] = 'Confirm Password is required';
                } else if ($password != $confirm_password) {
                    $error['fcpwd'] = 'Confirm Password must be same as Password';
                }

                if (empty($error)) {
                    $password = password_hash($password, PASSWORD_DEFAULT);

                    $sql_update = "UPDATE `tb_user` SET `u_pwd` = '$password' WHERE `u_ic` = '" . $user['u_ic'] . "'";
                    $con->query($sql_update);

                    // $sql_delete = "DELETE FROM `password_resets` WHERE `password_reset_user_id` = '$user_id'";
                    // update
                    $sql_delete = "UPDATE `password_resets` SET `password_reset_status` = '0' WHERE `password_reset_user_id` = '" . $user['u_ic'] . "'";
                    $con->query($sql_delete);

                    $_SESSION['message'] = alert('Password has been reset successfully', 'success');
                    //redirect('index.php');
                }
            }
        } else {
            $_SESSION['message'] = alert('Invalid token', 'danger');
            //redirect('index.php');
        }
    } else {
        $_SESSION['message'] = alert('Invalid token', 'danger');
        //redirect('index.php');
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
<?php include("head.php");?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Vehicle Booking System Transport Saccos, Matatu Industry">
  <meta name="author" content="MartDevelopers">

  <title>Vehicle Booking System - Admin Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="vendor/css/sb-admin.css" rel="stylesheet">

</head>


<body style="background-image: url('vendor/img/wall4.jpg'); background-repeat: no-repeat; background-size: cover;">
  <div class="container" style="bg-dark">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Reset Password</div>
      <div class="card-body">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Car Booking Rental</h1>
                  </div>
                  <?php if (isset($_SESSION['message'])) : ?>
                    <?= $_SESSION['message'] ?>
                    <?php unset($_SESSION['message']) ?>
                  <?php endif; ?>
                  <form method="POST">
                    <div class="form-group">
                      <input type="password" name="fpwd" id="passwordField" class="form-control <?= isset($error['fpwd']) ? 'is-invalid' : '' ?>" placeholder="Password">
                      <?php if (isset($error['fpwd'])) : ?>
                        <div class="invalid-feedback"><?= $error['fpwd'] ?></div>
                      <?php endif; ?>
                      <input type="checkbox" id="showPasswordCheckbox">
      <label for="passwordField">Show password</label>
                    </div>
                    <div class="form-group">
                      <input type="password" name="fcpwd" id="confirm_password" class="form-control <?= isset($error['fcpwd']) ? 'is-invalid' : '' ?>" placeholder="Confirm Password">
                      <?php if (isset($error['fcpwd'])) : ?>
                        <div class="invalid-feedback"><?= $error['fcpwd'] ?></div>
                      <?php endif; ?>
                      <input type="checkbox" id="confirmPasswordCheckbox">
      <label for="confirm_password">Show password</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="login.php">Back to Login</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
      
  <!-- Bootstrap core JavaScript-->

<script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <!--Sweet alerts js-->
  <script src="vendor/js/swal.js"></script>

  <script>
  // Get references to the password fields and the show password checkboxes
  const passwordField = document.getElementById('passwordField');
  const showPasswordCheckbox = document.getElementById('showPasswordCheckbox');
  const confirm_password = document.getElementById('confirm_password');
  const confirmPasswordCheckbox = document.getElementById('confirmPasswordCheckbox');

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

  confirmPasswordCheckbox.addEventListener('change', function() {
    if (confirmPasswordCheckbox.checked) {
      // If the checkbox is checked, show the password
      confirm_password.type = 'text';
    } else {
      // If the checkbox is unchecked, hide the password
      confirm_password.type = 'password';
    }
  });

</script>

    </body>
</html>