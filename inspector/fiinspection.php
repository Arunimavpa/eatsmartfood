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
        <h2 style="margin: 10px;">Inspection</h2>
        <hr>
        <form method="POST" enctype="multipart/form-data">

            <?php
            $sql = "select * from tblinspection,tblinspector,tblrestaurant where tblinspector.iId='$id' and tblinspector.iId=tblinspection.iId and tblrestaurant.rId=tblinspection.rId";
            // echo $sql;
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
            ?>
                <br><br><br>
                <hr>
                <table border="0" id="tbl">
                    <tr>
                        <th>ID</th>
                        <th>DATE</th>
                        <th>RESTAURANT</th>
                        <th colspan="2">NOTIFIATION</th>
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <td><?php echo $row['inspId'] ?></td>
                            <td><?php echo $row['inspDate'] ?></td>
                            <td><?php echo $row['rName'] ?></td>
                            <td><?php echo $row['inspRequest'] ?></td>
                            <?php
                                if($row['status']=='Submitted')
                                {
                            ?>
                                    <td><a href="fireport.php?id=<?php echo $row['inspId'] ?>">Add report</td>
                        <?php
                    }
                        ?>
                        </tr>
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