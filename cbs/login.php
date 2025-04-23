<?php
session_start();

//connect to DB
include('dbconnect.php');

//retrieve data registration from form
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
$fic = $_POST['fic'];
$fpwd = $_POST['fpwd'];

//CRUD Operation
//CREATE-SQL Select statement
$sql = "SELECT * FROM tb_user
        WHERE u_ic = ?";
$stmt = mysqli_prepare($con,$sql);

mysqli_stmt_bind_param($stmt,"s",$fic);
mysqli_stmt_execute($stmt);

//Execute SQL
$result = mysqli_stmt_get_result($stmt);

//Retrieve row/data
$row = mysqli_fetch_array($result);

//Verify password
if ($row && password_verify($fpwd, $row['u_pwd'])) {
    $_SESSION['u_ic'] = session_id();  //declare session id
    $_SESSION['suic'] = $fic;

    //User available
    if ($row['u_type'] == '1') {  //Staff
        header('Location:admin/main.php');
    } else {
        header('Location:cust/main.php');
    }
} else {
    // User not available/exist or password is incorrect
    // Add script to let the user know either username or password is wrong
    echo "<script>alert('Incorrect IC or Password.');</script>";
}
mysqli_stmt_close($stmt);
}

mysqli_close($con);

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
  <!--Trigger Sweet Alert-->
  <?php if(isset($error)) {?>
  <!--This code for injecting an alert-->
      <script>
            setTimeout(function () 
            { 
              swal("Failed!","<?php echo $error;?>!","error");
            },
              100);
      </script>
          
  <?php } ?>

  <div class="container" style="bg-dark">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Login</div>
      <div class="card-body">

        <form method ="POST">
          <div class="form-group">
              <label for="exampleInputPassword1" class="form-label mt-4">Identity Card No</label>
        <input type="text" name="fic" class="form-control" id="exampleInputPassword1" placeholder="Enter Your IC Number (without '-')" required>
            
              <label for="exampleInputPassword1" class="form-label mt-4">Password</label>
      <input type="password" name="fpwd" class="form-control" id="passwordField" placeholder="Enter Your Password" autocomplete="off" required>

      <input type="checkbox" id="showPasswordCheckbox">
      <label for="showPasswordCheckbox">Show password</label>
            
          </div>
          <button type="submit" class="btn btn-primary">Login</button>
          <button type="reset" class="btn btn-dark">Reset</button>
        </form>

        <div class="text-center">
        <a class="d-block small mt-3" href="index.php">Home</a>
        <a class="d-block small mt-3" href="register.php">No Account? Create One!</a>
        <a class="d-block small mt-3" href="forgot-password.php">Forgot Password</a>
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

</script>

</body>

</html>
