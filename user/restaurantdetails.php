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

// Handle AJAX requests for cart operations
if (isset($_POST['action']) && $_POST['action'] == 'update_cart') {
    $food_id = $_POST['food_id'];
    $food_name = $_POST['food_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Update the cart
    $_SESSION['cart'][$food_id] = [
        'food_id' => $food_id,
        'food_name' => $food_name,
        'quantity' => $quantity,
        'price' => $price
    ];

    // If quantity is zero, remove the item from the cart
    if ($quantity == 0) {
        unset($_SESSION['cart'][$food_id]);
    }

    // Return updated cart HTML
    echo generateCartHTML();
    exit;
}

// Function to generate cart HTML
function generateCartHTML() {
    $total_price = 0;
    $cart_html = '
    <table border="0" id="cart">
        <tr>
            <th>Food Item</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
            <th>Action</th>
        </tr>';

    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $cart_item) {
            $item_total = $cart_item['quantity'] * $cart_item['price'];
            $total_price += $item_total;
            $cart_html .= '
            <tr>
                <td>' . htmlspecialchars($cart_item['food_name']) . '</td>
                <td>' . $cart_item['quantity'] . '</td>
                <td>' . $cart_item['price'] . '</td>
                <td>' . $item_total . '</td>
                <td>
                    <button class="remove-item" data-food-id="' . $cart_item['food_id'] . '">Remove</button>
                </td>
            </tr>';
        }
        $cart_html .= '
        <tr>
            <td colspan="3"><strong>Total Price</strong></td>
            <td><strong>' . $total_price . '</strong></td>
            <td></td>
        </tr>';
    } else {
        $cart_html .= '<tr><td colspan="5">Your cart is empty.</td></tr>';
    }

    $cart_html .= '</table>';

    return $cart_html;
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
    .quantity-controls {
        display: flex;
        align-items: center;
    }
    .quantity-controls button {
        padding: 5px 10px;
        margin: 0 5px;
    }
</style>

<center>
    <div style="margin: 50px;">
        <hr>
        <h2 style="margin: 10px;">Restaurant Details</h2>
        <hr>

        <?php
        // Query to fetch restaurant details based on the provided 'id'
        $sql = "SELECT * FROM tblrestaurant WHERE rId=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $restaurant_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
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
                <th>Report</th>
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo htmlspecialchars($row['rId']); ?></td>
                <td><?php echo htmlspecialchars($row['rName']); ?></td>
                <td><?php echo htmlspecialchars($row['rLicense']); ?></td>
                <td><?php echo htmlspecialchars($row['rAddress']); ?></td>
                <td><?php echo htmlspecialchars($row['rContact']); ?></td>
                <td><?php echo htmlspecialchars($row['rEmail']); ?></td>
                <td><img src="<?php echo htmlspecialchars($row['rImage']); ?>" style="height:150px; width:150px; border-radius:50%;"></td>
                <td><a href="viewinspectiondetails.php?id=<?php echo $row['rId'];?>" style="color:black;">Inspection Details</a></td>
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
            </tr>

            <?php
            // Query to fetch available food items for the restaurant
            $food_query = "SELECT * FROM tblfooditems WHERE rId=?";
            $stmt = $conn->prepare($food_query);
            $stmt->bind_param("i", $restaurant_id);
            $stmt->execute();
            $food_result = $stmt->get_result();
            
            if ($food_result->num_rows > 0) {
                while ($food = $food_result->fetch_assoc()) {
                    $food_id = $food['food_id'];
                    $quantity_in_cart = isset($_SESSION['cart'][$food_id]) ? $_SESSION['cart'][$food_id]['quantity'] : 0;
            ?>
            <tr>
                <td><?php echo htmlspecialchars($food['food_name']); ?></td>
                <td><?php echo htmlspecialchars($food['description']); ?></td>
                <td><?php echo htmlspecialchars($food['price']); ?></td>
                <td><img src="<?php echo htmlspecialchars($food['food_image']); ?>" style="height:100px; width:100px; border-radius:10%;"></td>
                <td>
                    <div class="quantity-controls">
                        <button class="decrease-quantity" data-food-id="<?php echo $food_id; ?>" data-food-name="<?php echo htmlspecialchars($food['food_name']); ?>" data-price="<?php echo $food['price']; ?>">−</button>
                        <span id="quantity-<?php echo $food_id; ?>"><?php echo $quantity_in_cart; ?></span>
                        <button class="increase-quantity" data-food-id="<?php echo $food_id; ?>" data-food-name="<?php echo htmlspecialchars($food['food_name']); ?>" data-price="<?php echo $food['price']; ?>">＋</button>
                    </div>
                </td>
            </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='5'>No food items available.</td></tr>";
            }
            ?>
        </table>
    </div>

    <!-- Show Cart Section -->
    <div style="margin: 50px;">
        <h2>Your Cart</h2>
        <div id="cart-container">
            <?php echo generateCartHTML(); ?>
        </div>

        <!-- Checkout form for address -->
    
        <h3>Delivery Details</h3>
        <form method="POST">
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
        </form>
        
    </div>

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

        // Generate a unique order ID
        $order_id = uniqid();

        // Save the order details temporarily in the session
        $_SESSION['order_id'] = $order_id;
        $_SESSION['delivery_address'] = $delivery_address;
        $_SESSION['restaurant_id'] = $restaurant_id;

        // Redirect to the mock payment page
        echo '<script>window.location.href="payment/mock_payment.php";</script>';
        exit;
    

        // Clear the cart after order is placed
        unset($_SESSION['cart']);
        echo '<script>alert("Order placed successfully!"); window.location.href = window.location.href;</script>';
    }
    ?>
</center>

<!-- JavaScript for handling quantity changes -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $('.increase-quantity, .decrease-quantity').click(function(){
        var button = $(this);
        var food_id = button.data('food-id');
        var food_name = button.data('food-name');
        var price = button.data('price');
        var quantity_span = $('#quantity-' + food_id);
        var current_quantity = parseInt(quantity_span.text());

        if (button.hasClass('increase-quantity')) {
            current_quantity += 1;
        } else {
            if (current_quantity > 0) {
                current_quantity -= 1;
            }
        }

        // Update the quantity display
        quantity_span.text(current_quantity);

        // Update the cart via AJAX
        $.ajax({
            type: 'POST',
            url: '',  // Current page
            data: {
                action: 'update_cart',
                food_id: food_id,
                food_name: food_name,
                price: price,
                quantity: current_quantity
            },
            success: function(response) {
                // Update the cart HTML
                $('#cart-container').html(response);
                location.reload();
            }
        });
    });

    // Remove item from cart
    $(document).on('click', '.remove-item', function(){
        var button = $(this);
        var food_id = button.data('food-id');

        // Set quantity to zero to remove the item
        $.ajax({
            type: 'POST',
            url: '',  // Current page
            data: {
                action: 'update_cart',
                food_id: food_id,
                quantity: 0
            },
            success: function(response) {
                // Update the cart HTML and quantity display
                $('#cart-container').html(response);
                $('#quantity-' + food_id).text('0');
                location.reload();
            }
        });
    });
});
</script>
