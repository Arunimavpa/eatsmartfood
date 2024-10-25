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
    <title>Inspection Report</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        /* Global Styles */
        body {
            background-color: #eafaf1; /* Light green background */
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        h2 {
            color: #27ae60; /* Green heading */
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Table Styles */
        #tbl {
            width: 90%; /* Wider table */
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        th {
            background-color: #27ae60; /* Green header */
            color: white;
            padding: 12px;
            font-weight: bold;
        }

        td {
            padding: 12px;
            text-align: left;
            color: #34495e;
        }

        tr:nth-child(even) {
            background-color: #f5f5f5; /* Light background */
        }

        tr:nth-child(odd) {
            background-color: #e8f6f3; /* Light blue background */
        }

        tr:hover {
            background-color: rgba(39, 174, 96, 0.2); /* Hover effect */
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
            #tbl {
                width: 100%; /* Responsive adjustment */
            }
        }
    </style>
</head>

<body>
    <center>
        <div style="margin: 50px;">
            <h2>Inspection Report</h2>
            <form method="POST" enctype="multipart/form-data">
                <?php
                $sql = "SELECT * FROM tblinspection, tblinspector, tblrestaurant, tblresponse, tblblacklist 
                        WHERE tblinspector.iEmail IN (SELECT username FROM tbllogin WHERE STATUS='1') 
                        AND tblinspection.iId = tblinspector.iId 
                        AND tblinspection.rId = tblrestaurant.rId 
                        AND tblblacklist.repId = tblresponse.repId 
                        AND tblinspection.inspId = tblresponse.inspId 
                        AND tblinspection.rId = '$id'";

                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                ?>
                    <table id="tbl">
                        <tr>
                        <th>FOOD INSPECTOR</th>
                        <th>INSPECTION DATE</th>
                        <th>REPORT DATE</th>
                        <th>REPORT</th>
                        <th>RATING</th>
                        <th>ACTION</th>
                        <th>BLACKLISTED OR NOT</th>
                        </tr>
                        <?php
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                        
                            <td><?php echo $row['iName']; ?></td>
                            
                            <td><?php echo $row['inspDate']; ?></td>
                            <td><?php echo $row['repDate']; ?></td>
                            <td><?php echo $row['report']; ?></td>
                            <td><?php echo $row['rating']; ?></td>
                            <?php
                            if($row['rating']<=2)
                            {
                            ?>
                            <td><a href="restaurantpenalty.php?id=<?php echo $row['repId']; ?>">View penalty</a></td>
                            <?php
                            }
                            if($row['status']=='1'){
                                ?>
                            <td>Blacklisted</td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </table>
                <?php
                } else {
                    echo '<h3>No reports available</h3>';
                }
                ?>
            </form>
        </div>
    </center>
</body>
</html>
