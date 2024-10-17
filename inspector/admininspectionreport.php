<?php
session_start();
include 'fibase.html';
include '../connection.php';
$inspId = $_GET['id'];
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
        <form method="POST" enctype="multipart/form-data">
            <?php
            $sql = "SELECT * FROM tblinspection 
                    JOIN tblinspector ON tblinspection.iId = tblinspector.iId 
                    JOIN tblrestaurant ON tblinspection.rId = tblrestaurant.rId 
                    JOIN tblresponse ON tblinspection.inspId = tblresponse.inspId 
                    WHERE tblinspection.inspId='$inspId'";
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
                        <th>FINE</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <td><?php echo $row['repId']; ?></td>
                            <td><?php echo $row['iName']; ?></td>
                            <td><?php echo $row['rName']; ?></td>
                            <td><?php echo $row['inspDate']; ?></td>
                            <td><?php echo $row['repDate']; ?></td>
                            <td><?php echo $row['report']; ?></td>
                            <td><?php echo $row['rating']; ?></td>
                            <?php
                            $sq = "SELECT status, amt FROM tblpenalty WHERE repId = '$row[repId]'";
                            $qs = mysqli_query($conn, $sq);

                            if ($qs) {
                                $eq = mysqli_fetch_array($qs);
                                if ($eq) { 
                                    echo "<td>{$eq['amt']}</td>";
                                
                                    if ($eq['status'] == 'Assigned') {
                                        echo "<td><a href='incrementpenalty.php?id={$row['repId']}'>ADD Extra Fine</a></td>";
                                        echo "<td><a href='penaltypaid.php?id={$row['repId']}'>Paid</a></td>";
                                    }
                                } else {
                                    echo "<td>No Penalty Assigned</td>";
                                }
                            } else {
                                echo "<td>Error fetching penalty data</td>";
                            }
                            ?>
                        </tr>
                    <?php 
                    } 
                    ?>
                </table>
            <?php 
            } else {
                echo '<h3>No report added</h3>';
            }
            ?>
        </form>
    </div>
</center>
