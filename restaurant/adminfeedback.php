<?php
session_start();
include 'restaurantbase.html';
include '../connection.php';

// Ensure the session ID is set
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];  // Restaurant's ID from session
} else {
    echo '<script>alert("Session expired. Please log in."); location.href="login.php";</script>';
    exit;
}
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
        <h2 style="margin: 10px;">Feedback</h2>
        <hr>

        <?php
        // Fetch feedbacks for the logged-in restaurant only
        $sql = "SELECT f.fId, f.fDate, f.feedback, f.status, r.rName 
                FROM tblfeedback f 
                INNER JOIN tblrestaurant r ON f.rId = r.rId 
                WHERE f.rId = '$id'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
        ?>
        <table border="0" id="tb">
            <tr>
                
               
                <th>Date</th>
                <th>Feedback</th>
                <th>Status</th>
                <th>Reply</th>
            </tr>

            <?php
            while ($row = mysqli_fetch_array($result)) {
            ?>
            <tr>
                
               
                <td><?php echo $row['fDate']; ?></td>
                <td><?php echo $row['feedback']; ?></td>
                <td><?php echo $row['status']; ?></td>

                <?php if ($row['status'] == 'Submitted') { ?>
                    <td><a href="restaurantreply.php?email=<?php echo $row['fId']; ?>&status=1">Add reply</a></td>
                <?php } else { ?>
                    <td>-</td>
                <?php } ?>
            </tr>
            <?php
            }
            ?>
        </table>

        <?php
        } else {
            echo "<p>No feedback available for your restaurant.</p>";
        }
        ?>
    </div>
</center>
