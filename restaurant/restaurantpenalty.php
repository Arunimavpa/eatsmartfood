<?php
session_start();
include 'restaurantbase.html';
include '../connection.php';
$id = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penalty Details</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.css">
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
            text-align: center;
            margin-bottom: 20px;
        }

        #tbl {
            width: 50%;
            margin: 40px auto;
            border-collapse: collapse;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: center;
            color: #34495e;
        }

        th {
            background-color: #27ae60;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f5f5f5;
        }

        tr:nth-child(odd) {
            background-color: #e8f6f3;
        }

        tr:hover {
            background-color: rgba(39, 174, 96, 0.2);
        }

        .btn {
            background-color: #007bff;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <center>
        <div style="margin: 50px;">
            <h2>Penalty Details</h2>
            <form method="POST" enctype="multipart/form-data">
                <?php
                $sql = "SELECT * FROM tblpenalty 
                        WHERE repId IN (
                            SELECT repId FROM tblresponse 
                            WHERE inspId IN (
                                SELECT inspId FROM tblinspection 
                                WHERE rId='$id'
                            )
                        )";

                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                ?>
                    <table id="tbl">
                        <tr>
                            <th>Penalty</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Pay Fine</th>
                        </tr>
                        <?php
                        while ($row = mysqli_fetch_array($result)) {
                        ?>
                            <tr>
                                <td>$<?php echo $row['amt']; ?></td>
                                <td><?php echo $row['duedate']; ?></td>
                                <td><?php echo $row['status']; ?></td>
                                <td>
                                    <?php if ($row['status'] == 'Assigned') { ?>
                                        <a href="pay_fine.php?repId=<?php echo $row['repId']; ?>" class="btn">Pay Fine</a>
                                    
                                    <?php } else { ?>
                                        Paid
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php 
                } else {
                    echo '<h3>No data available</h3>';
                }
                ?>
            </form>
        </div>
    </center>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
