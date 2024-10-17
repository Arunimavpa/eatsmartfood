<?php
session_start();
include 'userbase.html';  // Ensure correct path
include '../connection.php';  // Ensure correct path

// Initialize cart session if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if 'id' is set in the URL query string
if (isset($_REQUEST['id'])) {
    $restaurant_id = $_REQUEST['id'];  // Get the restaurant ID from the query string
} else {
    echo '<script>alert("No restaurant ID provided!"); location.href="publicrestaurant.php";</script>';
    exit;
}

// Add items to cart
if (isset($_POST['add_to_cart'])) {
    $food_id = $_POST['food_id'];
    $food_name = $_POST['food_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    // Store item in cart session
    $_SESSION['cart'][] = [
        'food_id' => $food_id,
        'food_name' => $food_name,
        'quantity' => $quantity,
        'price' => $price
    ];

    echo '<script>alert("Item added to cart!");</script>';
}
?>

<!-- CSS styling for table and container -->
<style>
    th, td {
        padding: 10px;
    }
    th {
        background-color: brown;
        color: white;
    }
    table {
        width: 1050px;
    }
</style>

<center>
    <div style="margin: 50px;">
        <hr>
        <h2 style="margin: 10px;">Restaurant Details</h2>
        <hr>

        <?php
        // Query to fetch restaurant details based on the provided 'id'
        $sql = "SELECT * FROM tblrestaurant WHERE rId='$restaurant_id'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
        ?>
        <table border="0" id="tb">
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>LICENSE NO</th>
                <th>ADDRESS</th>
                <th>PHONE</th>
                <th>EMAIL</th>
                <th>PHOTO</th>
                <th>report</th>
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
                <td><img src="<?php echo $row['rImage']; ?>" style="height:150px; width:150px; border-radius:50%;"></td>
                <td><a href="viewinspectiondetails.php?id=<?php echo $row[0];?>" style="color:black;">Inspection Details</a></td>
            </tr>
            <?php
            }
        }
        ?>
        </table>

        <hr>
        <h2 style="margin: 10px;">Available Food Items</h2>
        <table border="0" id="tb">
            <tr>
                <th>Food Item</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Quantity</th>
                <th>Add to Cart</th>
            </tr>

            <?php
            // Query to fetch available food items for the restaurant
            $food_query = "SELECT * FROM tblfooditems WHERE rId='$restaurant_id'";
            $food_result = mysqli_query($conn, $food_query);
            
            if (mysqli_num_rows($food_result) > 0) {
                while ($food = mysqli_fetch_array($food_result)) {
            ?>
            <tr>
                <td><?php echo $food['food_name']; ?></td>
                <td><?php echo $food['description']; ?></td>
                <td><?php echo $food['price']; ?></td>
                <td><img src="<?php echo $food['food_image']; ?>" style="height:100px; width:100px; border-radius:10%;"></td>
                <td>
                    <form method="POST"> <!-- Separate form for each item -->
                        <input type="number" name="quantity" value="1" min="1" required>
                        <!-- Hidden inputs to send food details -->
                        <input type="hidden" name="food_id" value="<?php echo $food['food_id']; ?>">
                        <input type="hidden" name="food_name" value="<?php echo $food['food_name']; ?>">
                        <input type="hidden" name="price" value="<?php echo $food['price']; ?>">
                        <input type="submit" name="add_to_cart" value="Add to Cart">
                    </form>
                </td>
            </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='6'>No food items available.</td></tr>";
            }
            ?>
        </table>
    </div>

    <!-- Show Cart Section -->
    <div style="margin: 50px;">
        <h2>Your Cart</h2>
        <form method="POST">
            <table border="0" id="cart">
                <tr>
                    <th>Food Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
                <?php
                $total_price = 0;
                if (!empty($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $cart_item) {
                        $item_total = $cart_item['quantity'] * $cart_item['price'];
                        $total_price += $item_total;
                ?>
                <tr>
                    <td><?php echo $cart_item['food_name']; ?></td>
                    <td><?php echo $cart_item['quantity']; ?></td>
                    <td><?php echo $cart_item['price']; ?></td>
                    <td><?php echo $item_total; ?></td>
                </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='4'>Your cart is empty.</td></tr>";
                }
                ?>
                <tr>
                    <td colspan="3"><strong>Total Price</strong></td>
                    <td><strong><?php echo $total_price; ?></strong></td>
                </tr>
            </table>

            <!-- Checkout form for address -->
            <?php if (!empty($_SESSION['cart'])) { ?>
            <h3>Delivery Details</h3>
            <table>
                <tr>
                    <td>Name</td>
                    <td><input type="text" name="name" required></td>
                </tr>
                <tr>
                    <td>Phone Number</td>
                    <td><input type="text" name="phone_number" pattern="[0-9]{10}" required></td>
                </tr>
                <tr>
                    <td>Street Name</td>
                    <td><input type="text" name="street_name" required></td>
                </tr>
                <tr>
                    <td>City</td>
                    <td><input type="text" name="city" required></td>
                </tr>
                <tr>
                    <td>State</td>
                    <td><input type="text" name="state" required></td>
                </tr>
                <tr>
                    <td>Pincode</td>
                    <td><input type="text" name="pincode" pattern="[0-9]{6}" required></td>
                </tr>
            </table>
            <br>
            <input type="submit" name="place_order" value="Place Order">
            <?php } ?>
        </form>

        <?php
        // Place order functionality
        if (isset($_POST['place_order'])) {
            // Gather the delivery details
            $name = $_POST['name'];
            $phone_number = $_POST['phone_number'];
            $street_name = $_POST['street_name'];
            $city = $_POST['city'];
            $state = $_POST['state'];
            $pincode = $_POST['pincode'];

            // Combine the address into a single string
            $delivery_address = "$name Phone: $phone_number, $street_name, $city, $state, $pincode";

            foreach ($_SESSION['cart'] as $cart_item) {
                $food_name = $cart_item['food_name'];
                $quantity = $cart_item['quantity'];
                $price = $cart_item['price'];

                // Save each item in the order to the tblorders table
                $order_query = "INSERT INTO tblorders (rId, food_item, quantity, price, delivery_address) 
                                VALUES ('$restaurant_id', '$food_name', '$quantity', '$price', '$delivery_address')";
                $order_result = mysqli_query($conn, $order_query);
            }

            // Clear the cart after order is placed
            unset($_SESSION['cart']);
            echo '<script>alert("Order placed successfully!");</script>';
        }
        ?>
    </div>
</center>

