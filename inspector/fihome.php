<?php
session_start();
include 'fibase.html';
include '../connection.php';
?>
<style>
    th,
    td {
        padding: 10px;
    }
</style>
<center>
    <div style="margin: 50px;">
        <hr>
        <h2 style="margin: 10px;">Welcome <?php echo $_SESSION['name']; ?></h2>
        <hr>
        
    </div>
</center>