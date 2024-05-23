<?php
$message = "";
$conn = mysqli_connect("localhost", "root", "", "ecommerce");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create products table if it doesn't exist
$sql_create_table = "CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    description VARCHAR(255),
    price VARCHAR(255),
    image VARCHAR(255)
)";

if (!mysqli_query($conn, $sql_create_table)) {
    echo "Error creating products table: " . mysqli_error($conn) . "<br>";
}

// Handle form submission for adding a new product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = $_POST['product_description'];
    $price = $_POST['price'];
    $file = $_FILES['file'];
    $destination = 'upload/' . $_FILES['file']['name'];
    move_uploaded_file($_FILES['file']['tmp_name'], $destination);

    $sql = "INSERT INTO products (name, description, price, image) VALUES ('$name', '$description', '$price', '$destination')";
    if (mysqli_query($conn, $sql)) {
        $message = "Product uploaded successfully.";
        header("refresh:3");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Handle product deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql_delete = "DELETE FROM products WHERE id=$id";
    if (mysqli_query($conn, $sql_delete)) {
        $message = "Product deleted successfully.";
        header("Location: " . $_SERVER['PHP_SELF']);
    } else {
        echo "Error: " . $sql_delete . "<br>" . mysqli_error($conn);
    }
}

// Fetch all products
$sql_fetch_products = "SELECT * FROM products";
$result = mysqli_query($conn, $sql_fetch_products);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            width: 100%;
            height: 100vh;
            padding: 20px;
            gap: 20px;
        }

        form {
            background-color: #fff;
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-size: 16px;
            max-width: 400px;
        }

        form h5 {
            color: green;
            margin-bottom: 10px;
        }

        form label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        form input,
        form textarea,
        form select {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        form input[type="file"] {
            font-size: 16px;
        }

        form input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        form input[type="submit"]:hover {
            background-color: #218838;
        }

        .right_sec {
            flex: 2;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .delete-button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        .delete-button:hover {
            background-color: #c82333;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .right_sec {
                margin-top: 20px;
            }

            form {
                font-size: 14px;
                padding: 15px;
            }

            form input,
            form textarea,
            form select {
                font-size: 14px;
                padding: 8px;
            }

            table, th, td {
                font-size: 14px;
                padding: 10px;
            }

            .delete-button {
                padding: 3px 5px;
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
            <h5><?php echo $message; ?></h5>
            <label for="name">Product Name</label>
            <input type="text" name="name" placeholder="Product Name" required>
            <label for="product_description">Product Description</label>
            <textarea name="product_description" cols="30" rows="3" placeholder="Product Description optional !"></textarea>
            <label for="price">Price</label>
            <input type="text" name="price" placeholder="Price" required>
            <label for="file">Images</label>
            <input type="file" name="file" accept="image/png, image/jpeg" required>
            <input type="submit" name="submit" value="Submit">
        </form>
        <div class="right_sec">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['description']; ?></td>
                                <td><?php echo $row['price']; ?></td>
                                <td><img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" width="50"></td>
                                <td>
                                    <a href="?delete=<?php echo $row['id']; ?>" class="delete-button">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No products found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
