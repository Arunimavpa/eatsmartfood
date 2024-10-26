<?php
include 'userbase.html';
include '../connection.php';

// Ensure the restaurant ID is passed via the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];  // Restaurant's ID from the URL
} else {
    echo '<script>alert("No restaurant selected. Please go back and try again."); location.href="index.php";</script>';
    exit;
}
?>

<style>
    th, td {
        padding: 10px;
    }

    th {
        background-color:#35d578 ;
        color: white;
    }
    h2{
        color: #35d578;
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
        // Fetch feedback for the specific restaurant using the ID from the URL
        $sql = "SELECT f.fId, 
        DATE_FORMAT(f.fDate, '%Y-%m-%d') AS feedback_date, 
        DATE_FORMAT(f.fDate, '%H:%i:%s') AS feedback_time, 
        f.feedback, 
        r.rName, 
        rp.reply 
 FROM tblfeedback f
 INNER JOIN tblrestaurant r ON f.rId = r.rId
 LEFT JOIN tblreply rp ON f.fId = rp.fId  -- Link replies to feedback
 WHERE f.rId = ?";


        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);  // Use prepared statements for security
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
        ?>
        <table border="0" id="tb">
            <tr>
                <th>Date</th>
                <th>time</th>
                <th>Feedback</th>
                <th>Reply</th>
            </tr>

            <?php
            while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo $row['feedback_date']; ?></td>
                <td><?php echo $row['feedback_time']; ?></td>
                <td><?php echo $row['feedback']; ?></td>
                <td>
                <?php 
                    echo htmlspecialchars($row['reply'] ?? 'No reply yet'); 
                    ?></td>
            </tr>
            <?php
            }
            ?>
        </table>

        <?php
        } else {
            echo "<p>No feedback available for this restaurant.</p>";
        }
        ?>
    </div>
</center>
