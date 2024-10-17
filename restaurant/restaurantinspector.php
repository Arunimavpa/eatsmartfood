<?php
session_start();
include 'restaurantbase.html';
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
        <h2 style="margin: 10px;">Food Inspector</h2>
        <hr>
        <table border="0" id="tbl" >
            <?php
            $sql = "select * from tblinspector where iEmail in(select username from tbllogin where status='1')";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
            ?>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>LICENSE NO</th>
                <th>ADDRESS</th>
                <th>PHONE</th>
                <th>EMAIL</th>
                <th>PHOTO</th>
              
            </tr>
            <?php
             while ($row = mysqli_fetch_array($result)) {
            ?>
            <tr>
                <td><?php echo $row['iId']; ?></td>
                <td><?php echo $row['iName']; ?></td>
                <td><?php echo $row['iLicense']; ?></td>
                <td><?php echo $row['iAddress']; ?></td>
                <td><?php echo $row['iContact']; ?></td>
                <td><?php echo $row['iEmail']; ?></td>
                <td><img src="<?php echo $row['iImage']; ?>" style="height:150px; width:150px; border-radius:50%"></td>
                
            </tr>
           <?php
             }
            }
           ?>
        </table>
        
        </form>
    </div>
</center>