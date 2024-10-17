<?php
session_start();
include 'userbase.html';
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
        <h2 style="margin: 10px;">FeedBack</h2>
        <hr>
        <form method="POST" enctype="multipart/form-data">

            <table>
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
                    <td>Feedback</td>
                    <td><textarea class="form-control" name="feedback" required></textarea></td>
                </tr>

                <tr>
                    <td colspan="2"><input type="submit" name="submit" class="btn btn-danger" style="color: white; width:400px;" value="Submit"></td>
                </tr>
            </table>

            <br><br><br>
            <hr>
            <table border="0" id="tbl">
                <?php
                $sql = "select * from tblfeedback,tblreply where tblfeedback.fId=tblreply.fId and tblfeedback.pId='$id'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                ?>
                    <tr>
                        <th>ID</th>
                        <th>DATE</th>
                        <th>FEEDBACK</th>
                        <th>REPLY</th>
                        
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <td><?php echo $row['fId']; ?></td>
                            <td><?php echo $row['fDate']; ?></td>
                            <td><?php echo $row['feedback']; ?></td>
                            <td><?php echo $row['reply']; ?></td>
                           
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
    $feedback = $_POST['feedback'];
    $restaurant = $_POST['restaurant'];
    
    $qry = "insert into tblfeedback(pId,rId,fDate,feedback,status) values('$id','$restaurant',(select sysdate()),'$feedback','Submitted')";
    $res = mysqli_query($conn, $qry);
    if ($res) {
        echo '<script>alert("Data added successfully");location.href="publicfeedback.php";</script>';
    } else {
        echo '<script>alert("Sorry some error occured");</script>';
    }
}
?>