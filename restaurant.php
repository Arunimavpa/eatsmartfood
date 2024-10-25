<?php
session_start();
include 'commonbase.html';
include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Registration</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        /* Global Styles */
        body {
            background-image: url('images/food1.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        h2 {
            color: #27ae60; /* Green Header */
            font-weight: bold;
            text-align: center;
            margin-bottom: 15px;
        }

        /* Card Container */
        .form-card {
            width: 40%;
            margin: 80px auto;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        /* Form Row Styling */
        .form-group label {
            color: #27ae60; /* Green Label Color */
            font-weight: 600;
        }

        .btn-register {
            background: linear-gradient(45deg, #27ae60, #3498db); /* Green to Blue Gradient */
            color: white;
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s;
        }

        .btn-register:hover {
            background: linear-gradient(45deg, #3498db, #27ae60);
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .form-card {
                width: 80%;
            }
        }
    </style>
</head>

<body>
    <center>
        <div class="form-card">
            <h2>Restaurant Registration</h2>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label">Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="name" name="name" pattern="[a-zA-Z ]+" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="license" class="col-sm-3 col-form-label">ID</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="license" name="license" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="address" class="col-sm-3 col-form-label">Address</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="address" name="address" required></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="contact" class="col-sm-3 col-form-label">Contact</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="contact" name="contact" pattern="[6789][0-9]{9}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-sm-3 col-form-label">Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="file" class="col-sm-3 col-form-label">Upload Image</label>
                    <div class="col-sm-9">
                        <input type="file" class="form-control" id="file" name="file" required>
                    </div>
                </div>

                <button type="submit" name="submit" class="btn-register">Register</button>
            </form>
        </div>
    </center>

    <?php
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $address = $_POST['address'];
        $contact = $_POST['contact'];
        $email = $_POST['email'];
        $license = $_POST['license'];
        $password = $_POST['password'];

        $folder = 'images/';
        $file = $folder . basename($_FILES['file']['name']);
        move_uploaded_file($_FILES['file']['tmp_name'], $file);

        $qry = "SELECT COUNT(*) FROM tbllogin WHERE lcase(username)='$email'";
        $res = mysqli_query($conn, $qry);
        $row = mysqli_fetch_array($res);

        if ($row[0] > 0) {
            echo '<script>alert("Email already exists");</script>';
        } else {
            $qry = "INSERT INTO tblrestaurant (rName, rAddress, rEmail, rContact, rLicense, rImage) 
                    VALUES ('$name', '$address', '$email', '$contact', '$license', '$file')";
            $res = mysqli_query($conn, $qry);

            if ($res) {
                $qry = "INSERT INTO tbllogin (username, password, usertype, status) 
                        VALUES ('$email', '$password', 'restaurant', '0')";
                $res = mysqli_query($conn, $qry);

                if ($res) {
                    echo '<script>alert("Registered successfully"); location.href="login.php";</script>';
                } else {
                    echo '<script>alert("Error during login creation.");</script>';
                }
            } else {
                echo '<script>alert("Error during restaurant registration.");</script>';
            }
        }
    }
    ?>
</body>
</html>
