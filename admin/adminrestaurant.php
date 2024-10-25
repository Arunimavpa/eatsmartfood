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

    /* Card Style for Table Sections */
    .table-card {
        width: 80%;
        margin: 30px auto;
        background: white;
        border-radius: 15px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        padding: 20px;
        overflow: hidden;
    }

    h2 {
        font-family: 'Roboto Slab', serif;
        color: #8e44ad;
        text-align: center;
        margin-bottom: 20px;
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
        background-color: #f5f5dc; /* Cream color */
    }

    tr:nth-child(odd) {
        background-color: #e8f6f3; /* Light blue */
    }

    /* Row Hover Effect */
    tr:hover {
        background-color: rgba(142, 68, 173, 0.1); /* Light purple hover effect */
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
    <div class="table-card">
        <h2>Restaurants to be Approved</h2>
        <?php
            $sql = "SELECT * FROM tblrestaurant WHERE rEmail IN (SELECT username FROM tbllogin WHERE status='0')";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
        ?>
        <table>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>LICENSE NO</th>
                <th>ADDRESS</th>
                <th>PHONE</th>
                <th>EMAIL</th>
                <th>PHOTO</th>
                <th>ACTION</th>
            </tr>
            <?php
                while ($row = mysqli_fetch_array($result)) {
                    echo '<tr>
                            <td>' . $row['rId'] . '</td>
                            <td>' . $row['rName'] . '</td>
                            <td>' . $row['rLicense'] . '</td>
                            <td>' . $row['rAddress'] . '</td>
                            <td>' . $row['rContact'] . '</td>
                            <td>' . $row['rEmail'] . '</td>
                            <td><img src="' . $row['rImage'] . '" style="height:150px; width:150px; border-radius:50%;"></td>
                            <td>
                                <a href="adminupdateuser.php?email=' . $row['rEmail'] . '&status=1">Approve</a> ||
                                <a href="adminupdateuser.php?email=' . $row['rEmail'] . '&status=-1">Reject</a>
                            </td>
                          </tr>';
                }
            ?>
        </table>
        <?php
            } else {
                echo '<p>No restaurants to approve.</p>';
            }
        ?>
    </div>

    <div class="table-card">
        <h2>Approved Restaurants</h2>
        <?php
            $sql = "SELECT * FROM tblrestaurant WHERE rEmail IN (SELECT username FROM tbllogin WHERE status='1')";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
        ?>
        <table>
            <tr>
                
                <th>NAME</th>
                <th>LICENSE NO</th>
                <th>ADDRESS</th>
                <th>PHONE</th>
                <th>EMAIL</th>
                <th>PHOTO</th>
            </tr>
            <?php
                while ($row = mysqli_fetch_array($result)) {
                    echo '<tr>
                           
                            <td>' . $row['rName'] . '</td>
                            <td>' . $row['rLicense'] . '</td>
                            <td>' . $row['rAddress'] . '</td>
                            <td>' . $row['rContact'] . '</td>
                            <td>' . $row['rEmail'] . '</td>
                            <td><img src="' . $row['rImage'] . '" style="height:150px; width:150px; border-radius:50%;"></td>
                          </tr>';
                }
            ?>
        </table>
        <?php
            } else {
                echo '<p>No approved restaurants found.</p>';
            }
        ?>
    </div>
</center>
