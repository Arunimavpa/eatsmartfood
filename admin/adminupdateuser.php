<?php
include '../connection.php';
$email=$_GET['email'];
$status=$_GET['status'];
$sql="update tbllogin set status='$status' where username='$email'";
$result=mysqli_query($conn,$sql);
echo '<script>location.href="adminrestaurant.php"</script>';
?>