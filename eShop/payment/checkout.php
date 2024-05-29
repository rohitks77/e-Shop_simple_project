<?php

session_start();
$conn = mysqli_connect("localhost", "root", "", "ecommerce");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['user_id'])) {
    die("User not logged in");
}
$total_price = 0; // Initialize total price variable

// Calculate total price
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $price = (float) str_replace(',', '', $item['price']);
        $quantity = (int) $item['quantity'];
        $total_price += $price * $quantity;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['transaction_id'])) {
    $user_id = $_SESSION['user_id'];
    $transaction_id = $_POST['transaction_id'];

    // Insert orders into database
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $product_id = $item['id'];
            $quantity = $item['quantity'];
            $price = $item['price'];
            $address=$_SESSION['address'];

            $sql = "INSERT INTO orders (user_id, product_id, quantity, price, transaction_id, address) 
                    VALUES ('$user_id', '$product_id', '$quantity', '$price', '$transaction_id', '$address')";
            mysqli_query($conn, $sql);
        }

        // Clear the cart after successful order
        unset($_SESSION['cart']);
        
        // Redirect to success page
        $_SESSION['order_completed'] = true;
        header("Location: success.php");
        exit();
    } else {
        echo "Cart is empty.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
         .checkout-container h1{
            text-align: center;
            color: red;
         }
        .checkout-container {
            padding: 20px;
            margin: 0 auto;
            max-width: 600px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .qr-code {
            text-align: center;
            margin-bottom: 20px;
        }
        .qr-code img {
            width: 200px;
            height: 200px;
        }
        .total-price, .transaction-form {
            text-align: center;
            margin: 20px 0;
        }
        .transaction-form input {
            padding: 10px;
            width: calc(100% - 22px);
            margin-bottom: 10px;
        }
        .transaction-form button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .transaction-form button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <nav>
        <!-- Navbar content -->
        <!-- Your existing navbar HTML -->
    </nav>

    <main class="checkout-container">
        <h1>Checkout</h1>
        <div class="qr-code">
            <h2>Scan the QR Code to Pay</h2>
            <img src="e-pay.jpg" alt="QR Code">
        </div>
        <div class="total-price">Total Price: Rs. <?php echo $total_price; ?></div>
        <div class="transaction-form">
            <form action="checkout.php" method="post">
                <input type="text" name="transaction_id" placeholder="Enter Transaction ID" required>
                <button type="submit">Pay</button>
            </form>
        </div>
    </main>

</body>

</html>
