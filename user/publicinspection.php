<?php
session_start();
include 'userbase.html';
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
        <h2 style="margin: 10px;">Inspection report</h2>
        <hr>
        <!-- <form method="POST" enctype="multipart/form-data"> -->
            <?php
                $sql = "select * from tblinspection,tblinspector,tblrestaurant,tblresponse where tblinspector.iEmail in(select username from tbllogin where status='1') and tblinspection.iId=tblinspector.iId and tblinspection.rId=tblrestaurant.rId and tblinspection.inspId=tblresponse.inspId";
            // echo $sql;
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                ?>
                <br><br><br>
                <hr>
            <table border="0" id="tbl">
                    <tr>
                        <th>REPORT ID</th>
                        <th>FOOD INSPECTOR</th>
                        <th>RESTAURANT</th>
                        <th>INSPECTION DATE</th>
                        <th>REPORT DATE</th>
                        <th>REPORT</th>
                        <th>RATING</th>
                        <th></th>
                    </tr>
                    <?php
                    while ($row =mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <td><?php echo $row['repId']; ?></td>
                            <td><?php echo $row['iName']; ?></td>
                            <td><?php echo $row['rName']; ?></td>
                            <td><?php echo $row['inspDate']; ?></td>
                            <td><?php echo $row['repDate']; ?></td>
                            <td><?php echo $row['report']; ?></td>
                            <td><?php echo $row['rating']; ?></td>
                           
                        </tr>
                    <?php } ?>
            </table>
            <?php 
            } 
            else{
                echo '<h3>No report </h3>';
            }
            ?>
        <!-- </form> -->
    </div>
</center>