<?php
session_start();
include 'adminbase.html';
include '../connection.php';
?>
<style>
    /* Global Styles */
    body {
        background-color: #f5f5dc;
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
    }

    /* Card Container */
    .form-card, .table-card {
        width: 80%;
        margin: 30px auto;
        background: white;
        border-radius: 15px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        padding: 20px;
        overflow: hidden;
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
    }

    /* Dropdown Styling Fix */
    select.form-control {
        overflow: auto;
        word-wrap: break-word;
        max-width: 100%;
        min-width: 250px;
    }

    select.form-control option {
        white-space: normal; /* Allow text wrapping inside options */
    }

    /* Submit Button */
    .btn-submit {
        background: linear-gradient(45deg, #8e44ad, #3498db);
        color: white;
        width: 100%;
        border: none;
        padding: 12px;
        font-size: 18px;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s ease, transform 0.2s;
    }

    .btn-submit:hover {
        background: linear-gradient(45deg, #3498db, #8e44ad);
        transform: scale(1.05);
    }

    /* Table Styling */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th {
        background-color: #8e44ad;
        color: white;
        padding: 15px;
        font-family: 'Roboto Slab', serif;
    }

    td {
        padding: 15px;
        text-align: center;
        font-family: 'Roboto Slab', serif;
        color: #8e44ad;
    }

    tr:nth-child(even) {
        background-color: #f5f5dc;
    }

    tr:nth-child(odd) {
        background-color: #e8f6f3;
    }

    tr:hover {
        background-color: rgba(142, 68, 173, 0.1);
        transition: background 0.3s ease;
    }

    a {
        text-decoration: none;
        color: #3498db;
        font-weight: bold;
    }

    a:hover {
        color: #e74c3c;
    }
</style>

<center>
    <div class="form-card">
        <h2>Inspection Request</h2>
        <form method="POST" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Food Inspector</td>
                    <td>
                        <select class="form-control" name="inspector" required>
                            <option selected disabled>Select inspector</option>
                            <?php
                            $sql = "SELECT * FROM tblinspector WHERE iEmail IN (SELECT username FROM tbllogin WHERE status='1')";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                                echo '<option value="' . $row['iId'] . '">' . $row['iName'] . '</option>';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Restaurant</td>
                    <td>
                        <select class="form-control" name="restaurant" required>
                            <option selected disabled>Select restaurant</option>
                            <?php
                            $sql = "SELECT * FROM tblrestaurant WHERE rEmail IN (SELECT username FROM tbllogin WHERE status='1')";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                                echo '<option value="' . $row['rId'] . '">' . $row['rName'] . '</option>';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Inspection Date</td>
                    <td>
                        <input type="date" class="form-control" name="date" min="<?php echo date('Y-m-d'); ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>Request</td>
                    <td>
                        <textarea class="form-control" name="request" required></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" class="btn-submit" value="Submit">
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <div class="table-card">
        <h2>Inspection Requests</h2>
        <?php
        $sql = "SELECT * FROM tblinspection 
                JOIN tblinspector ON tblinspector.iId = tblinspection.iId 
                JOIN tblrestaurant ON tblrestaurant.rId = tblinspection.rId 
                WHERE tblinspector.iEmail IN (SELECT username FROM tbllogin WHERE status='1')";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
        ?>
        <table>
            <tr>
                <th>FOOD INSPECTOR</th>
                <th>RESTAURANT</th>
                <th>INSPECTION DATE</th>
                <th>REQUEST</th>
                <th>REPORT</th>
                <th>PAYMENT</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_array($result)) {
                echo '<tr>
                        <td>' . $row['iName'] . '</td>
                        <td>' . $row['rName'] . '</td>
                        <td>' . $row['inspDate'] . '</td>
                        <td>' . $row['inspRequest'] . '</td>
                        <td><a href="admininspectionreport.php?id=' . $row['inspId'] . '">View report</a></td>
                      </tr>';
            }
            ?>
        </table>
        <?php
        } else {
            echo '<p>No inspection requests found.</p>';
        }
        ?>
    </div>
</center>

<?php
if (isset($_POST['submit'])) {
    $inspector = $_POST['inspector'];
    $restaurant = $_POST['restaurant'];
    $date = $_POST['date'];
    $request = $_POST['request'];

    $qry = "INSERT INTO tblinspection (iId, rId, inspDate, inspRequest, status) 
            VALUES ('$inspector', '$restaurant', '$date', '$request', 'Submitted')";
    $res = mysqli_query($conn, $qry);

    if ($res) {
        echo '<script>alert("Inspection request added successfully"); location.href="admininspection.php";</script>';
    } else {
        echo '<script>alert("Error occurred while adding the inspection request");</script>';
    }
}
?>
