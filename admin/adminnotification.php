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
    #tbl{
        width:1050px;
    }
</style>
<center>
    <div style="margin: 50px;">
        <hr>
        <h2 style="margin: 10px;">Notification</h2>
        <hr>
        <form method="POST" enctype="multipart/form-data">
    
            <table>
                <tr>
                    <td>Notification</td>
                    <td><textarea class="form-control" name="notification" required></textarea></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="submit" class="btn btn-danger" style="color: white; width:400px;"
                            value="Submit"></td>
                </tr>
            </table>
           
            <br><br><br><hr>
        <table border="0" id="tbl" >
            <?php
            $sql = "select * from tblnotification";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
            ?>
            <tr>
                <th>ID</th>
                <th>DATE</th>
                <th>NOTIFICATION</th>
                
            </tr>
            <?php
             while ($row = mysqli_fetch_array($result)) {
            ?>
            <tr>
                <td><?php echo $row['notId']; ?></td>
                <td><?php echo $row['notDate']; ?></td>
                <td><?php echo $row['notification']; ?></td>
            </tr>
           <?php
             }
            }
           ?>
        </table>
        
        </form>
    </div>
</center>
<?php
if (isset($_POST['submit'])) {
    $notification = $_POST['notification'];
   
        $qry = "insert into tblnotification(notDate,notification) values((select sysdate()),'$notification')";
        $res = mysqli_query($conn, $qry);
        if ($res) {
            echo '<script>alert("Data added successfully");location.href="adminnotification.php";</script>';
        } else {
            echo '<script>alert("Sorry some error occured");</script>';
        }
    
}
?>