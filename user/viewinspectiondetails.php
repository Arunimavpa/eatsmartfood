<?php
session_start();
include 'userbase.html';
include '../connection.php';
$id = $_REQUEST['id'];

// Validate and sanitize the input to prevent SQL injection
$id = mysqli_real_escape_string($conn, $id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inspection Details</title>

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
            width: 70%;
            margin: 50px auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .card-header {
            background-color: #35d578;
            color: white;
            text-align: center;
            padding: 15px;
            font-size: 24px;
            font-weight: bold;
        }

        .card-body {
            padding: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 15px;
            text-align: center;
        }

        th {
            background-color: #35d578;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tr:hover {
            background-color: rgba(53, 213, 120, 0.2);
        }

        h3 {
            color: #033002;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-header">
            Inspection Details
        </div>

        <div class="card-body">
            <?php
            // SQL query to fetch inspection details
            $sql = "SELECT i.inspId, i.inspDate, r.report, r.rating 
                    FROM tblinspection i
                    JOIN tblresponse r ON i.inspId = r.inspId
                    WHERE i.rId = '$id'";

            $result = mysqli_query($conn, $sql);

            if ($result) {
                if (mysqli_num_rows($result) > 0) {
            ?>
                    <table border="0">
                        <tr>
                            <th>Date of Inspection</th>
                            <th>Report</th>
                            <th>Rating</th>
                        </tr>
                        <?php
                        while ($row = mysqli_fetch_array($result)) {
                        ?>
                            <tr>
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
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
