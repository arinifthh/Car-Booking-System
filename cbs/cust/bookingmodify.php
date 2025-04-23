<?php 
  include('../mysession.php');
  if(!session_id())
  {
    session_start();
  }

  include('../dbconnect.php');
$error = [];
if(isset($_GET['id']))
    {
      $fbid=$_GET['id'];
    }

$sqlr=" SELECT * FROM tb_booking 
        LEFT JOIN tb_vehicle ON tb_booking.b_req=tb_vehicle.v_reg 
        WHERE b_id=$fbid";

//Execute 
$resultr=mysqli_query($con, $sqlr);
$rowr=mysqli_fetch_array($resultr);

//retrieve data registration from form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$fbid=$_POST['fbid'];
$fvehicle=$_POST['fvehicle'];
$fpdate=$_POST['fpdate'];
$frdate=$_POST['frdate'];

if (date('Y-m-d') > $fpdate) {
    $error['b_pdate'] = 'Pickup date cannot be earlier than today\'s date';
  }

  // Check if return date is earlier than pickup date
  if (strtotime($frdate) < strtotime($fpdate)) {
    $error['b_rdate'] = 'Return date cannot be earlier than pickup date';
  }

  $sql = "SELECT * FROM tb_vehicle LEFT JOIN tb_booking ON tb_booking.b_req = tb_vehicle.v_reg WHERE v_reg = '$fvehicle' AND b_status=2 AND b_id!=$fbid";

$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);

if (strtotime($frdate) >= strtotime($row['b_pdate']) && strtotime($fpdate) <= strtotime($row['b_rdate'])) {
  if ($row['b_id'] != $fbid && $row['b_id'] != null) {
    $error['availability'] = 'The chosen vehicle is not available on the selected dates.';
  }
}


  // If there are no errors, proceed with booking
  if (empty($error)) {
//CALCULATE TOTAL RENT PRICE
//1. Convert form date to ISOB...
$start=date('Y-m-d H:i:s',strtotime($fpdate));
$end=date('Y-m-d H:i:s',strtotime($frdate));
//2. Calculate number of days
$daydiff=abs(strtotime($start)-strtotime($end));    //abs xde negative e.g. distance, time
$daynum=$daydiff/(60*60*24);    //in days (86400 sec per day)
//3. Get vehicle price from table
$sqlp="SELECT v_price FROM tb_vehicle WHERE v_reg='$fvehicle'";
$resultp=mysqli_query($con,$sqlp);
$rowp=mysqli_fetch_array($resultp);
$totalprice=$daynum*($rowp['v_price']);

$sql="UPDATE tb_booking
    SET b_req='$fvehicle',b_pdate='$fpdate',b_rdate='$frdate',b_total='$totalprice',b_status='2'
    WHERE b_id='$fbid'";

mysqli_query($con,$sql);

 if (mysqli_query($con, $sql)) {
        $succ = "Booking successful.";
      $_SESSION['fbid'] = $fbid; // Store the last inserted booking ID
      $_SESSION['daynum'] = $daynum; // Store the calculated number of days
      $_SESSION['totalprice'] = $totalprice; // Store the total price
      $dateRangeQuery = "UPDATE tb_vehicle SET v_status = 2 WHERE v_reg = '$fvehicle' AND v_reg IN (
  SELECT b_req FROM tb_booking WHERE (b_pdate <= '$frdate' AND b_rdate >= '$fpdate')
)";
mysqli_query($con, $dateRangeQuery);
      header('Location: bookingmodifyprocess.php');
      exit;
    } else {
      $err = "Failed to process booking.";
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

<div class="container">

<form method="POST">
  <fieldset>
    <legend>Modify Form</legend><br>
    

     <div class="form-group">
      <label for="exampleSelect1" class="form-label mt-4">Select vehicle</label>

      <?php

      echo'<input type="hidden" value="'.$rowr['b_id'].'" name="fbid" >';

      $sql="SELECT * FROM tb_vehicle WHERE v_status!=0";
      $result= mysqli_query($con, $sql);

      echo'<select class="form-control" name="fvehicle" id="exampleSelect1" >';
        while($row=mysqli_fetch_array($result))
        {
          if($row['v_reg']==$row['b_req'])
          {
            echo"<option selected='selected' value= '".$row['v_reg']."'>".$row['v_model'].", RM".$row['v_price']."</option value>";
          }
          else
          {
            echo"<option value= '".$row['v_reg']."'>".$row['v_model'].", RM".$row['v_price']."</option value>";
          }

        }

      echo'</select>';

      ?>
    </div>

    <div class="form-group">
          <label for="exampleInputPassword" class="form-label mt-4">Select Pickup Date</label>
          <?php  
          echo'<input type="date" value="'.$rowr['b_pdate'].'" name="fpdate" class="form-control" id="exampleInputPassword1" placeholder="Password" autocomplete="off" required>';
          ?>
          <?php if (!empty($error['b_pdate'])) {
                  echo '<p class="text-danger">' . $error['b_pdate'] . '</p>';
                } ?>
      </div>


    <div class="form-group">
          <label for="exampleInputPassword" class="form-label mt-4">Select Return Date</label>
          <?php  
          echo' <input type="date" value="'.$rowr['b_rdate'].'" name="frdate" class="form-control" id="exampleInputPassword1" placeholder="Password" autocomplete="off" required>';
          ?>
          <?php if (!empty($error['b_rdate'])) {
                  echo '<p class="text-danger">' . $error['b_rdate'] . '</p>';
                } ?>

      </div>
   
    </fieldset>

<br><br>

<button type="submit" class="btn btn-warning" >Modify</button>
<button type="reset" class="btn btn-dark">Reset</button>



</form>
</div>
<?php include 'footer.php';?>

</div>
      <!-- /.content-wrapper -->

</div>
    <!-- /#wrapper -->

    <?php if (isset($error['availability'])): ?>
  <script>alert('<?php echo $error['availability']; ?>');</script>
<?php endif; ?>

</body></html>