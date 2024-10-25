<?php
session_start();
include 'adminbase.html';
include '../connection.php';
?>
<style>
    /* Global Styles */
    body {
        background-color: #f5f5dc; /* Cream white background */
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
    }

    /* Card Style for Form */
    .form-card {
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        width: 500px;
        margin: 50px auto;
    }

    h2 {
        font-family: 'Roboto Slab', serif;
        color: #8e44ad;
        text-align: center;
        margin-bottom: 20px;
    }

    /* Form Input Styling */
    .form-control {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-family: 'Poppins', sans-serif;
    }

    /* Register Button Styling */
    .btn-register {
        background: linear-gradient(45deg, #8e44ad, #3498db);
        color: white;
        width: 100%;
        border: none;
        padding: 12px;
        font-size: 18px;
        border-radius: 5px;
        transition: background 0.3s ease, transform 0.2s;
        cursor: pointer;
    }

    .btn-register:hover {
        background: linear-gradient(45deg, #3498db, #8e44ad);
        transform: scale(1.05);
    }

    /* Table Card Layout */
    .table-card {
        width: 80%;
        margin: 30px auto;
        background: white;
        border-radius: 15px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        padding: 20px;
        overflow: hidden;
    }

    /* Table Styles */
    #tbl {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background-color: #8e44ad;
         color: white;
        padding: 10px;
        font-family: 'Roboto Slab', serif;
    }

    td {
        padding: 15px;
        text-align: center;
        font-family: 'Roboto Slab', serif;
        color: #391039  ;
    }

    tr:nth-child(even) {
        background-color: #f5f5dc; /* Light cream color */
    }

    tr:nth-child(odd) {
        background-color: #e8f6f3; /* Light blue color */
    }

    /* Row Hover Effect */
    tr:hover {
        background-color: rgba(142, 68, 173, 0.1); /* Light purple hover */
        transition: background 0.3s ease;
    }

    /* Link Styling */
    a {
        text-decoration: none;
        color: #3498db;
        font-weight: bold;
        transition: color 0.2s;
    }

    a:hover {
        color: #e74c3c;
    }
</style>

<center>
    <div class="form-card">
        <h2>Food Inspector Registration</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" class="form-control" name="name" placeholder="Name" pattern="[a-zA-Z ]+" required>
            <input type="text" class="form-control" name="license" placeholder="ID" required>
            <textarea class="form-control" name="address" placeholder="Address" required></textarea>
            <input type="text" class="form-control" name="contact" placeholder="Contact" pattern="[6789][0-9]{9}" required>
            <input type="email" class="form-control" name="email" placeholder="Email" required>
            <label>Upload Image:</label>
            <input type="file" class="form-control" name="file" accept="image/*" required>
            <label>Upload Proof:</label>
            <input type="file" class="form-control" name="proof" accept="image/*,application/pdf" required>
            <input type="submit" name="submit" class="btn-register" value="Register">
        </form>
    </div>

    <div class="table-card">
        <table id="tbl">
            <tr>
                <th>NAME</th>
                <th>LICENSE</th>
                <th>ADDRESS</th>
                <th>PHONE</th>
                <th>EMAIL</th>
                <th>PHOTO</th>
                <th>PROOF</th>
                <th>ACTION</th>
            </tr>
            <?php
            $sql = "SELECT * FROM tblinspector WHERE iEmail IN (SELECT username FROM tbllogin WHERE status='1')";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    echo '<tr>
                            <td>' . $row['iName'] . '</td>
                            <td>' . $row['iLicense'] . '</td>
                            <td>' . $row['iAddress'] . '</td>
                            <td>' . $row['iContact'] . '</td>
                            <td>' . $row['iEmail'] . '</td>
                            <td><img src="' . $row['iImage'] . '" style="height:100px; width:100px; border-radius:50%;"></td>
                            <td><img src="' . $row['pImage'] . '" style="height:100px; width:100px; border-radius:5%;"></td>
                            <td>
                                <a href="admininspectoredit.php?id=' . $row['iId'] . '">Update</a> ||
                                <a href="admininspectordelete.php?id=' . $row['iEmail'] . '">Delete</a>
                            </td>
                          </tr>';
                }
            } else {
                echo '<tr><td colspan="8">No Inspectors Found</td></tr>';
            }
            ?>
        </table>
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
    $proof = $folder . basename($_FILES['proof']['name']);

    move_uploaded_file($_FILES['file']['tmp_name'], $file);
    move_uploaded_file($_FILES['proof']['tmp_name'], $proof);

    $qry = "SELECT COUNT(*) FROM tbllogin WHERE lcase(username)='$email'";
    $res = mysqli_query($conn, $qry);
    $row = mysqli_fetch_array($res);

    if ($row[0] > 0) {
        echo '<script>alert("Email already exists");</script>';
    } else {
        $qry = "INSERT INTO tblinspector (iName, iAddress, iEmail, iContact, iLicense, iImage, pImage) 
                VALUES ('$name', '$address', '$email', '$contact', '$license', '$file', '$proof')";
        if (mysqli_query($conn, $qry)) {
            $qry = "INSERT INTO tbllogin (username, password, usertype, status) 
                    VALUES ('$email', '$contact', 'inspector', '1')";
            if (mysqli_query($conn, $qry)) {
                echo '<script>alert("Inspector registered successfully"); location.href="admininspector.php";</script>';
            } else {
                echo '<script>alert("Error during login creation");</script>';
            }
        } else {
            echo '<script>alert("Error during inspector registration");</script>';
        }
    }
}
?>
