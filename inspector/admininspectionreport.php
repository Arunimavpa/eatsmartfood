<?php
session_start();
include 'fibase.html';
include '../connection.php';
$inspId = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inspection Report</title>

    <!-- Bootstrap CSS -->
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
            background-color: #feb451 ; /* Warm Red */
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
            background-color: #f9d5a4 ; /* Light Red on hover */
        }

        .container {
            margin-top: 50px;
            margin-bottom: 50px;
        }

        .btn-action {
            background-color: #d9534f; /* Bootstrap Danger Red */
            color: white;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-action:hover {
            background-color: #c9302c; /* Darker Red */
            color: white;
        }
    </style>
</head>
<body>

    <div class="container">
        <hr>
        <h2 class="text-center">Inspection Report</h2>
        <hr>

        <form method="POST" enctype="multipart/form-data">
            <?php
            $sql = "SELECT * FROM tblinspection 
                    JOIN tblinspector ON tblinspection.iId = tblinspector.iId 
                    JOIN tblrestaurant ON tblinspection.rId = tblrestaurant.rId 
                    JOIN tblresponse ON tblinspection.inspId = tblresponse.inspId 
                    WHERE tblinspection.inspId = '$inspId'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
            ?>
            <table class="table table-bordered mt-5" id="tbl">
                <thead>
                    <tr>
                        
                        <th>Food Inspector</th>
                        <th>Restaurant</th>
                        <th>Inspection Date</th>
                        <th>Report Date</th>
                        <th>Report</th>
                        <th>Rating</th>
                        <th>Fine</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                    <tr>
                        
                        <td><?php echo htmlspecialchars($row['iName']); ?></td>
                        <td><?php echo htmlspecialchars($row['rName']); ?></td>
                        <td><?php echo htmlspecialchars($row['inspDate']); ?></td>
                        <td><?php echo htmlspecialchars($row['repDate']); ?></td>
                        <td><?php echo htmlspecialchars($row['report']); ?></td>
                        <td><?php echo htmlspecialchars($row['rating']); ?></td>
                        <?php
                        $sq = "SELECT status, amt FROM tblpenalty WHERE repId = '{$row['repId']}'";
                        $qs = mysqli_query($conn, $sq);

                        if ($qs) {
                            $eq = mysqli_fetch_array($qs);
                            if ($eq) {
                                echo "<td>{$eq['amt']}</td>";
                                if ($eq['status'] == 'Assigned') {
                                    echo "<td>
                                        <a href='incrementpenalty.php?id={$row['repId']}' class='btn-action'>Add Extra Fine</a>
                                        <a href='penaltypaid.php?id={$row['repId']}' class='btn-action'>Paid</a>
                                    </td>";
                                } else {
                                    echo "<td>No further actions</td>";
                                }
                            } else {
                                echo "<td>No Penalty Assigned</td>";
                            }
                        } else {
                            echo "<td>Error fetching penalty data</td>";
                        }
                        ?>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php
            } else {
                echo '<h3 class="text-center">No report added</h3>';
            }
            ?>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
