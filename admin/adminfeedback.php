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
        <h2 style="margin: 10px;">Feedback</h2>
        <hr>

        <?php
            $sql = "select * from tblfeedback,tblpublic,tblrestaurant where tblfeedback.rId=tblrestaurant.rId and tblfeedback.pId=tblpublic.pId";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
            ?>
        <table border="0" id="tb" >
            
            <tr>
                <th>ID</th>
                <th>NAME OF USER</th>
                <th>RESTAURANT</th>
                <th>DATE</th>
                <th>FEEDBACK</th>
                <th colspan="2">STATUS</th>
            </tr>
            <?php
            while($row=mysqli_fetch_array($result)) {
            ?>
            <tr>
                <td><?php echo $row['fId'];?></td>
                <td><?php echo $row['pName'];?></td>
                <td><?php echo $row['rName'];?></td>
                <td><?php echo $row['fDate'];?></td>
                <td><?php echo $row['feedback'];?></td>
                <td><?php echo $row['status'];?></td>
                <?php
                if($row['status']=='Submitted')
                {
                ?>
                <td><a href="adminreply.php?email=<?php echo $row['fId'];?>&status=1">Add reply</a></td>
                <?php
            }
            ?>
            </tr>
       <?php
             }
            }
           ?>
        </table>

        </div>
</center>
