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
$pending_orders_query = "
    SELECT tblorders.order_id, tblorders.delivery_address, tblorders.order_date, 
           tblorderitems.food_item, tblorderitems.quantity, tblorderitems.price 
    FROM tblorders 
    JOIN tblorderitems ON tblorders.order_id = tblorderitems.order_id 
    WHERE tblorders.rId = '$restaurant_id' AND tblorders.status = 'pending' 
    ORDER BY tblorders.order_id DESC";
$pending_orders_result = mysqli_query($conn, $pending_orders_query);

// Fetch delivered orders grouped by order_id
$delivered_orders_query = "
    SELECT tblorders.order_id, tblorders.delivery_address, tblorders.order_date, 
           tblorderitems.food_item, tblorderitems.quantity, tblorderitems.price 
    FROM tblorders 
    JOIN tblorderitems ON tblorders.order_id = tblorderitems.order_id 
    WHERE tblorders.rId = '$restaurant_id' AND tblorders.status = 'delivered' 
    ORDER BY tblorders.order_id DESC";
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
                <th>Delivery Address</th>
                <th>Order Date</th>
                <th>Food Items</th>
                <th>Total Price</th>
                <th>Action</th>
            </tr>

            <?php
            $current_order_id = null;
            $total_price = 0;
            $food_items_list = '';  // To store food items for the current order

            if (mysqli_num_rows($pending_orders_result) > 0) {
                while ($order = mysqli_fetch_assoc($pending_orders_result)) {
                    // If this is a new order, print its details
                    if ($order['order_id'] !== $current_order_id) {
                        // Close the previous order row, if applicable
                        if ($current_order_id !== null) {
                            echo "<td>$food_items_list</td>
                                  <td>$total_price</td>
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
                        $food_items_list = '';  // Reset the food items list
                        $total_price = 0;

                        echo "<tr>";
                        echo "<td>{$order['order_id']}</td>";
                        // We will append all food items here later
                        echo "<td>{$order['delivery_address']}</td>";
                        echo "<td>{$order['order_date']}</td>";
                    }

                    // Append food item to the food items list
                    $food_items_list .= "{$order['food_item']} ({$order['quantity']}), ";
                    
                    // Calculate the total price for this order
                    $total_price += $order['quantity'] * $order['price'];
                }

                // Close the final order row
                if ($current_order_id !== null) {
                    echo "<td>$food_items_list</td>
                          <td>$total_price</td>
                          <td>
                              <form method='POST'>
                                  <input type='hidden' name='order_id' value='{$current_order_id}'>
                                  <input type='submit' name='mark_as_delivered' value='Mark as Delivered'>
                              </form>
                          </td>
                          </tr>";
                }
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
                <th>Delivery Address</th>
                <th>Order Date</th>
                <th>Food Items</th>
                <th>Total Price</th>
                <th>Action</th>
            </tr>

            <?php
            $current_order_id = null;
            $total_price = 0;
            $food_items_list = '';  // To store food items for the current order

            if (mysqli_num_rows($delivered_orders_result) > 0) {
                while ($order = mysqli_fetch_assoc($delivered_orders_result)) {
                    // If this is a new order, print its details
                    if ($order['order_id'] !== $current_order_id) {
                        // Close the previous order row, if applicable
                        if ($current_order_id !== null) {
                            echo "<td>$food_items_list</td><td>$total_price</td><td>Delivered</td></tr>";
                        }

                        // Start a new order row
                        $current_order_id = $order['order_id'];
                        $food_items_list = '';  // Reset the food items list
                        $total_price = 0;

                        echo "<tr>";
                        echo "<td>{$order['order_id']}</td>";
                        // We will append all food items here later
                        echo "<td>{$order['delivery_address']}</td>";
                        echo "<td>{$order['order_date']}</td>";
                    }

                    // Append food item to the food items list
                    $food_items_list .= "{$order['food_item']} ({$order['quantity']}), ";
                    
                    // Calculate the total price for this order
                    $total_price += $order['quantity'] * $order['price'];
                }

                // Close the final order row
                if ($current_order_id !== null) {
                    echo "<td>$food_items_list</td><td>$total_price</td><td>Delivered</td></tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No delivered orders</td></tr>";
            }
            ?>
        </table>
    </div>
</center>
