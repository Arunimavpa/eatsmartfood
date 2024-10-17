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
        <h2 style="margin: 10px;">Food Inspector</h2>
        <hr>
        <form method="POST" enctype="multipart/form-data">
    
            <table>
                <tr>
                    <td>Name</td>
                    <td><input type="text" class="form-control" name="name" pattern="[a-zA-Z ]+" required></td>
                </tr>
                <tr>
                    <td>ID</td>
                    <td><input type="text" class="form-control" name="license"  required></td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td><textarea class="form-control" name="address" required></textarea></td>
                </tr>
                <tr>
                    <td>Contact</td>
                    <td><input type="text" class="form-control" name="contact" pattern="[6789][0-9]{9}" required></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type="email" class="form-control" name="email" required></td>
                </tr>
                <tr>
                    <td>Upload image</td>
                    <td><input type="file" class="form-control" name="file" required></td>
                </tr>
                <tr>
                    <td>Upload proof</td>
                    <td><input type="file" class="form-control" name="file" required></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="submit" class="btn btn-danger" style="color: white; width:400px;"
                            value="Register"></td>
                </tr>
            </table>
           
            <br><br><br><hr>
        <table border="0" id="tbl" >
            <?php
            $sql = "select * from tblinspector where iEmail in(select username from tbllogin where status='1')";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
            ?>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>ID</th>
                <th>ADDRESS</th>
                <th>PHONE</th>
                <th>EMAIL</th>
                <th>PHOTO</th>
                <th>PROOF</th>
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
                
                <td><img src="<?php echo $row['ipImage']; ?>" style="height:150px; width:150px; border-radius:50%"></td>
                <td><a href="admininspectoredit.php?id=<?php echo $row['iId'];?>">Update</a> || 
                <a href="admininspectordelete.php?id=<?php echo $row['iEmail'];?>">Delete</a></td>
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
    $folder = '../images/';
    $file = $folder . basename($_FILES['file']['name']);
    move_uploaded_file($_FILES['file']['tmp_name'], $file);
    $qry = "select count(*) from tbllogin where lcase(username)='$email'";
    $res = mysqli_query($conn, $qry);
    $row = mysqli_fetch_array($res);
    if ($row[0] > 0) {
        echo '<script>alert("Email already exist");</script>';
    } else {
        $qry = "insert into tblinspector(iName,iAddress,iEmail,iContact,iLicense,iImage) values('$name','$address','$email','$contact','$license','$file')";
        $res = mysqli_query($conn, $qry);
        if ($res) {
            $qry = "insert into tbllogin (username,password,usertype,status) values('$email','$contact','inspector','1')";
            $res = mysqli_query($conn, $qry);
            if ($res) {
                echo '<script>alert("Data added successfully");location.href="admininspector.php";</script>';
            } else {
                echo '<script>alert("Sorry some error occured");</script>';
            }
        } else {
            echo '<script>alert("Sorry some error occured");</script>';
        }
    }
}
?>