<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success</title>
    <link rel="stylesheet" href="../css/bootstrap.css"> <!-- Bootstrap for styling -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 100px;
            text-align: center;
            background-color: white;
            padding: 50px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        h1 {
            color: #28a745;
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        p {
            font-size: 18px;
            color: #333;
            margin-bottom: 30px;
        }
        .btn {
            margin: 10px;
            padding: 10px 30px;
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
            font-size: 50px;
            color: #28a745;
            margin-bottom: 20px;
        }
    </style>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script> <!-- Font Awesome for icons -->
</head>
<body>
    <div class="container">
        <i class="fas fa-check-circle icon"></i> <!-- Success icon -->
        <h1>Order Placed Successfully!</h1>
        <p>Thank you for your order. Your payment was successful and your order has been placed.</p>

        <div>
            <!-- Button to continue browsing -->
            <a href="http://localhost/eatsmartfood/user/orderfood.php" class="btn">Continue Browsing</a>

        </div>
    </div>
</body>
</html>
