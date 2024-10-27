<?php
session_start();
include 'restaurantbase.html';
include '../connection.php';

$id = $_SESSION['id']; // Restaurant ID from session
$inspId = isset($_GET['id']) ? $_GET['id'] : null; // Get specific inspection ID if provided in URL
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inspection Reports</title>

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
            text-align: center;
            margin-bottom: 20px;
        }

        #tbl {
            width: 90%;
            margin: 20px auto;
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

        .btn-action {
            background-color: #d9534f;
            color: white;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-action:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
    <center>
        <div style="margin: 50px;">
            <h2>Inspection Reports</h2>

            <?php
            // Display the list of inspection reports for the restaurant
            $sql = "SELECT tblinspector.iName, tblinspection.inspId, tblinspection.inspDate, tblresponse.repDate, 
                           tblresponse.report, tblresponse.rating, tblresponse.repId, tblblacklist.status AS blacklist_status
                    FROM tblinspection
                    INNER JOIN tblinspector ON tblinspection.iId = tblinspector.iId
                    INNER JOIN tblresponse ON tblinspection.inspId = tblresponse.inspId
                    LEFT JOIN tblblacklist ON tblblacklist.repId = tblresponse.repId
                    WHERE tblinspection.rId = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
            ?>
                <table id="tbl">
                    <tr>
                        <th>Food Inspector</th>
                        <th>Inspection Date</th>
                        <th>Report Date</th>
                        <th>Report</th>
                        <th>Rating</th>
                        <th>Action</th>
                        <th>Blacklisted Status</th>
                        <th>Details</th>
                    </tr>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['iName']); ?></td>
                            <td><?php echo htmlspecialchars($row['inspDate']); ?></td>
                            <td><?php echo htmlspecialchars($row['repDate']); ?></td>
                            <td><?php echo htmlspecialchars($row['report']); ?></td>
                            <td><?php echo htmlspecialchars($row['rating']); ?></td>
                            <td>
                                <?php if ($row['rating'] <= 2) { ?>
                                    <a href="restaurantpenalty.php?id=<?php echo htmlspecialchars($row['repId']); ?>" class="btn-action">View Penalty</a>
                                <?php } ?>
                            </td>
                            <td><?php echo $row['blacklist_status'] == '1' ? 'Blacklisted' : 'Not Blacklisted'; ?></td>
                            <td>
                            <a href="/eatsmartfood/inspector/view_report_file.php?id=<?php echo $row['repId']; ?>" class="btn-action">Show Report File</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            <?php
            } else {
                echo '<h3>No inspection reports available.</h3>';
            }

            $stmt->close();
            ?>


        </div>
    </center>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
