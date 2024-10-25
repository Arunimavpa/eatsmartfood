<?php
session_start();
include 'restaurantbase.html';
include '../connection.php';
$id = $_GET['email'];  // Feedback ID from URL
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reply</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #eafaf1; /* Light Green Background */
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        h2 {
            color: #27ae60; /* Green Color */
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .table-container {
            width: 50%;
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
            text-align: left;
            color: #34495e;
        }

        .btn-danger {
            background: linear-gradient(45deg, #27ae60, #2ecc71);
            color: white;
            width: 100%;
            border: none;
            padding: 12px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s;
        }

        .btn-danger:hover {
            background: linear-gradient(45deg, #2ecc71, #27ae60);
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .table-container {
                width: 90%;
            }
        }
    </style>
</head>

<body>
    <div class="table-container">
        <h2>Reply</h2>
        <form method="POST" enctype="multipart/form-data">
            <table>
                <tr>
                    <td style="width: 30%;"><strong>Add Reply</strong></td>
                    <td><textarea class="form-control" name="reply" rows="4" required></textarea></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" class="btn btn-danger" value="Submit">
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <?php
    if (isset($_POST['submit'])) {
        $reply = $_POST['reply'];

        $qry = "INSERT INTO tblreply (fId, reply) VALUES ('$id', '$reply')";
        $res = mysqli_query($conn, $qry);

        if ($res) {
            $update_qry = "UPDATE tblfeedback SET status = 'Replied' WHERE fId = '$id'";
            mysqli_query($conn, $update_qry);
            echo '<script>alert("Reply added successfully"); location.href="userfeedback.php";</script>';
        } else {
            echo '<script>alert("Sorry, an error occurred.");</script>';
        }
    }
    ?>
</body>
</html>
