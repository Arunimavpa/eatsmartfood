<?php
session_start();
include 'restaurantbase.html';
include '../connection.php';
$id = $_SESSION['id'];

// Mark order as delivered
if (isset($_POST['mark_as_delivered'])) {
    $order_id = $_POST['order_id'];
    $update_status_query = "UPDATE tblorders SET status='delivered' WHERE order_id='$order_id'";
    mysqli_query($conn, $update_status_query);
    echo "<script>window.location.href = window.location.href;</script>";
}

// Fetch orders
$pending_orders_query = "
    SELECT tblorders.order_id, tblorders.delivery_address, tblorders.order_date, 
           tblorderitems.food_item, tblorderitems.quantity, tblorderitems.price ,tblorders.payment_status 
    FROM tblorders 
    JOIN tblorderitems ON tblorders.order_id = tblorderitems.order_id 
    WHERE tblorders.rId = '$id' AND tblorders.status = 'pending' 
    ORDER BY tblorders.order_id DESC";
$pending_orders_result = mysqli_query($conn, $pending_orders_query);

$delivered_orders_query = "
    SELECT tblorders.order_id, tblorders.delivery_address, tblorders.order_date, 
           tblorderitems.food_item, tblorderitems.quantity, tblorderitems.price ,tblorders.payment_status 
    FROM tblorders 
    JOIN tblorderitems ON tblorders.order_id = tblorderitems.order_id 
    WHERE tblorders.rId = '$id' AND tblorders.status = 'delivered' 
    ORDER BY tblorders.order_id DESC";
$delivered_orders_result = mysqli_query($conn, $delivered_orders_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        /* Global Styles */
        body {
            background-color: #eafaf1;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        h2 {
            color: #27ae60;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        .table-container {
            width: 100%;
            margin: 50px auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            background-color: #27ae60;
            color: white;
            text-align: center;
            padding: 15px;
        }

        td {
            padding: 15px;
            text-align: center;
            font-family: 'Poppins', sans-serif;
            color: #34495e;
        }

        tr:nth-child(even) {
            background-color: #f5f5f5;
        }

        tr:nth-child(odd) {
            background-color: #e8f6f3;
        }

        tr:hover {
            background-color: rgba(39, 174, 96, 0.2);
            transition: background 0.3s ease;
        }

        .btn-delivered {
            background: linear-gradient(45deg, #27ae60, #2ecc71);
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s;
        }

        .btn-delivered:hover {
            background: linear-gradient(45deg, #2ecc71, #27ae60);
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .table-container {
                width: 100%;
                margin: 20px auto;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Pending Orders Section -->
        <div class="table-container">
            <h2>Pending Orders</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Delivery Address</th>
                        <th>Order Date</th>
                        <th>Food Items</th>
                        <th>Total Price</th>
                        <th>Payment Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $current_order_id = null;
                    $total_price = 0;
                    $food_items_list = '';

                    if (mysqli_num_rows($pending_orders_result) > 0) {
                        while ($order = mysqli_fetch_assoc($pending_orders_result)) {
                            if ($order['order_id'] !== $current_order_id) {
                                if ($current_order_id !== null) {
                                    echo "<td>$food_items_list</td>
                                          <td>$total_price</td>
                                          <td>
                                              <form method='POST'>
                                                  <input type='hidden' name='order_id' value='{$current_order_id}'>
                                                  <input type='submit' name='mark_as_delivered' class='btn-delivered' value='Mark as Delivered'>
                                              </form>
                                          </td>
                                          </tr>";
                                }
                                $current_order_id = $order['order_id'];
                                $food_items_list = '';
                                $total_price = 0;
                                echo "<tr>
                                      <td>{$order['order_id']}</td>
                                      <td>{$order['delivery_address']}</td>
                                      <td>{$order['order_date']}</td>";
                            }
                            $food_items_list .= "{$order['food_item']} ({$order['quantity']}), ";
                            $total_price += $order['quantity'] * $order['price'];
                            $payment_status = $order['payment_status'];
                        }
                        if ($current_order_id !== null) {
                            echo "<td>$food_items_list</td>
                                  <td>$total_price</td>
                                  <td>$payment_status</td>
                                  <td>
                                      <form method='POST'>
                                          <input type='hidden' name='order_id' value='{$current_order_id}'>
                                          <input type='submit' name='mark_as_delivered' class='btn-delivered' value='Mark as Delivered'>
                                      </form>
                                  </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No pending orders</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Delivered Orders Section -->
        <div class="table-container">
            <h2>Delivered Orders</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Delivery Address</th>
                        <th>Order Date</th>
                        <th>Food Items</th>
                        <th>Total Price</th>
                        <th>Payment Status</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $current_order_id = null;
                    $total_price = 0;
                    $food_items_list = '';

                    if (mysqli_num_rows($delivered_orders_result) > 0) {
                        while ($order = mysqli_fetch_assoc($delivered_orders_result)) {
                            if ($order['order_id'] !== $current_order_id) {
                                if ($current_order_id !== null) {
                                    echo "<td>$food_items_list</td>
                                    <td>$payment_status</td>
                                    <td>$total_price</td><td>Delivered</td></tr>";
                                }
                                $current_order_id = $order['order_id'];
                                $food_items_list = '';
                                $total_price = 0;
                                echo "<tr>
                                      <td>{$order['order_id']}</td>
                                      <td>{$order['delivery_address']}</td>
                                      <td>{$order['order_date']}</td>";
                            }
                            $food_items_list .= "{$order['food_item']} ({$order['quantity']}), ";
                            $total_price += $order['quantity'] * $order['price'];
                            $payment_status = $order['payment_status'];
                        }
                        if ($current_order_id !== null) {
                            
                            echo "<td>$food_items_list</td><td>$total_price</td><td>Delivered</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No delivered orders</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
