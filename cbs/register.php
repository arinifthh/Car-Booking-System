<?php
//connect to DB
include('dbconnect.php');

$error = [];

//retrieve data registration form form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$fic=$_POST['fic'];
$fname=$_POST['fname'];
$fpwd=$_POST['fpwd'];
$confirmpassword = $_POST['confirmpwd'];
$hashedPassword = password_hash($fpwd, PASSWORD_DEFAULT);
$fphone=$_POST['fphone'];
$femail=$_POST['femail'];
$flic=$_POST['flic'];
$fadd=$_POST['fadd'];


// Check if the new password and confirm password match
if ($fpwd !== $confirmpassword) {
    $error['confirmpwd'] = 'Passwords do not match';
  } 

//CRUD Operation
//CREATE-SQL Insert statement
  if(empty($error)){
$sql="INSERT INTO tb_user(u_ic,u_pwd,u_name,u_phone,u_email,u_add,u_lic,u_type)
    VALUES('$fic','$hashedPassword','$fname','$fphone','$femail','$fadd','$flic','2')";

//Execute SQL
mysqli_query($con,$sql);
header('Location:login.php');
$succ = "Registration Success";

}

mysqli_close($con);

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
<?php include("head.php");?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Tranport Management System, Saccos, Matwana Culture">
  <meta name="author" content="MartDevelopers ">

  <title>Register</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="vendor/css/sb-admin.css" rel="stylesheet">

</head>

<body style="background-image: url('vendor/img/wall4.jpg'); background-repeat: no-repeat; background-size: cover;">
<div class=container>

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

      <div class="card card-register mx-auto mt-5">
  <div class="card-header">Create An Account With Us</div>
      <div class="card-body">
  <form method ="POST">

    <fieldset>
      <div class="form-group">
        <div class="form-row">
          <div class="col-md-6">
        <label for="exampleInputPassword1" class="form-label mt-4">Identity Card No</label>
        <input type="text" name="fic" class="form-control" id="exampleInputPassword1" placeholder="Enter IC No. (without '-')" value="<?php echo isset($_POST['fic']) ? $_POST['fic'] : ''; ?>" required>
      </div>
      <div class="col-md-6">
        <label for="exampleInputPassword1" class="form-label mt-4">License No</label>
        <input type="text" name="flic" class="form-control" id="exampleInputPassword1" placeholder="Enter your license number" value="<?php echo isset($_POST['flic']) ? $_POST['flic'] : ''; ?>" autocomplete="off">
      </div>
      </div>
    </div>

    <div class="form-group">
        <label for="exampleInputPassword1" class="form-label mt-4">Full Name</label>
        <input type="text" name="fname" class="form-control" id="exampleInputPassword1" placeholder="Enter Your Name" value="<?php echo isset($_POST['fname']) ? $_POST['fname'] : ''; ?>" required>
      </div>

    <div class="form-group">
      <div class="form-row">
        <div class="col-md-6">
          <label for="exampleInputPassword1" class="form-label mt-4">Password</label>
          <input type="password" name="fpwd" class="form-control" id="passwordField" placeholder="Enter Unique Password" autocomplete="off" required>
        </div>
        <div class="col-md-6">
          <label for="exampleInputPassword1" class="form-label mt-4">Confirm Password</label>
          <input type="password" name="confirmpwd" class="form-control" id="confirmPasswordField" placeholder="Re-Enter Unique Password" autocomplete="off" required>
          <?php if (!empty($error['confirmpwd'])) {
                  echo '<p class="text-danger">' . $error['confirmpwd'] . '</p>';
                } ?>
        </div>
      </div>
    </div>

        <div class="form-group">
          <div class="form-row">
            <div class="col-md-6">
              <input type="checkbox" id="showPasswordCheckbox">
              <label class="form-check-label" for="showPasswordCheckbox">Show password</label>
            </div>
            <div class="col-md-6">
              <input type="checkbox" id="showConfirmPasswordCheckbox">
              <label class="form-check-label" for="showConfirmPasswordCheckbox">Show password</label>
            </div>
          </div>
        </div>
    

      <div class="form-group">
        <div class="form-row">
            <div class="col-md-6">
        <label for="exampleInputPhone1" class="form-label mt-6">Phone Number</label>
        <input type="phone" name="fphone" class="form-control" id="exampleInputPhone1" placeholder="Enter Your Phone No. (without '-')" value="<?php echo isset($_POST['fphone']) ? $_POST['fphone'] : ''; ?>" autocomplete="off" required>
      </div>

      <div class="col-md-6">
        <label for="exampleInputEmail1" class="form-label mt-6">Email address</label>
        <input type="email" name="femail"  class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Your Email" value="<?php echo isset($_POST['femail']) ? $_POST['femail'] : ''; ?>">
      </div></div>
  </div>


      <div class="form-group">
    <label for="exampleTextarea" class="form-label mt-4">Address</label>
    <textarea class="form-control" name="fadd" id="exampleTextarea" placeholder="Enter Your Address" rows="4"><?php echo isset($_POST['fadd']) ? $_POST['fadd'] : ''; ?></textarea>
</div>
    </fieldset>
    <button type="submit" name="add_user" class="btn btn-success">Create Account</button>
  </form>
  <!--End FOrm-->
  <div class="text-center">
            <a class="d-block small mt-3" href="index.php">Home</a>
    <a class="d-block small mt-3" href="login.php">Already have and account? Login</a>
  </div>

</div></div></div>


<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<!--INject Sweet alert js-->
<script src="vendor/js/swal.js"></script>

<script>
  // Get references to the password fields and the show password checkboxes
  const passwordField = document.getElementById('passwordField');
  const confirmPasswordField = document.getElementById('confirmPasswordField');
  const showPasswordCheckbox = document.getElementById('showPasswordCheckbox');
  const showConfirmPasswordCheckbox = document.getElementById('showConfirmPasswordCheckbox');

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
</script>

</body>

</html>