<?php
session_start();
include 'fibase.html';
include '../connection.php';
$id = $_REQUEST['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Extra Penalty</title>

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

        .form-container {
            margin-top: 50px;
            margin-bottom: 50px;
            width: 50%;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 30px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            margin-bottom: 15px;
        }

        .btn-submit {
            background-color: #d9534f; /* Bootstrap Danger */
            border: none;
            width: 100%;
            font-weight: bold;
            padding: 10px;
            border-radius: 5px;
            color: white;
        }

        .btn-submit:hover {
            background-color: #c9302c; /* Darker Red */
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="form-container">
            <h2 class="text-center">Extra Penalty</h2>
            <hr>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="penalty">Penalty Fine</label>
                    <input type="number" class="form-control" id="penalty" name="penalty" required>
                </div>

                <div class="form-group">
                    <label for="date">Due Date</label>
                    <input type="date" class="form-control" id="date" name="date" 
                           min="<?php echo date('Y-m-d'); ?>" required>
                </div>

                <button type="submit" name="submit" class="btn-submit">Submit</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
if (isset($_POST['submit'])) {
    $penalty = $_POST['penalty'];
    $date = $_POST['date'];

    $qry = "UPDATE tblpenalty SET duedate = '$date', amt = '$penalty' WHERE repId = '$id'";
    $res = mysqli_query($conn, $qry);

    if ($res) {
        echo '<script>alert("Penalty updated successfully"); location.href="inspected.php";</script>';
    } else {
        echo '<script>alert("Sorry, an error occurred.");</script>';
    }
}
?>
