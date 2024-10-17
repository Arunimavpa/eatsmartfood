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
        <h2 style="margin: 10px;">Restaurant Details</h2>
        <hr>

        <table border="0" id="tbl">
            <?php
            // SQL query to fetch all restaurants
            $sql = "SELECT * FROM tblrestaurant";
            $result = mysqli_query($conn, $sql);
            
            // Check if there are results in the query
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
             // Loop through each row in the result set
             while ($row = mysqli_fetch_array($result)) {
            ?>
            <tr>
                <td><?php echo $row['rId']; ?></td>
                <td><?php echo $row['rName']; ?></td>
                <td><?php echo $row['rLicense']; ?></td>
                <td><?php echo $row['rAddress']; ?></td>
                <td><?php echo $row['rContact']; ?></td>
                <td><?php echo $row['rEmail']; ?></td>
                <!-- Make the image clickable and redirect to the restaurantdetails.php page -->
                <td><a href="restaurantdetails.php?id=<?php echo $row['rId']; ?>"><img src="<?php echo $row['rImage']; ?>" style="height:150px; width:150px; border-radius:50%;"></a></td>
            </tr>
           <?php
             }
            } else {
                // Display a message if no data is available
                echo "<tr><td colspan='7'>No restaurants found.</td></tr>";
            }
           ?>
        </table>
        <!-- Voice Command Section -->

    </div>


</center>
