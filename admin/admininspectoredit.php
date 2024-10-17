<?php
session_start();
include 'adminbase.html';
include '../connection.php';
$id = $_GET['id'];
$sql = "select * from tblinspector where iId='$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
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
        <h2 style="margin: 10px;">Food Inspector</h2>
        <hr>
        <form method="POST" enctype="multipart/form-data">

            <table>
                <tr>
                    <td>Name</td>
                    <td><input type="text" class="form-control" name="name" pattern="[a-zA-Z ]+" value="<?php echo $row['iName']; ?>" readonly></td>
                </tr>
                <tr>
                    <td>ID</td>
                    <td><input type="text" class="form-control" name="license" value="<?php echo $row['iLicense']; ?>" readonly></td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td><textarea class="form-control" name="address" required><?php echo $row['iAddress']; ?></textarea></td>
                </tr>
                <tr>
                    <td>Contact</td>
                    <td><input type="text" class="form-control" name="contact" pattern="[6789][0-9]{9}" value="<?php echo $row['iContact']; ?>" required></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type="email" class="form-control" name="email" value="<?php echo $row['iEmail']; ?>" required></td>
                </tr>

                <tr>
                    <td colspan="2"><input type="submit" name="submit" class="btn btn-danger" style="color: white; width:400px;" value="Update"></td>
                </tr>
            </table>

            <br><br><br>
            <hr>
            <table border="0" id="tbl">
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
                        <th></th>
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
                            <td><a href="admininspectoredit.php?id=<?php echo $row['iId']; ?>">Update</a> ||
                                <a href="admininspectordelete.php?id=<?php echo $row['iEmail']; ?>">Delete</a>
                            </td>
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
    $name = $_POST['name'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $license = $_POST['license'];

    $qry = "update tblinspector set iName='$name',iAddress='$address',iContact='$contact',iLicense='$license' where iEmail='$email'";
    $res = mysqli_query($conn, $qry);
    if ($res) {
        echo '<script>alert("Data updated successfully");location.href="admininspector.php";</script>';
        
    } else {
        echo '<script>alert("Sorry some error occured");</script>';
    }
}
?>