<?php
// Start session and include necessary files
session_start();
include 'userbase.html';
include '../connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f0f4f8;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        .card {
            width: 600px;
            margin: 50px auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .card-header {
            background-color: #36d65f;
            color: white;
            text-align: center;
            padding: 15px;
            font-size: 24px;
            font-weight: bold;
        }

        .card-body {
            padding: 30px;
        }

        .form-control {
            margin-bottom: 15px;
        }

        .btn-submit {
            background-color: #28a745;
            border: none;
            color: white;
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #218838;
        }

        .select-restaurant {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-header">
            Feedback
        </div>

        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group select-restaurant">
                    <label for="restaurant">Select Restaurant</label>
                    <select class="form-control" id="restaurant" name="restaurant" required>
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
                </div>

                <div class="form-group">
                    <label for="feedback">Your Feedback</label>
                    <textarea class="form-control" id="feedback" name="feedback" rows="5" required></textarea>
                </div>

                <button type="submit" name="submit" class="btn-submit">Submit Feedback</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>

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
