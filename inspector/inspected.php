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
        <h2 style="margin: 10px;">Inspected</h2>
        <hr>
        

            <br><br><br>
            <hr>
            <table border="0" id="tbl">
                <?php
                $sql = "select * from tblinspection,tblinspector,tblrestaurant where tblinspector.iEmail in(select username from tbllogin where status='1') and tblinspector.iId=tblinspection.iId and tblrestaurant.rId=tblinspection.rId";
                // echo $sql;
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                ?>
                    <tr>
                        <th>ID</th>
                        <th>FOOD INSPECTOR</th>
                        <th>RESTAURANT</th>
                        <th>INSPECTION DATE</th>
                        <th>REQUEST</th>
                        <th></th>
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <td><?php echo $row['inspId']; ?></td>
                            <td><?php echo $row['iName']; ?></td>
                            <td><?php echo $row['rName']; ?></td>
                            <td><?php echo $row['inspDate']; ?></td>
                            <td><?php echo $row['inspRequest']; ?></td>
                            <td><a href="admininspectionreport.php?id=<?php echo $row['inspId']; ?>">View report</a></td>
                        </tr>
                        <?php
                        }
                        ?>

            </table>
    <?php
                    }
                
    ?>

    </div>
</center>
