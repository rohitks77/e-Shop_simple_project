<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "ecommerce");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['user_id'])) {
    header("Location: LogIn.php");
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT o.id, m.name AS product_name, o.order_date, o.quantity, o.price,o.address
        FROM orders o
        JOIN products m ON o.product_id = m.id
        WHERE o.user_id = '$user_id'";
$result = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Internal CSS styles for additional customization */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        .empty-message {
            text-align: center;
            color: #777;
        }

        .order_title {
            margin-top: 10px;
        }
    </style>
</head>
<body>
<nav>
        <!-- Navbar content -->
        <div class="left_nav"><img src="images/e_shop.png" width="100%" alt=""></div>
        <div class="middle_nav">
            <ul>
                <li><a href="home.php#home">Home</a></li>
                <li><a href="home.php#about">About</a></li>
                <li><a href="home.php#products">Product</a></li>
                <li><a href="home.php#contact">Contact</a></li>
                <li><a href="myorder.php">Order</a></li>
                
            </ul>
            <div class="bar_icon">
                <i class="fa-solid fa-bars" style="cursor: pointer;"></i>
            </div>
        </div>
        <div class="right_nav">
            <i class="fa-solid fa-magnifying-glass" onclick="SearchOpenClose();" style="cursor: pointer;"></i>
            <div class="cart">
                <a href="mycart.php"><i class="fa-solid fa-cart-shopping"></i>
                <div class="item_no"><?php echo count($_SESSION['cart'] ?? []); ?></div>
                </a>
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
    <div class="order_title">
        <h1>Ordered products</h1>
    </div>
    <div class="container">
        <?php if (mysqli_num_rows($result) > 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product Name</th>
                        <th>Ordered Date</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Shipping Address</th>
                        <!-- Add any other relevant columns -->
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['product_name']; ?></td>
                            <td><?php echo $row['order_date']; ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <!-- Display other columns as needed -->
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p class="empty-message">No orders found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
