<?php
include '../connection.php';
$id=$_GET['id'];

$sql = "update tblpenalty set status='Paid' where repId='$id'";
echo $sql;
$result=mysqli_query($conn,$sql);
if($result){
    echo '<script>location.href="inspected.php"</script>';
}else{
    echo '<script>location.href="inspected.php"</script>';
}

?>