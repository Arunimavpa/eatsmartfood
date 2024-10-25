<?php
session_start();
include 'restaurantbase.html';  // Ensure the correct path
include '../connection.php';  // Ensure the correct path

// Get the restaurant ID from the session
$restaurant_id = $_SESSION['id'];  // Assuming 'id' stores the restaurant's ID

// Handle form submission
if (isset($_POST['add_food'])) {
    $food_name = $_POST['food_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['food_image']['name'];
    $image_temp = $_FILES['food_image']['tmp_name'];

    // Define where the images will be uploaded
    $target_dir = "../uploads/food/";
    $target_file = $target_dir . basename($image);

    // Move the uploaded file to the target directory
    if (move_uploaded_file($image_temp, $target_file)) {
        $sql = "INSERT INTO tblfooditems (rId, food_name, description, price, food_image) 
                VALUES ('$restaurant_id', '$food_name', '$description', '$price', '$target_file')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo '<script>alert("Food item added successfully!");</script>';
        } else {
            echo '<script>alert("Error adding food item.");</script>';
        }
    } else {
        echo '<script>alert("Error uploading image.");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Menu</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
    /* Global Styles */
    body {
        background-color: #eafaf1; /* Light Green Background */
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
    }

    h2 {
        color: #27ae60; /* Green Heading */
        font-weight: bold;
        text-align: center;
        margin-bottom: 15px;
    }

    /* Wider and Shorter Card Layout */
    .form-card {
        width: 60%; /* Increased Width */
        background: white;
        border-radius: 15px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        margin: 30px auto; /* Reduced margin */
        padding: 20px; /* Compact padding */
    }

    .form-group {
        margin-bottom: 10px; /* Reduced spacing between fields */
    }

    .btn-register {
        background: linear-gradient(45deg, #27ae60, #2ecc71); /* Green Gradient */
        color: white;
        width: 100%;
        padding: 10px; /* Reduced padding */
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.3s ease, transform 0.2s;
    }

    .btn-register:hover {
        background: linear-gradient(45deg, #2ecc71, #27ae60);
        transform: scale(1.05);
    }

    .card-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        margin-top: 20px;
    }

    .menu-card {
        width: 300px;
        background: white;
        border-radius: 10px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        padding: 15px; /* Compact padding */
        text-align: center;
    }

    .menu-card h5 {
        color: #27ae60; /* Green Color */
        font-weight: bold;
    }

    img {
        width: 80%; /* Consistent image width */
        height: 80px; /* Reduced height */
        object-fit: cover; /* Maintain aspect ratio, crop if needed */
        border-radius: 10px;
        margin-bottom: 10px;
    }

    @media (max-width: 768px) {
        .form-card {
            width: 80%; /* Adjusted width for smaller screens */
        }
    }
</style>

<div class="container">
    <div class="form-card">
        <h2>Add Food to Menu</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="food_name">Food Name</label>
                <input type="text" class="form-control" id="food_name" name="food_name" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="2" required></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="food_image">Food Image</label>
                <input type="file" class="form-control-file" id="food_image" name="food_image" accept="image/*" required>
            </div>
            <button type="submit" name="add_food" class="btn-register">Add Food</button>
        </form>
    </div>

    <h2>Your Menu</h2>
    <div class="card-container">
        <?php
        // Query to display the restaurant's menu items
        $menu_query = "SELECT * FROM tblfooditems WHERE rId='$restaurant_id'";
        $menu_result = mysqli_query($conn, $menu_query);

        if (mysqli_num_rows($menu_result) > 0) {
            while ($row = mysqli_fetch_array($menu_result)) {
                echo '<div class="menu-card">
                        <h5><b>' . $row['food_name'] . '</b></h5>
                        <p>' . $row['description'] . '</p>
                        <p><strong>Price: </strong>$' . $row['price'] . '</p>
                        <img src="' . $row['food_image'] . '">
                      </div>';
            }
        } else {
            echo '<p>No food items in the menu yet.</p>';
        }
        ?>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>


    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
