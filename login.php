<?php
session_start();
include 'commonbase.html';
include 'connection.php';
?>
<style>
    /* Styling for the entire page */
    body {
        background-image: url('images/bg1.jpg');
        background-size: cover;
        background-attachment: fixed;
        background-repeat: no-repeat;
        font-family: 'Poppins', sans-serif;
        color: #333; /* Default font color */
    }

    /* Center the card with transparent effect */
    .login-card {
        width: 400px;
        margin: 100px auto;
        background: rgba(255, 255, 255, 0.3); /* Transparent white background */
        border-radius: 15px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        padding: 30px;
        backdrop-filter: blur(5px); /* Blur effect for transparency */
    }

    h2 {
    font-family: 'Roboto Slab', serif; /* Modern serif font */
    text-align: center;
    color: #1f3a93; /* Dark blue color */
    margin-bottom: 20px;
}


    label {
        font-weight: bold;
        color: #2980b9; /* Blue label color */
    }

    input[type="email"],
    input[type="password"] {
        margin-bottom: 15px;
        border-radius: 10px;
        border: 1px solid #bdc3c7;
        padding: 10px;
        width: 100%;
        background-color: rgba(255, 255, 255, 0.8); /* Slightly transparent input fields */
        color: #2c3e50;
    }

    /* Button Styling */
    .btn-custom {
        background: linear-gradient(45deg, #3498db, #8e44ad); /* Blue to purple gradient */
        color: white;
        width: 100%;
        border: none;
        padding: 12px;
        font-size: 1rem;
        border-radius: 10px;
        transition: background 0.3s ease;
    }

    .btn-custom:hover {
        background: linear-gradient(45deg, #8e44ad, #3498db); /* Inverted gradient on hover */
    }

    .login-card form {
        margin-top: 20px;
    }

    /* Alert Message Styling */
    .alert {
        text-align: center;
        margin-top: 10px;
        color: #e74c3c;
        font-weight: bold;
    }
</style>

<body>
    <div class="login-card">
        <h2>Login</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="email">Username</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="pwd">Password</label>
                <input type="password" id="pwd" name="pwd" class="form-control" required>
            </div>
            <button type="submit" name="submit" class="btn btn-custom">Login</button>
        </form>
    </div>

    <?php
    if (isset($_POST['submit'])) {
        $email = $_POST['email'];
        $pwd = $_POST['pwd'];

        $qry = "SELECT count(*) FROM tbllogin WHERE lcase(username)='$email'";
        $res = mysqli_query($conn, $qry);
        $row = mysqli_fetch_array($res);

        if ($row[0] > 0) {
            $qry = "SELECT * FROM tbllogin WHERE lcase(username)='$email'";
            $res = mysqli_query($conn, $qry);
            $row = mysqli_fetch_array($res);

            if ($row['password'] == $pwd) {
                $_SESSION['email'] = $email;

                if ($row['status'] == '1') {
                    if ($row['usertype'] == 'admin') {
                        echo '<script>location.href="admin/adminhome.php"</script>';
                    } elseif ($row['usertype'] == 'restaurant') {
                        $qry = "SELECT * FROM tblrestaurant WHERE rEmail='$email'";
                        $res = mysqli_query($conn, $qry);
                        $row = mysqli_fetch_array($res);
                        $_SESSION['id'] = $row['rId'];
                        $_SESSION['name'] = $row['rName'];
                        echo '<script>location.href="restaurant/restauranthome.php"</script>';
                    } elseif ($row['usertype'] == 'inspector') {
                        $qry = "SELECT * FROM tblinspector WHERE iEmail='$email'";
                        $res = mysqli_query($conn, $qry);
                        $row = mysqli_fetch_array($res);
                        $_SESSION['id'] = $row['iId'];
                        $_SESSION['name'] = $row['iName'];
                        echo '<script>location.href="inspector/inspectorhome.php"</script>';
                    } elseif ($row['usertype'] == 'public') {
                        $qry = "SELECT * FROM tblpublic WHERE pEmail='$email'";
                        $res = mysqli_query($conn, $qry);
                        $row = mysqli_fetch_array($res);
                        $_SESSION['id'] = $row['pId'];
                        $_SESSION['name'] = $row['pName'];
                        echo '<script>location.href="user/userhome.php"</script>';
                    }
                } elseif ($row['status'] == '-1') {
                    echo '<div class="alert">Rejected</div>';
                } else {
                    echo '<div class="alert">Not Approved</div>';
                }
            } else {
                echo '<div class="alert">Incorrect Password</div>';
            }
        } else {
            echo '<div class="alert">User Doesn\'t Exist</div>';
        }
    }
    ?>
</body>
