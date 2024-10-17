<?php
session_start();
include 'adminbase.html';
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
        <h2 style="margin: 10px;">Inspection request</h2>
        <hr>
        <form method="POST" enctype="multipart/form-data">

            <table>
                <tr>
                    <td>Food inspector</td>
                    <td><select class="form-control" name="inspector">
                            <option selected disabled>Select inspector</option>
                            <?php
                            $sql = "select * from tblinspector where iEmail in(select username from tbllogin where status='1')";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_array($result)) {
                            ?>
                                    <option value="<?php echo $row['iId']; ?>"><?php echo $row['iName']; ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Restaurant</td>
                    <td><select class="form-control" name="restaurant">
                            <option selected disabled>Select restaurant</option>
                            <?php
                            $sql = "select * from tblrestaurant where rEmail in(select username from tbllogin where status='1')";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {

                                while ($row = mysqli_fetch_array($result)) {

                            ?>
                                    <option value="<?php echo $row['rId']; ?>"><?php echo $row['rName']; ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Inspection date</td>
                    <td><input type="date" class="form-control" name="date" required></td>
                </tr>
                <tr>
                    <td>Request</td>
                    <td><textarea class="form-control" name="request" required></textarea></td>
                </tr>

                <tr>
                    <td colspan="2"><input type="submit" name="submit" class="btn btn-danger" style="color: white; width:400px;" value="Submit"></td>
                </tr>
            </table>

            <br><br><br>
            <hr>
            <table border="0" id="tbl">
                <?php
                $sql = "select * from tblinspection,tblinspector,tblrestaurant where tblinspector.iEmail in(select username from tbllogin where status='1') and tblinspector.iId=tblinspection.iId and tblrestaurant.rId=tblinspection.rId";
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
        </form>
    </div>
</center>
<?php
if (isset($_POST['submit'])) {
    $inspector = $_POST['inspector'];
    $restaurant = $_POST['restaurant'];
    $date = $_POST['date'];
    $request = $_POST['request'];
    $license = $_POST['license'];
    $qry = "insert into tblinspection(iId,rId,inspDate,inspRequest,status) values('$inspector','$restaurant','$date','$request','Submitted')";
    $res = mysqli_query($conn, $qry);
    if ($res) {
        echo '<script>alert("Data added successfully");location.href="admininspection.php";</script>';
    } else {
        echo '<script>alert("Sorry some error occured");</script>';
    }
}
?>