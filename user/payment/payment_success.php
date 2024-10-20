<?php
session_start();
include '../../connection.php';  // Ensure correct path

// Check if the order ID is in session
if (!isset($_SESSION['order_id'])) {
    echo '<script>alert("No order found!"); window.location.href="restaurantdetails.php";</script>';
    exit;
}

$order_id = $_SESSION['order_id'];
$restaurant_id = $_SESSION['restaurant_id'];
$delivery_address = $_SESSION['delivery_address'];

// Insert the order into 'tblorders'
$order_query = "INSERT INTO tblorders (order_id, rId, delivery_address) VALUES (?, ?, ?)";
$stmt = $conn->prepare($order_query);
$stmt->bind_param("sis", $order_id, $restaurant_id, $delivery_address);
$order_result = $stmt->execute();

if (!$order_result) {
    die('Error inserting order: ' . $conn->error);
}

// Insert each item into 'tblorderitems'
$item_query = "INSERT INTO tblorderitems (order_id, food_item, quantity, price) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($item_query);

foreach ($_SESSION['cart'] as $cart_item) {
    $food_name = $cart_item['food_name'];
    $quantity = $cart_item['quantity'];
    $price = $cart_item['price'];

    $stmt->bind_param("ssii", $order_id, $food_name, $quantity, $price);
    $item_result = $stmt->execute();

    if (!$item_result) {
        die('Error inserting order item: ' . $conn->error);
    }
}

// Clear the session variables and cart
unset($_SESSION['cart']);
unset($_SESSION['order_id']);
unset($_SESSION['delivery_address']);
unset($_SESSION['restaurant_id']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="../css/bootstrap.css"> <!-- Include Bootstrap -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 100px;
            max-width: 600px;
            background-color: white;
            padding: 40px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: center;
        }
        h1 {
            color: #28a745;
            font-size: 36px;
            font-weight: bold;
        }
        p {
            font-size: 18px;
            color: #555;
            margin-bottom: 30px;
        }
        .btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            text-transform: uppercase;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .icon {
            font-size: 80px;
            color: #28a745;
            margin-bottom: 20px;
        }
        .order-summary {
            text-align: left;
            margin: 30px 0;
        }
        .order-summary h4 {
            margin-bottom: 15px;
            color: #333;
        }
        .order-summary p {
            margin: 5px 0;
            font-size: 16px;
            color: #555;
        }
    </style>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script> <!-- Include Font Awesome for icons -->
</head>
<body>

    <div class="container">
        <i class="fas fa-check-circle icon"></i> <!-- Success icon -->
        <h1>Order Placed!</h1>
        <p>Thank you for your order! Your payment was successful, and your order has been placed.</p>

        <div class="order-summary">
            <h4>Order Summary:</h4>
            <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order_id); ?></p>
            <p><strong>Delivery Address:</strong> <?php echo htmlspecialchars($delivery_address); ?></p>
            <p><strong>Restaurant ID:</strong> <?php echo htmlspecialchars($restaurant_id); ?></p>
        </div>

        <div>
            <a href="order_success.php" class="btn">Go to Order Summary</a>
            <a href="http://localhost/eatsmartfood/user/orderfood.php" class="btn btn-secondary">Continue Shopping</a>
        </div>
    </div>

    <script>
        // Redirect to the order summary page after a few seconds
        setTimeout(function(){
            window.location.href = "order_success.php";
        }, 5000);  // Redirect after 5 seconds
    </script>

</body>
</html>
