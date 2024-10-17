<?php
session_start();
include 'restaurantbase.html';
include '../connection.php';
$id = $_SESSION['id'];
?>
<style>
    th,
    td {
        padding: 10px;
    }

    th {
        background-color: brown;
        color: white;
    }

    #tbl {
        width: 1050px;
    }
</style>

<center>
    <div style="margin: 50px;">
        <hr>
        <h2 style="margin: 10px;">Penalty</h2>
        <hr>
        <form method="POST" enctype="multipart/form-data">
            <?php
            $sql = "select * from tblpenalty where repId in(select repId from tblresponse where inspId in (select inspId from tblinspection where rId='$id'))";
            // echo $sql;
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
            ?>
                <br><br><br>
                <hr>
                <table border="0" id="tbl">
                    <tr>
                        <th> ID</th>
                        <th>PENALTY</th>
                        <th>DUE DATE</th>
                        <th>STATUS</th>
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <td><?php echo $row['penaltyId']; ?></td>
                            <td><?php echo $row['amt']; ?></td>
                            <td><?php echo $row['duedate']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                        </tr>
                    <?php } ?>
                </table>
            <?php 
            } 
            else{
                echo '<h3>No data </h3>';
            }
            ?>
        </form>
    </div>
</center>