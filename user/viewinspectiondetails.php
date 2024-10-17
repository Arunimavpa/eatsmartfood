<?php
session_start();
include 'userbase.html';
include '../connection.php';
$id = $_REQUEST['id'];

// Validate and sanitize the input to prevent SQL injection
$id = mysqli_real_escape_string($conn, $id);
?>
<style>
    th, td {
        padding: 10px;
    }

    th {
        background-color: brown;
        color: white;
    }
    table {
        width: 1050px;
    }
</style>
<center>
    <div style="margin: 50px;">
        <hr>
        <h2 style="margin: 10px;">Inspection Details</h2>
        <hr>

        <?php
        // Adjusted SQL query with correct column names
        $sql = "SELECT i.inspId, i.inspDate, r.report, r.rating 
                FROM tblinspection i
                JOIN tblresponse r ON i.inspId = r.inspId
                WHERE i.rId = '$id'";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
        ?>
                <table border="0" id="tb">
                    <tr>
                        <th>ID</th>
                        <th>Date of Inspection</th>
                       
                        <th>Report</th>
                        <th>Rating</th>
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['inspId']); ?></td>
                            <td><?php echo htmlspecialchars($row['inspDate']); ?></td>
           
                            <td><?php echo htmlspecialchars($row['report']); ?></td>
                            <td><?php echo htmlspecialchars($row['rating']); ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
        <?php
            } else {
                echo '<h3>No inspection details found</h3>';
            }
        } else {
            echo '<h3>Error executing query: ' . mysqli_error($conn) . '</h3>';
        }
        ?>
    </div>
</center>
