<?php
session_start();

//connect to DB
include('dbconnect.php');

//retrieve data registration from form
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
    header('Location:login.php');

}

mysqli_stmt_close($stmt);
mysqli_close($con);
?>