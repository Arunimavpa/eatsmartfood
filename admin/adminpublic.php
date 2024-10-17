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
        <h2 style="margin: 10px;">Public users</h2>
        <hr>
        <?php
            $sql = "select * from tblpublic where pEmail in(select username from tbllogin where status='1')";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
            ?>
        <table border="0" id="tb" >
         
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>ADDRESS</th>
                <th>PHONE</th>
                <th>EMAIL</th>
            </tr>
            <?php
            while($row=mysqli_fetch_array($result)) {
            ?>
            <tr>
                <td><?php echo $row['pId']; ?></td>
                <td><?php echo $row['pName']; ?></td>
                <td><?php echo $row['pAddress']; ?></td>
                <td><?php echo $row['pContact']; ?></td>
                <td><?php echo $row['pEmail']; ?></td>
            </tr>
        <?php    
            }
      echo "</table>";
        
             
            }
           ?>
    </div>
</center>