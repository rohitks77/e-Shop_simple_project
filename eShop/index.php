<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "ecommerce");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM products";
$result1 = mysqli_query($conn, $sql);

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'add_to_cart') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $image = $_POST['image'];
        if (!isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = array(
                'id' => $id,
                'name' => $name,
                'price' => $price,
                'quantity' => $quantity,
                'image' => $image
            );
        }
    } elseif ($_POST['action'] == 'buy_now') {
        header("Location: mycart.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="splash.css">
<style>

    #navbar{
        position: fixed;
        
        /* background-color: red; */
        /* color: ; */
    }
    .content_home{
        padding-top: 100px;
    }
</style>
</head>

<body>
    <!-- splash screen code here -->
    <div id="splash-screen">
        <div class="splash-content">
            <img src="e_shop.png" alt="e-Shop Logo" width="300px" class="splash-image">
            <h1>Welcome to <span> e-Shop</span></h1>
            <div class="loader"></div>
        </div>
    </div>
    <!-- nav bar start from here ************************ -->
    <nav id="navbar">
        <div class="left_nav"><img src="e_shop.png" width="100%" alt=""></div>
        <div class="middle_nav">
            <ul>
                <li><a href="#home">Home </a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#content-items">Product</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="myorder.php">Order</a></li>
            </ul>
            <div class="bar_icon">
                <i class="fa-solid fa-bars"></i>
            </div>

        </div>
        <div class="right_nav">

            <i class="fa-solid fa-magnifying-glass" onclick="SearchOpenClose();"></i>
            <div class="cart">
                <a href="mycart.php"> <i class="fa-solid fa-cart-shopping"></i>
                    <div class="item_no"><?php echo count($_SESSION['cart'] ?? []); ?></div>
                </a>
            </div>
            <div class="Home_icon">
                <a href="SignUp.php"><i class="fa-solid fa-house-user"></i></a>

            </div>

        </div>
        <form class="searchbox" onsubmit="event.preventDefault(); filterItems();">
            <input id="searchInput" type="search" placeholder="⚡I'm looking for...">
            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
    </nav>

    </section>
    <!-- home pages start -->
    <section class="content_home" id="home">
        <div class="left_home">
            <h1>Welcome to e-Shop</h1>
            <p>Your Ultimate Online Destination for Everything You Need! Discover a vast array of products, from trendy fashion to cutting-edge gadgets, all at your fingertips.!</p>
            <button style="background-color: blue;"> <a href="#content-items">Buy Now</a></button>
        </div>
        <div class="right_home">
            <img src="home_page_.png" alt="">
        </div>
    </section>
    <!-- home pages end here -->
    <section class="content-items" id="content-items">
        <div class="items_container">
            <?php
            if (mysqli_num_rows($result1) > 0) {
                while ($row = mysqli_fetch_assoc($result1)) {
            ?>
                    <div class="div1">
                        <div class="product_img">
                            <img src="<?php echo $row['image']; ?>" alt="">
                        </div>

                        <form action="" method="post"  >
                            <h1><?php echo $row['name']; ?></h1>
                            <div class="upper_form_part">
                                <label for="name">Rs.<?php echo $row['price']; ?> only</label>
                                <input type="number" name="quantity" value="1">
                            </div>
                            <div class="lower_part_form">
                                <?php if (isset($_SESSION['cart'][$row['id']])) { ?>
                                    <input type="submit" name="action" value="Buy Now">
                                    <input type="hidden" name="action" value="buy_now">
                                <?php } else { ?>
                                    <input type="submit" name="action" value="Add to Cart">
                                    <input type="hidden" name="action" value="add_to_cart">
                                <?php } ?>
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
                                <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                                <input type="hidden" name="image" value="<?php echo $row['image']; ?>">
                            </div>
                        </form>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </section>
    <?php include 'CApage/CApage.php' ?>
    <!-- home page end -->
    <script src="script.js"></script>
    <script>
        // splash screen code here **********
        setTimeout(function() {
            const splashScreen = document.getElementById('splash-screen');
            splashScreen.style.opacity = '0';
            setTimeout(function() {
                splashScreen.style.display = 'none';
            }, 300); // Wait for the fade-out transition
        }, 3000);
        // Display the splash screen for 3 seconds

            
    </script>
</body>

</html>
<?php

?>