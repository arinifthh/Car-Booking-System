<?php
  include('../mysession.php');
  if(!session_id())
  {
    session_start();
  }
  include('../dbconnect.php');
  $title='Dashboard';

$sql_vehicle = "SELECT * FROM `tb_vehicle`";
$result_vehicle = $con->query($sql_vehicle);

$sql_actvehicle = "SELECT * FROM `tb_vehicle` WHERE `v_status`=1";
$result_actvehicle = $con->query($sql_actvehicle);

$sql_invehicle = "SELECT * FROM `tb_vehicle` WHERE `v_status`=0";
$result_invehicle = $con->query($sql_invehicle);

$sql_book = "SELECT * FROM `tb_booking`";
$result_book = $con->query($sql_book);

$sql_recbook = "SELECT * FROM `tb_booking` WHERE `b_status`=1";
$result_recbook = $con->query($sql_recbook);

$sql_appbook = "SELECT * FROM `tb_booking` WHERE `b_status`=2";
$result_appbook = $con->query($sql_appbook);

$sql_rejbook = "SELECT * FROM `tb_booking` WHERE `b_status`=3";
$result_rejbook = $con->query($sql_rejbook);

$sql_canbook = "SELECT * FROM `tb_booking` WHERE `b_status`=4";
$result_canbook = $con->query($sql_canbook);

$sql_customer = "SELECT * FROM `tb_user` WHERE `u_type`=2";
$result_customer = $con->query($sql_customer);

$sql_customer = "SELECT * FROM `tb_user` WHERE `u_type`=2";
$result_customer = $con->query($sql_customer);

$sql_total = "SELECT SUM(b_total) AS total_sum FROM tb_booking WHERE b_status = 2";
$result_total = $con->query($sql_total);

if ($result_total && $result_total->num_rows > 0) {
    $row_total = $result_total->fetch_assoc();
    $total_sum = $row_total['total_sum'];}

$count = array(
    'vehicle' => $result_vehicle->num_rows,
    'actvehicle' => $result_actvehicle->num_rows,
    'invehicle' => $result_invehicle->num_rows,
    'book' => $result_book->num_rows,
    'recbook' => $result_recbook->num_rows,
    'appbook'=> $result_appbook->num_rows,
    'rejbook' => $result_rejbook->num_rows,
    'canbook' => $result_canbook->num_rows,
    'customers' => $result_customer->num_rows,
);

$countJson = json_encode($count);

?>
<!DOCTYPE html>
<html lang="en">

<head>
<?php include('head.php');?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Vehicle Booking System Transport Saccos, Matatu Industry">
  <meta name="author" content="MartDevelopers">

  <title>Admin Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="../vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../vendor/css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">
 <!--Start Navigation Bar-->
 <?php include("head.php");?>
  <?php include("nav.php");?>
  <!--Navigation Bar-->

  <div id="wrapper">

    <!-- Sidebar -->
    <?php include("sidebar.php");?>
    <!--End Sidebar-->
    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <h5 class="breadcrumb-item active"> Dashboard</h5>
          </li>
        </ol>

        <!-- Icon Cards-->
        <div class="row">
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-danger o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa fa-car"></i>
                </div>
                <?php
                  //code for summing up number of vehicles
                  $result ="SELECT count(*) FROM tb_vehicle";
                  $stmt = $con->prepare($result);
                  $stmt->execute();
                  $stmt->bind_result($vehicle);
                  $stmt->fetch();
                  $stmt->close();
                ?>
                <div class="mr-5">Total Vehicles : <span class="badge badge-danger"><?php echo $vehicle;?></span></div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="vehiclemanage.php">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>

          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-danger o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa fa-key"></i>
                </div>
                <?php
                  //code for summing up number of vehicles
                  $result ="SELECT count(*) FROM tb_booking";
                  $stmt = $con->prepare($result);
                  $stmt->execute();
                  $stmt->bind_result($booking);
                  $stmt->fetch();
                  $stmt->close();
                ?>
                <div class="mr-5">Total Bookings : <span class="badge badge-danger"><?php echo $booking;?></span></div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="bookingmanage.php">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>

          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-danger o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa fa-users"></i>
                </div>
                <div class="mr-5">Total Customers :<span class="badge badge-danger"><?= $count['customers'] ?></span></div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="customer.php">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
         

          <div class="col-xl-3 col-sm-6 mb-3">
  <div class="card text-white bg-danger o-hidden h-100">
    <div class="card-body">
      <div class="card-body-icon">
        <i class="fas fa-fw fa fa-dollar-sign"></i>
      </div>
      <div class="mr-5">
        <h1 class="badge badge-danger" style="font-size: 18px; font-weight: bold; padding: 0px;">
          TOTAL SALES
          <span style="font-size: 36px; color: #fff;">
            <hr style="border-color: #fff; margin-top: 10px; margin-bottom: 10px;">
            RM<?= $total_sum ?>
          </span>
        </h1>
      </div>
    </div>
  </div>
</div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container">
    <div class="row">

        <div class="col-xl-6 col-lg-6">
                <div class="col-xl-12">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Total Bookings: <?= $count['book'] ?></h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="chart-pie pt-4">
                                <canvas id="myPie"></canvas>
                            </div>
                        </div>
                    </div>
                </div></div>

          <div class="col-xl-6 col-lg-10">
                <div class="col-xl-12">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Total Vehicles: <?= $count['vehicle'] ?></h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="chart-pie pt-4">
                                <canvas id="myPie2"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>

    var count = <?php echo $countJson; ?>;
    var recbookCount = count['recbook'];
    var appbookCount = count['appbook'];
    var rejbookCount = count['rejbook'];
    var canbookCount = count['canbook'];
    var ctx = document.getElementById("myPie");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ['Received', 'Approved','Rejected','Canceled'],
    datasets: [{
      data: [recbookCount, appbookCount,rejbookCount,canbookCount],
      backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc','#FF0000'],
      hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});

var count = <?php echo $countJson; ?>;

        var quotationCount = count['actvehicle'];
        var deleteQuoCount = count['invehicle'];
    var ctx = document.getElementById("myPie2");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ['Active', 'Inactive'],
    datasets: [{
      data: [quotationCount, deleteQuoCount],
      backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
      hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});
    </script>
                 
</div></div>
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
  <script src="../vendor/chart.js/Chart.min.js"></script>
  <script src="../vendor/datatables/jquery.dataTables.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../vendor/js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="../vendor/js/demo/datatables-demo.js"></script>
  <script src="../vendor/js/demo/chart-area-demo.js"></script>

</body>

</html>
