<?php
// Connect to DB
include('mysession.php');
if (!session_id()) {
    session_start();
}

include('dbconnect.php');

// Retrieve data from register form

$fpwd = $_POST['fpwd'];


if ($fpwd != "") {
    $fpwd = password_hash($fpwd, PASSWORD_DEFAULT);
} else {
    $sql = "SELECT * FROM tb_user WHERE u_ic = '$fic'";
    $result = $con->query($sql);
    $user = $result->fetch_assoc();
    $fpwd = $user['u_pwd'];
}

// CRUD Operations
// UPDATE - SQL Update Statement
$sql = "UPDATE tb_user 
        SET u_pwd=? 
        WHERE u_ic=?";

// Create prepared statement
$stmt = mysqli_prepare($con, $sql);

if ($stmt === false) {
    die("Error in preparing the statement: " . mysqli_error($con));
}


// Bind parameters
mysqli_stmt_bind_param($stmt, "sssssss", $fpwd);

// Execute prepared statement
if (mysqli_stmt_execute($stmt)) {
    // Success
    echo "Update successful!";
} else {
    // Error
    echo "Error in execution: " . mysqli_error($con);
}

// Close prepared statement
mysqli_stmt_close($stmt);

// Close DB connection
mysqli_close($con);

// Redirect to next page
echo "<script>alert('Update successful!'); window.history.go(-1);</script>";
exit(); // Ensure that no further code is executed after redirection
