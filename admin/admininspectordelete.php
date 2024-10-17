<?php
include '../connection.php';
$email=$_GET['id'];

$sql="update tbllogin set status='-1' where username='$email'";
echo $sql;
$result=mysqli_query($conn,$sql);
echo '<script>location.href="admininspector.php"</script>';
?>