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
        <h2 style="margin: 10px;">Blacklist</h2>
        <hr>
        <form method="POST" enctype="multipart/form-data">
            <?php
            $sql = "select * from tblrestaurant where rId in(select rId from tblinspection where inspId in(select inspId from tblresponse where repId in(select repId from tblblacklist where status ='1')))";
            // echo $sql;
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
            ?>
                <br><br><br>
                <hr>
                <table border="0" id="tbl">
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
                
                    <?php } ?>
                </table>
            <?php 
            } 
            ?>
        </form>
    </div>
</center>