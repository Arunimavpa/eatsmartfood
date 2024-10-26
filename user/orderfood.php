<?php
session_start();
include 'userbase.html';
include '../connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Details</title>

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

        h2 {
            color: #27ae60;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }

        .search-bar {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
        }

        .search-bar input {
            width: 300px;
            padding: 10px;
            border: 1px solid #27ae60;
            border-radius: 5px 0 0 5px;
        }

        .search-bar button {
            padding: 10px;
            border: none;
            background-color: #27ae60;
            color: white;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
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

        th, td {
            padding: 15px;
            text-align: center;
        }

        th {
            background-color: #27ae60;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tr:hover {
            background-color: rgba(39, 174, 96, 0.2);
        }

        img {
            height: 100px;
            width: 100px;
            object-fit: cover;
            border-radius: 50%;
            transition: transform 0.3s ease;
        }

        img:hover {
            transform: scale(1.1);
        }

        @media (max-width: 768px) {
            .table-container {
                width: 95%;
            }

            .search-bar input {
                width: 200px;
            }
        }
    </style>
</head>

<body>
   
    <center>
        <h2>Restaurant Details</h2>
 <!-- Search Bar -->
    <div class="search-bar">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search for a restaurant..." 
                   value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button type="submit">Search</button>
        </form>
    </div>

        <div class="table-container">
            <table border="0">
                <?php
                $search = isset($_GET['search']) ? $_GET['search'] : '';

                $sql = "SELECT * FROM tblrestaurant 
                        WHERE rName LIKE '%$search%' 
                        OR rAddress LIKE '%$search%' 
                        OR rLicense LIKE '%$search%'";

                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                ?>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>License No</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Photo</th>
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <td><?php echo $row['rId']; ?></td>
                            <td><?php echo $row['rName']; ?></td>
                            <td><?php echo $row['rLicense']; ?></td>
                            <td><?php echo $row['rAddress']; ?></td>
                            <td><?php echo $row['rContact']; ?></td>
                            <td><?php echo $row['rEmail']; ?></td>
                            <td>
                                <a href="restaurantdetails.php?id=<?php echo $row['rId']; ?>">
                                    <img src="<?php echo $row['rImage']; ?>">
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    echo "<tr><td colspan='7'>No restaurants found matching your search.</td></tr>";
                }
                ?>
            </table>
        </div>
    </center>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
