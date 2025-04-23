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

if (isset($_POST['update_veh'])) {
    $v_type = $_POST['v_type'];
    if ($v_type === 'new') {
        $v_type = $_POST['otherCategoryInput'];
    }
    $v_model = $_POST['v_model'];
    $v_colour = $_POST['v_colour'];
    $v_price = $_POST['v_price'];

    // Check if a new image is uploaded
    if ($_FILES["v_pic"]["name"]) {
        // Delete the previous image file
        if (isset($rowr['v_pic']) && !empty($rowr['v_pic'])) {
            unlink("../vendor/img/" . $rowr['v_pic']);
        }

        // Move and save the new image file
        $v_pic = $_FILES["v_pic"]["name"];
        move_uploaded_file($_FILES["v_pic"]["tmp_name"], "../vendor/img/" . $v_pic);
    } else {
        // No new image uploaded, use the current image path
        $v_pic = isset($rowr['v_pic']) ? $rowr['v_pic'] : '';
    }

    $query = "UPDATE tb_vehicle SET v_type=?, v_model=?, v_colour=?, v_price=?, v_pic=? WHERE v_reg=?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('ssssss', $v_type, $v_model, $v_colour, $v_price, $v_pic, $vid);
    $stmt->execute();
    if ($stmt) {
        $succ = "Vehicle Updated";
    } else {
        $err = "Please Try Again Later";
    }
}
?>

<!-- HTML code continues... -->

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
          <li class="breadcrumb-item">
            <a href="vehiclemanage.php">Vehicles</a>
          </li>
          <li class="breadcrumb-item active">Update Vehicle</li>
        </ol>
        <hr>
        <div class="card">
        <div class="card-header">
            Update Vehicle
        </div>
        <div class="card-body">
          <!--Add User Form-->
        <form method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="exampleInputEmail1">Vehicle model</label>
        <input type="text" value="<?php echo isset($rowr) ? $rowr['v_model'] : ''; ?>" required class="form-control" id="exampleInputEmail1" name="v_model">
    </div>

    <div class="form-group">
        <label for="exampleFormControlSelect1">Vehicle Category</label>
        <select class="form-control" name="v_type" id="exampleFormControlSelect1">
            <option>Bus</option>
            <option>Matatu</option>
            <option>Nissan</option>
            <option value="new">Other (Specify)</option>
        </select>
    </div>

<div class="form-group" id="otherCategoryContainer" style="display: none;">
    <label for="otherCategoryInput">Other Category:</label>
    <input type="text" class="form-control" id="otherCategoryInput" name="otherCategoryInput">
</div>

    <div class="form-group">
        <label for="exampleInputEmail1">Vehicle Colour</label>
        <input type="text" value="<?php echo isset($rowr) ? $rowr['v_colour'] : ''; ?>" class="form-control" id="exampleInputEmail1" name="v_colour">
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">Vehicle Price</label>
        <input type="Number" value="<?php echo isset($rowr) ? $rowr['v_price'] : ''; ?>" class="form-control" id="exampleInputEmail1" name="v_price">
    </div>

    <div class="card form-group" style="width: 30rem">
        <img src="../vendor/img/<?php echo isset($rowr) ? $rowr['v_pic'] : ''; ?>" class="card-img-top">
        <div class="card-body">
            <h5 class="card-title">Vehicle Picture</h5>
            <input type="file" class="btn btn-success" id="exampleInputEmail1" name="v_pic">
            <input type="hidden" name="current_v_pic" value="<?php echo isset($rowr) ? $rowr['v_pic'] : ''; ?>">
        </div>
    </div>


    <hr>
    <button type="submit" name="update_veh" class="btn btn-success">Update Vehicle</button>
</form>
          <!-- End Form-->
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

<script>
    document.getElementById('exampleFormControlSelect1').addEventListener('change', function() {
        var selectedOption = this.value;
        var otherCategoryContainer = document.getElementById('otherCategoryContainer');
        
        if (selectedOption === 'new') {
            otherCategoryContainer.style.display = 'block';
        } else {
            otherCategoryContainer.style.display = 'none';
        }
    });

    document.getElementById('exampleForm').addEventListener('submit', function(event) {
    var selectedOption = document.getElementById('exampleFormControlSelect1').value;
    var otherCategoryInput = document.getElementById('otherCategoryInput');

    if (selectedOption === 'new' && otherCategoryInput.value.trim() !== '') {
        // Add the new category as an option dynamically
        var newOption = document.createElement('option');
        newOption.text = otherCategoryInput.value;
        newOption.value = otherCategoryInput.value;
        this.elements['v_type'].add(newOption);

        // Set the value to the selected option
        this.elements['v_type'].value = otherCategoryInput.value;
    } else {
        // Use the selected option value
        this.elements['v_type'].value = selectedOption;
    }
});
</script>

</body>

</html>
