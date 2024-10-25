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
            background-color: #eafaf1;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        h2 {
            color: #27ae60;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        .table-container {
            width: 80%;
            margin: 50px auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #27ae60;
            color: white;
            text-align: center;
            padding: 15px;
        }

        td {
            padding: 15px;
            text-align: center;
            color: #34495e;
        }

        tr:nth-child(even) {
            background-color: #f5f5f5;
        }

        tr:nth-child(odd) {
            background-color: #e8f6f3;
        }

        tr:hover {
            background-color: rgba(39, 174, 96, 0.2);
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

        @media (max-width: 768px) {
            .table-container {
                width: 100%;
                margin: 20px auto;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="table-container">
            <h2>Feedback</h2>

            <?php
            // Fetch feedbacks for the logged-in restaurant only
            $sql = "SELECT f.fId, f.fDate, f.feedback, f.status, r.rName 
                    FROM tblfeedback f 
                    INNER JOIN tblrestaurant r ON f.rId = r.rId 
                    WHERE f.rId = '$id'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
            ?>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Feedback</th>
                        <th>Status</th>
                        <th>Reply</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                        // Split the fDate into date and time
                        $dateTime = explode(' ', $row['fDate']);
                        $date = $dateTime[0];
                        $time = $dateTime[1];
                    ?>
                    <tr>
                        <td><?php echo $date; ?></td>
                        <td><?php echo $time; ?></td>
                        <td><?php echo $row['feedback']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td>
                            <?php if ($row['status'] == 'Submitted') { ?>
                                <a href="restaurantreply.php?email=<?php echo $row['fId']; ?>&status=1">Add reply</a>
                            <?php } else { ?>
                                -
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php
            } else {
                echo "<p>No feedback available for your restaurant.</p>";
            }
            ?>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
