<?php
session_start();
include 'fibase.html';
include '../connection.php';
?>
<style>
    th, td {
        padding: 10px;
    }
</style>

<center>
    <div style="margin: 50px;">
        <hr>
        <?php 
            if (isset($_SESSION['name'])) {
                echo "<h2>Welcome, {$_SESSION['name']} - {$_SESSION['usertype']}</h2>";
            } else {
                echo "<h2>Welcome, Guest</h2>";
            }
        ?>
        <hr>
    </div>
</center>
