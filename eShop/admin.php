<?php
session_start();
$message = "";
$conn = mysqli_connect("localhost", "root", "", "ecommerce");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if (!isset($_SESSION['admin'])) {

    header("Location: LogIn.php");
}
// Handle form submission for adding a new product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['product_description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $file = $_FILES['file'];
    $destination = 'upload/' . basename($file['name']);

    if (move_uploaded_file($file['tmp_name'], $destination)) {
        $sql = "INSERT INTO products (name, description, price, image) VALUES ('$name', '$description', '$price', '$destination')";
        if (mysqli_query($conn, $sql)) {
            $message = "Product uploaded successfully.";
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    } else {
        $message = "Error uploading file.";
    }
}

// Handle product update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    $sql_update = "UPDATE products SET name='$name', description='$description', price='$price' WHERE id=$id";
    if (mysqli_query($conn, $sql_update)) {
        $message = "Product updated successfully.";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

// Handle product deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $sql_delete = "DELETE FROM products WHERE id=$id";
    if (mysqli_query($conn, $sql_delete)) {
        $message = "Product deleted successfully.";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

// Fetch all products
$sql_fetch_products = "SELECT * FROM products";
$result_products = mysqli_query($conn, $sql_fetch_products);

// Fetch all orders
$sql_fetch_orders = "SELECT * FROM orders";
$result_orders = mysqli_query($conn, $sql_fetch_orders);
 $total_price = 0; // Initialize total price variable 


// Fetch all users
$sql_fetch_users = "SELECT * FROM users";
$result_users = mysqli_query($conn, $sql_fetch_users);

// Fetch all messages
$sql_fetch_messages = "SELECT * FROM messages";
$result_messages = mysqli_query($conn, $sql_fetch_messages);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            width: 200px;
            height: 100vh;
            background-color: #333;
            color: #fff;
            position: fixed;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            padding-top: 20px;
        }

        .sidebar a {
            padding: 15px 20px;
            color: #fff;
            text-decoration: none;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #575757;
        }

        .content {
            margin-left: 200px;
            padding: 20px;
        }

        .topbar {
            background-color: #fff;
            padding: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .topbar img {
            border-radius: 50%;
            width: 40px;
            height: 40px;
        }

        .form-container,
        .table-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }



        .form-container h5 {
            color: green;
            margin-bottom: 20px;
        }

        .form-container label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .form-container input,
        .form-container textarea {
            margin-bottom: 15px;
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-container input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            padding: 10px 15px;
        }

        .form-container input[type="submit"]:hover {
            background-color: #218838;
        }

        .table img {
            max-width: 50px;
            height: auto;
        }

        .edit-button,
        .delete-button {
            padding: 5px 10px;
            border-radius: 4px;
            color: white;
            cursor: pointer;
            border: none;
        }

        .edit-button {
            background-color: #007bff;
        }

        .edit-button:hover {
            background-color: #0056b3;
        }

        .delete-button {
            background-color: #dc3545;
        }

        .delete-button:hover {
            background-color: #c82333;
        }

        .section {
            display: none;
        }

        .section.active {
            display: block;
        }

        .product-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }

        .product-card img {
            max-width: 50px;
        }

        .product-details {
            flex-grow: 1;
            padding: 0 10px;
        }

        .product-actions {
            display: flex;
            gap: 10px;
        }

        /* custme */
        .table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        /* Table header styles */
        .table thead {
            background-color: #007bff;
            color: #fff;
        }

        .table thead th {
            padding: 10px 15px;
            text-align: left;
            font-weight: bold;
        }

        /* Table body styles */
        .table tbody tr {
            border-bottom: 1px solid #e0e0e0;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f5f5f5;
        }

        .table tbody td {
            padding: 10px 15px;
            color: #333;
        }
        .total_price{
            padding: 20px;
            width: 200px;
            border-radius: 4px;
            background-color: yellow;
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
    <script>
        function showSection(sectionId) {
            var sections = document.querySelectorAll('.section');
            sections.forEach(function(section) {
                section.classList.remove('active');
            });
            document.getElementById(sectionId).classList.add('active');

            var links = document.querySelectorAll('.sidebar a');
            links.forEach(function(link) {
                link.classList.remove('active');
            });
            document.querySelector('[onclick="showSection(\'' + sectionId + '\')"]').classList.add('active')
        }
    </script>
</head>

<body>
    <div class="sidebar">
        <a href="javascript:void(0)" onclick="showSection('dashboard')" class="active">Dashboard</a>
        <a href="javascript:void(0)" onclick="showSection('customers')">Customers</a>
        <a href="javascript:void(0)" onclick="showSection('orders')">Orders</a>
        <a href="javascript:void(0)" onclick="showSection('messages')">Messages</a>
        <a href="javascript:void(0)" onclick="showSection('payments')">Payments</a>
    </div>
    <div class="content">
        <div class="topbar">
            <div>Admin Panel</div>
            <div>
                
                <span><a href="session_destroy_logIn.php">Log Out <i class="fa-solid fa-right-from-bracket"></i> </a></span>
            </div>
        </div>

        <div id="dashboard" class="section active">
            <div class="form-container">
                <h5><?php echo $message; ?></h5>
                <form id="addProductForm" onsubmit="submitForm('addProductForm');" method="post" enctype="multipart/form-data">
                    <label for="name">Product Name:</label>
                    <input type="text" id="name" name="name" required>

                    <label for="product_description">Description:</label>
                    <textarea id="product_description" name="product_description" required></textarea>

                    <label for="price">Price:</label>
                    <input type="text" id="price" name="price" required>

                    <label for="file">Upload Image:</label>
                    <input type="file" id="file" name="file" required>

                    <input type="submit" name="submit" value="Add Product">
                </form>
            </div>

            <div class="table-container">
                <?php if (mysqli_num_rows($result_products) > 0) : ?>
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result_products)) : ?>
                                <tr>
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                        <td><?php echo $row['id']; ?></td>
                                        <td>
                                            <input type="text" name="name" class="form-control" value="<?php echo $row['name']; ?>">
                                        </td>
                                        <td>
                                            <textarea name="description" class="form-control"><?php echo $row['description']; ?></textarea>
                                        </td>
                                        <td>
                                            <input type="text" name="price" class="form-control" value="<?php echo $row['price']; ?>">
                                        </td>
                                        <td>
                                            <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                                        </td>
                                        <td>
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <input type="submit" name="update" value="Update" class="btn btn-primary edit-button">
                                            <button type="submit" name="delete" class="btn btn-danger delete-button">Delete</button>
                                        </td>
                                    </form>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <p>No products found.</p>
                <?php endif; ?>
            </div>
        </div>

        <div id="customers" class="section">
            <div class="table-container">
                <h2>Customers</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result_users)) : ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="messages" class="section">
            <div class="table-container">
                <h2>Messages</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User ID</th>
                            <th>Message</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result_messages)) : ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['message']; ?></td>
                                <td><?php echo $row['created_at']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="orders" class="section">
            <h2>Orders Section</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User Id</th>
                        <th>Product Id</th>
                        <th>Quantity</th>
                        <th>price</th>
                        <th>Order Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result_orders)) : ?>

                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['user_id']; ?></td>
                            <td><?php echo $row['product_id']; ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td><?php echo $row['order_date']; ?></td>
                        </tr>
                    <?php
                        // Calculate total price for the current row and add it to the total
                        $item_total = $row['quantity'] * $row['price'];
                        $total_price += $item_total;
                    endwhile; ?>
                </tbody>
            </table>
        </div>

        <div id="payments" class="section">
            <h2>Payments Section</h2>
            <div class="total_price">Total Price Sold: RS.<?php echo  $total_price;  ?></div>
        </div>
       
        
    </div>

    <script>
        function showSection(sectionId) {
            var sections = document.querySelectorAll('.section');
            sections.forEach(function(section) {
                section.classList.remove('active');
            });
            document.getElementById(sectionId).classList.add('active');

            var links = document.querySelectorAll('.sidebar a');
            links.forEach(function(link) {
                link.classList.remove('active');
            });
            document.querySelector('[onclick="showSection(\'' + sectionId + '\')"]').classList.add('active');
        }

        function submitForm(formId) {
            var form = document.getElementById(formId);
            var formData = new FormData(form);

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "", true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var messageContainer = document.getElementById('message-container');
                    messageContainer.innerHTML = xhr.responseText;
                    location.reload(); // Reload the page after displaying the message
                }
            };
            xhr.send(formData);
        }

        document.addEventListener('DOMContentLoaded', function() {
            showSection('dashboard');
        });
    </script>
</body>

</html>