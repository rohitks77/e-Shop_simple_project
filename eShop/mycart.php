<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "ecommerce");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['user_id'])) {

    header("Location: LogIn.php");
}

if (isset($_POST['action'])) {
    $id = $_POST['id'];

    if ($_POST['action'] == 'update_quantity') {
        $quantity = $_POST['quantity'];
        if (is_numeric($quantity) && $quantity > 0) {
            $_SESSION['cart'][$id]['quantity'] = $quantity;
        }
    } elseif ($_POST['action'] == 'remove_item') {
        unset($_SESSION['cart'][$id]);
    }
}

$total_price = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="mycart.css">
</head>

<body>
    <nav>
        <div class="left_nav"><img src="e_shop.png" width="100%" alt=""></div>
        <div class="middle_nav">
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="home.php#about">About</a></li>
                <li><a href="home.php#products">Product</a></li>
                <li><a href="myorder.php">Order</a></li>
                <li><a href="home.php#contact">Contact</a></li>
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

    <main>
        <h1>My Cart</h1>
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($_SESSION['cart'])) : ?>
                    <?php foreach ($_SESSION['cart'] as $item) : ?>
                        <?php
                        $item_price = str_replace(',', '', $item['price']); // Remove comma from price string
                        if (is_numeric($item_price) && is_numeric($item['quantity'])) {
                            $total_price += $item_price * $item['quantity'];
                        }
                        ?>
                        <tr>
                            <td><img src="<?php echo htmlspecialchars($item['image']); ?>" alt="" width="50"></td>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td>
                                <form action="" method="post" class="update_quantity_form">
                                    <input type="number" name="quantity" value="<?php echo htmlspecialchars($item['quantity']); ?>" min="1">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']); ?>">
                                    <input type="hidden" name="action" value="update_quantity">
                                    <button type="submit">Update</button>
                                </form>
                            </td>
                            <td><?php echo htmlspecialchars($item['price']); ?></td>
                            <td>
                                <form action="" method="post" class="remove_item_form">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']); ?>">
                                    <input type="hidden" name="action" value="remove_item">
                                    <button type="submit">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="total-price">Total Price: Rs. <?php echo $total_price; ?></div>
        <a href="billingaddress.php" class="checkout-btn">Checkout</a>
    </main>

    <script>
        document.querySelectorAll('.update_quantity_form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                fetch('', {
                    method: 'POST',
                    body: formData
                }).then(response => response.text()).then(data => {
                    location.reload();
                });
            });
        });

        document.querySelectorAll('.remove_item_form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                fetch('', {
                    method: 'POST',
                    body: formData
                }).then(response => response.text()).then(data => {
                    location.reload();
                });
            });
        });
    </script>
</body>

</html>