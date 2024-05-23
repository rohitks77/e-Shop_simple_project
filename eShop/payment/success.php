<?php
session_start();
if (!isset($_SESSION['order_completed'])) {
    header('Location: index.php');
    exit;
}
unset($_SESSION['cart']);
unset($_SESSION['transaction_id']);
unset($_SESSION['order_completed']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <nav>
        <!-- Navbar content -->
        <div class="left_nav"><img src="e_shop.png" width="100%" alt=""></div>
        <div class="middle_nav">
            <ul>
                <li><a href="../home.php">Home</a></li>
                <li><a href="../home.php#about">About</a></li>
                <li><a href="../home.php#products">Product</a></li>
                <li><a href="../order.php">Order</a></li>
                <li><a href="../home.php#contact">Contact</a></li>
            </ul>
            <div class="bar_icon">
                <i class="fa-solid fa-bars" style="cursor: pointer;"></i>
            </div>
        </div>
        <div class="right_nav">
            <i class="fa-solid fa-magnifying-glass" onclick="SearchOpenClose();" style="cursor: pointer;"></i>
            <div class="cart">
                <a href="mycart.php"><i class="fa-solid fa-cart-shopping"></i></a>
                <div class="item_no"><?php echo count($_SESSION['cart'] ?? []); ?></div>
            </div>
            <div class="Home_icon">
                <a href="login_details.php"><i class="fa-solid fa-user-gear"></i></a>
            </div>
        </div>
        <form class="searchbox">
            <input type="search" placeholder="⚡I'm looking for...">
            <button><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
    </nav>

    <main class="checkout-container">
        <h1>Order Success</h1>
        <p>Thank you for your payment. Your order has been successfully placed.</p>
        <a href="index.php">Back to Home</a>
    </main>
</body>

</html>
