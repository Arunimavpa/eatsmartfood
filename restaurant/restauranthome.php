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
        // Insert the new food item into tblfooditems
        $sql = "INSERT INTO tblfooditems (rId, food_name, description, price, food_image) VALUES ('$restaurant_id', '$food_name', '$description', '$price', '$target_file')";
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

<style>
    th,
    td {
        padding: 10px;
    }
</style>

<center>
    <div style="margin: 50px;">
        <hr>
        <h2 style="margin: 10px;">Welcome <?php echo $_SESSION['name']; ?></h2>
        <hr>

        <!-- Form to add food details along with the food image -->
        <h2>Add Food to Menu</h2>
        <form method="POST" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Food Name</td>
                    <td><input type="text" name="food_name" required></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea name="description" required></textarea></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type="number" name="price" step="0.01" required></td>
                </tr>
                <tr>
                    <td>Food Image</td>
                    <td><input type="file" name="food_image" accept="image/*" required></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="add_food" value="Add Food"></td>
                </tr>
            </table>
        </form>
    </div>

    <!-- Display current food items -->
    <div style="margin: 50px;">
        <h2>Your Menu</h2>
        <table border="1">
            <tr>
                <th>Food Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Food Image</th>
            </tr>
            <?php
            // Query to display the restaurant's menu items
            $menu_query = "SELECT * FROM tblfooditems WHERE rId='$restaurant_id'";
            $menu_result = mysqli_query($conn, $menu_query);

            if (mysqli_num_rows($menu_result) > 0) {
                while ($row = mysqli_fetch_array($menu_result)) {
            ?>
            <tr>
                <td><?php echo $row['food_name']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><img src="<?php echo $row['food_image']; ?>" style="height:100px; width:100px;"></td>
            </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='4'>No food items in the menu yet.</td></tr>";
            }
            ?>
        </table>
    </div>
</center>
