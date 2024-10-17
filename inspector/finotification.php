<?php
session_start();
include 'fibase.html';
include '../connection.php';
$id=$_SESSION['id'];
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
        <h2 style="margin: 10px;">Notification</h2>
        <hr>
        <form method="POST" enctype="multipart/form-data">

            <?php
            $sql = "select * from tblnotification order by notDate desc";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
            ?>
                <br><br><br>
                <hr>
                <table border="0" id="tbl">
                    <tr>
                        <th>ID</th>
                        <th>DATE</th>
                        <th>NOTIFIATION</th>
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <td><?php echo $row['notId'] ?></td>
                            <td><?php echo $row['notDate'] ?></td>
                            <td><?php echo $row['notification'] ?></td>
                        <?php
                    }
                        ?>

                </table>
            <?php
            }
            ?>
        </form>
    </div>
</center>