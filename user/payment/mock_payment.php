<?php
session_start();

// Check if the order ID is in session
if (!isset($_SESSION['order_id'])) {
    echo '<script>alert("No order found!"); window.location.href="restaurantdetails.php";</script>';
    exit;
}

$order_id = $_SESSION['order_id'];  // Retrieve the order ID

// If payment is successful, this will store the status and redirect
if (isset($_POST['submit_payment'])) {
    $payment_method = $_POST['payment_method'];

    // Simulate successful payment
    if ($payment_method == 'upi') {
        $upi_id = $_POST['upi_id'];
        echo '<script>alert("UPI Payment Successful! UPI ID: '.$upi_id.'"); window.location.href="payment_success.php";</script>';
    } elseif ($payment_method == 'card') {
        $card_number = $_POST['card_number'];
        $expiry_date = $_POST['expiry_date'];
        $cvv = $_POST['cvv'];
        echo '<script>alert("Card Payment Successful! Card Number: '.$card_number.'"); window.location.href="payment_success.php";</script>';
    } else {
        echo '<script>alert("Payment failed! Try again."); window.location.href="mock_payment.php";</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mock Payment</title>
    <link rel="stylesheet" href="../css/bootstrap.css"> <!-- Bootstrap for styling -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 100px;
            max-width: 500px;
            background-color: white;
            padding: 40px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        h2 {
            color: #007bff;
            font-size: 24px;
            text-align: center;
            margin-bottom: 30px;
        }
        .btn {
            margin-top: 20px;
            width: 100%;
            padding: 10px;
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
        .payment-method {
            margin-bottom: 20px;
        }
        .payment-details {
            display: none;
        }
        .show {
            display: block !important;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Mock Payment Page</h2>
        <form method="POST" id="paymentForm">
            <div class="payment-method">
                <h4>Select Payment Method</h4>
                <input type="radio" id="upi" name="payment_method" value="upi" required> 
                <label for="upi">UPI</label><br>
                <input type="radio" id="card" name="payment_method" value="card" required> 
                <label for="card">Card</label><br><br>
            </div>

            <!-- UPI Payment Details -->
            <div id="upi-details" class="payment-details">
                <h5>UPI Payment</h5>
                <div class="form-group">
                    <label for="upi_id">Enter UPI ID:</label>
                    <input type="text" class="form-control" id="upi_id" name="upi_id" placeholder="yourname@bank" pattern="^\w+@\w+$">
                </div>
            </div>

            <!-- Card Payment Details -->
            <div id="card-details" class="payment-details">
                <h5>Card Payment</h5>
                <div class="form-group">
                    <label for="card_number">Card Number:</label>
                    <input type="text" class="form-control" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" pattern="\d{16}">
                </div>
                <div class="form-group">
                    <label for="expiry_date">Expiry Date:</label>
                    <input type="text" class="form-control" id="expiry_date" name="expiry_date" placeholder="MM/YY" pattern="\d{2}/\d{2}">
                </div>
                <div class="form-group">
                    <label for="cvv">CVV:</label>
                    <input type="text" class="form-control" id="cvv" name="cvv" placeholder="123" pattern="\d{3}">
                </div>
            </div>

            <input type="submit" name="submit_payment" value="Submit Payment" class="btn">
        </form>
    </div>

    <script>
        // Show or hide payment details based on payment method selection
        document.querySelectorAll('input[name="payment_method"]').forEach((elem) => {
            elem.addEventListener("change", function(event) {
                var value = event.target.value;

                // Hide all payment details initially
                document.getElementById('upi-details').classList.remove('show');
                document.getElementById('card-details').classList.remove('show');

                // Show the correct payment form based on selection
                if (value === 'upi') {
                    document.getElementById('upi-details').classList.add('show');
                    // Remove required attributes for card fields
                    document.getElementById('card_number').removeAttribute('required');
                    document.getElementById('expiry_date').removeAttribute('required');
                    document.getElementById('cvv').removeAttribute('required');
                } else if (value === 'card') {
                    document.getElementById('card-details').classList.add('show');
                    // Add required attributes for card fields
                    document.getElementById('card_number').setAttribute('required', true);
                    document.getElementById('expiry_date').setAttribute('required', true);
                    document.getElementById('cvv').setAttribute('required', true);
                }
            });
        });
    </script>
</body>
</html>
