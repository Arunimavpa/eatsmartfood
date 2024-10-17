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
    table{
        width:1050px;
    }
</style>
<center>

    <div style="margin: 50px;">
        <hr>
        <h2 style="color:white">Restaurants</h2>
        <hr>

        <?php
            $sql = "select * from tblrestaurant where rEmail in(select username from tbllogin where status='0')";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
            ?>
        <table border="0" id="tb" >
            <tr><caption>Restaurants to be approved</caption></tr>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>LICENSE NO</th>
                <th>ADDRESS</th>
                <th>PHONE</th>
                <th>EMAIL</th>
                <th>PHOTO</th>
                <th></th>
            </tr>
            <?php
            while($row=mysqli_fetch_array($result)) {
            ?>
            <tr>
                <td><?php echo $row['rId'];?></td>
                <td><?php echo $row['rName'];?></td>
                <td><?php echo $row['rLicense'];?></td>
                <td><?php echo $row['rAddress'];?></td>
                <td><?php echo $row['rContact'];?></td>
                <td><?php echo $row['rEmail'];?></td>
                <td><img src="<?php echo $row['rImage'];?>" style="height:150px; width:150px; border-radius:50%"></td>
                <td><a href="adminupdateuser.php?email=<?php echo $row['rEmail'];?>&status=1">Approve</a> || 
                    <a href="adminupdateuser.php?email=<?php echo $row['rEmail'];?>&status=-1">Reject</a></td>
            </tr>
       <?php
             }
            }
           ?>
        </table>

        <br>
        <hr>
        <br>
   <?php
            $sql = "select * from tblrestaurant where rEmail in(select username from tbllogin where status='1')";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
            ?>
        <table border="0" id="tb" >
            <tr><caption>Approved Restaurants</caption></tr>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>LICENSE NO</th>
                <th>ADDRESS</th>
                <th>PHONE</th>
                <th>EMAIL</th>
                <th>PHOTO</th>
                <th></th>
            </tr>
            <?php
            while($row=mysqli_fetch_array($result)) {
            ?>
            <tr>
            <td><?php echo $row['rId'];?></td>
                <td><?php echo $row['rName'];?></td>
                <td><?php echo $row['rLicense'];?></td>
                <td><?php echo $row['rAddress'];?></td>
                <td><?php echo $row['rContact'];?></td>
                <td><?php echo $row['rEmail'];?></td>
                <td><img src="<?php echo $row['rImage'];?>" style="height:150px; width:150px; border-radius:50%"></td>
            </tr>
            <?php
             }
            }
           ?>
        </table>

    </div>
</center>
