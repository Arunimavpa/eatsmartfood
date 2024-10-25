<?php
// Start session and include necessary files
session_start();
include 'userbase.html';
include '../connection.php';
?>

<!-- Style block should be outside PHP -->
<style>
    th, td {
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

<!-- Feedback Form UI -->
<center>
    <div style="margin: 50px;">
        <hr>
        <h2 style="margin: 10px;">Feedback</h2>
        <hr>
        <form method="POST" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Restaurant</td>
                    <td>
                        <select class="form-control" name="restaurant" required>
                            <option selected disabled>Select restaurant</option>
                            <?php
                            // Fetch active restaurants from the database
                            $sql = "SELECT * FROM tblrestaurant WHERE rEmail IN (SELECT username FROM tbllogin WHERE status='1')";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<option value='{$row['rId']}'>{$row['rName']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Feedback</td>
                    <td><textarea class="form-control" name="feedback" required></textarea></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" class="btn btn-danger" style="color: white; width: 400px;" value="Submit">
                    </td>
                </tr>
            </table>
        </form>

        <br><br><br>
        <hr>

        <!-- Feedback Table -->
        <h2 style="margin: 10px;">Submitted Feedbacks</h2>
        <table border="0" id="tbl">
            <tr>
                <th>ID</th>
                <th>DATE</th>
                <th>RESTAURANT</th>
                <th>FEEDBACK</th>
                <th>REPLY</th>
            </tr>

            
            <?php
            // Fetch feedback and replies from the database
            $sql = "SELECT f.fId, f.fDate, f.feedback, r.reply,t.rName 
                    FROM tblfeedback f 
                    LEFT JOIN tblreply r ON f.fId = r.fId
                    INNER JOIN tblrestaurant t ON f.rId = t.rId";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>
                            <td>{$row['fId']}</td>
                            <td>{$row['fDate']}</td>
                            <td>{$row['rName']}</td>
                            <td>{$row['feedback']}</td>
                            <td>{$row['reply']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No feedback available.</td></tr>";
            }
            ?>
        </table>
    </div>
</center>

<?php
// Handle form submission for new feedback
if (isset($_POST['submit'])) {
    $restaurant = $_POST['restaurant'];
    $feedback = $_POST['feedback'];

    // Insert the feedback into the database
    $qry = $conn->prepare("INSERT INTO tblfeedback (rId, fDate, feedback, status) VALUES (?, NOW(), ?, 'Submitted')");
    $qry->bind_param("is", $restaurant, $feedback);

    if ($qry->execute()) {
        echo '<script>alert("Feedback submitted successfully!"); location.href="publicfeedback.php";</script>';
    } else {
        echo '<script>alert("Sorry, an error occurred.");</script>';
    }
}
?>
