<?php
session_start();

// Include necessary files
include 'userbase.html';  // Ensure correct path to userbase.html
include '../connection.php';  // Ensure correct path to the database connection

// Check if the user is logged in by checking if 'email' exists in the session

    // For public access, use a hardcoded email or display default public content
$email = 'public@domain.com';  // Ensure this email exists in the database


// Query to fetch public user data or restaurant details
$query = "SELECT * FROM tblpublic WHERE pEmail = '$email'";
$result = mysqli_query($conn, $query);

// Check for query result
if (!$result) {
    die("Query Failed: " . mysqli_error($conn));  // Error handling if the query fails
}

?>

<!-- CSS styling for table and container -->
<style>
    th, td {
        padding: 10px;
    }
    .mainCon {
        width: 90%;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
    }
    .content {
        margin: 10px;
        padding: 20px;
        max-width: 20rem;
        box-shadow: 5px 5px 5px 5px;
    }
    .row {
        display: flex;
        padding: 10px;
        justify-content: center;
        align-items: center;
        border-radius: 25px;
    }
    img {
        height: 150px;
        width: 150px;
    }
</style>

<!-- Background image and page content -->
<body style="background-image: url('../images/back.jpg'); background-size: cover; background-repeat: no-repeat;">
    <center>
        <div style="margin: 50px;">
            <hr>
            <!-- Display different headers based on whether the user is logged in or not -->
            <?php
            if (isset($_SESSION['name'])) {
                echo "<h2 style='margin: 10px;'>Welcome,  User!</h2>";
            } else {
                echo "<h2 style='margin: 10px;'>Welcome, Public User!</h2>";
            }
            ?>
            <hr>
        </div>

        <!-- Main container for displaying content -->
        <div class="container-fluid mainCon">
            <?php
            // Check if the query returned any results
            if ($result && mysqli_num_rows($result) > 0) {
                // Fetch each row and display the data
                while ($q = mysqli_fetch_array($result)) {
                    ?>
                    <!-- Display public user or content information here -->
                    <div class='content card'>
                      
                        <h2><?php echo $q['pName']; ?></h2>
                        <p>Email: <?php echo $q['pEmail']; ?></p>
                        <p>Address: <?php echo $q['pAddress']; ?></p>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No data available for this user.</p>";
            }
            ?>
        </div>
    </center>
</body>
