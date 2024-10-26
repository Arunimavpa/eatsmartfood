<?php
session_start();
include 'fibase.html';
include '../connection.php';
$id = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inspection Details</title>

    <!-- Bootstrap CSS for improved styling -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        h2 {
            color: #e18405; /* Burnt Orange */
            font-weight: bold;
        }

        #tbl {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
        }

        th {
            background-color: #feb451; /* Soft Orange */
            color: white;
            font-weight: bold;
            text-align: center;
        }

        td {
            text-align: center;
            padding: 12px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f9d5a4; /* Hover Light Orange */
        }

        .container {
            margin-top: 50px;
            margin-bottom: 50px;
        }

        .btn-report {
            background-color: #d9534f; /* Bootstrap Danger */
            color: white;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-report:hover {
            background-color: #c9302c; /* Darker Red */
            color: white;
        }
    </style>
</head>
<body>

    <div class="container">
        <hr>
        <h2 class="text-center">Inspection</h2>
        <hr>

        <form method="POST" enctype="multipart/form-data">
            <?php
            $sql = "SELECT * FROM tblinspection 
                    INNER JOIN tblinspector ON tblinspector.iId = tblinspection.iId
                    INNER JOIN tblrestaurant ON tblrestaurant.rId = tblinspection.rId
                    WHERE tblinspector.iId = '$id'";

            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
            ?>
                <table class="table table-bordered mt-5" id="tbl">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Restaurant</th>
                            <th>Request</th>
                            <th>Report Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_array($result)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['inspDate']); ?></td>
                            <td><?php echo htmlspecialchars($row['rName']); ?></td>
                            <td><?php echo htmlspecialchars($row['inspRequest']); ?></td>
                            <td>
                                <?php if ($row['status'] == 'Submitted') { ?>
                                    <a href="fireport.php?id=<?php echo $row['inspId']; ?>" class="btn-report">
                                        Add Report
                                    </a>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php
            } else {
                echo '<p class="text-center">No inspection records found.</p>';
            }
            ?>
        </form>
    </div>

    <!-- Bootstrap JS for responsive design -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
