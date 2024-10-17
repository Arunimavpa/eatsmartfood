<?php
session_start();
include 'restaurantbase.html';  // Correct path
include '../connection.php';    // Correct path

$restaurant_id = $_SESSION['id'];  // Assuming restaurant ID is stored in session

// Mark order as delivered if the button is pressed
if (isset($_POST['mark_as_delivered'])) {
    $order_id = $_POST['order_id'];
    $update_status_query = "UPDATE tblorders SET status='delivered' WHERE order_id='$order_id'";
    mysqli_query($conn, $update_status_query);
    // Refresh the page after marking as delivered
    echo "<script>window.location.href = window.location.href;</script>";
}

// Fetch pending orders grouped by order_id
$pending_orders_query = "SELECT * FROM tblorders WHERE rId='$restaurant_id' AND status='pending' ORDER BY order_id DESC";
$pending_orders_result = mysqli_query($conn, $pending_orders_query);

// Fetch delivered orders grouped by order_id
$delivered_orders_query = "SELECT * FROM tblorders WHERE rId='$restaurant_id' AND status='delivered' ORDER BY order_id DESC";
$delivered_orders_result = mysqli_query($conn, $delivered_orders_query);
?>

<!-- CSS Styling -->
<style>
    th, td {
        padding: 10px;
    }
    th {
        background-color: brown;
        color: white;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    table, th, td {
        border: 1px solid black;
    }
</style>

<center>
    <!-- Pending Orders Section -->
    <div style="margin: 50px;">
        <hr>
        <h2>Pending Orders</h2>
        <hr>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Food Items</th>
                <th>Quantity</th>
                <th>Delivery Address</th>
                <th>Order Date</th>
                <th>Total Price</th>
                <th>Action</th>
            </tr>

            <?php
            $current_order_id = null;
            $total_price = 0;

            while ($order = mysqli_fetch_assoc($pending_orders_result)) {
                if ($order['order_id'] !== $current_order_id) {
                    // Close previous order row if applicable
                    if ($current_order_id !== null) {
                        echo "<td>$total_price</td>
                              <td>
                                  <form method='POST'>
                                      <input type='hidden' name='order_id' value='{$current_order_id}'>
                                      <input type='submit' name='mark_as_delivered' value='Mark as Delivered'>
                                  </form>
                              </td>
                              </tr>";
                    }

                    // Start a new order row
                    $current_order_id = $order['order_id'];
                    $food_items = $order['food_item'];
                    $total_price = $order['price'] * $order['quantity'];

                    echo "<tr>";
                    echo "<td>{$current_order_id}</td>";
                    echo "<td>{$food_items}</td>";
                } else {
                    // Append food items for the same order
                    $food_items .= "<br>{$order['food_item']}";
                }

                // Display quantity and other details
                echo "<td>{$order['quantity']}</td>";
                echo "<td>{$order['delivery_address']}</td>";
                echo "<td>{$order['order_date']}</td>";
            }

            // Close the final order row
            if ($current_order_id !== null) {
                echo "<td>$total_price</td>
                      <td>
                          <form method='POST'>
                              <input type='hidden' name='order_id' value='{$current_order_id}'>
                              <input type='submit' name='mark_as_delivered' value='Mark as Delivered'>
                          </form>
                      </td>
                      </tr>";
            } else {
                echo "<tr><td colspan='7'>No pending orders</td></tr>";
            }
            ?>
        </table>
    </div>

    <!-- Delivered Orders Section -->
    <div style="margin: 50px;">
        <hr>
        <h2>Delivered Orders</h2>
        <hr>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Food Items</th>
                <th>Quantity</th>
                <th>Delivery Address</th>
                <th>Order Date</th>
                <th>Total Price</th>
                <th>Status</th>
            </tr>

            <?php
            $current_order_id = null;
            $total_price = 0;

            while ($order = mysqli_fetch_assoc($delivered_orders_result)) {
                if ($order['order_id'] !== $current_order_id) {
                    // Close previous order row if applicable
                    if ($current_order_id !== null) {
                        echo "<td>$total_price</td><td>Delivered</td></tr>";
                    }

                    // Start a new order row
                    $current_order_id = $order['order_id'];
                    $food_items = $order['food_item'];
                    $total_price = $order['price'] * $order['quantity'];

                    echo "<tr>";
                    echo "<td>{$current_order_id}</td>";
                    echo "<td>{$food_items}</td>";
                } else {
                    // Append food items for the same order
                    $food_items .= "<br>{$order['food_item']}";
                }

                // Display quantity and other details
                echo "<td>{$order['quantity']}</td>";
                echo "<td>{$order['delivery_address']}</td>";
                echo "<td>{$order['order_date']}</td>";
            }

            // Close the final order row
            if ($current_order_id !== null) {
                echo "<td>$total_price</td><td>Delivered</td></tr>";
            } else {
                echo "<tr><td colspan='7'>No delivered orders</td></tr>";
            }
            ?>
        </table>
    </div>
</center>
