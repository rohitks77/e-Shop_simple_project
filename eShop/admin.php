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

// Handle product update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $sql_update = "UPDATE products SET name='$name', description='$description', price='$price' WHERE id=$id";
    if (mysqli_query($conn, $sql_update)) {
        $message = "Product updated successfully.";
        header("Location: " . $_SERVER['PHP_SELF']);
    } else {
        echo "Error: " . $sql_update . "<br>" . mysqli_error($conn);
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 20px;
        }

        .form-container, .table-container {
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
        }

        .form-container input, 
        .form-container textarea, 
        .form-container select {
            margin-bottom: 15px;

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

        .edit-button, .delete-button {
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
        textarea{
            scrollbar-width: 0;
        }
        textarea::-webkit-scrollbar{
            width: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <h5><?php echo $message; ?></h5>
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
                <label for="name">Product Name</label>
                <input type="text" name="name" class="form-control" placeholder="Product Name" required>
                <label for="product_description">Product Description</label>
                <textarea name="product_description" class="form-control" cols="30" rows="3" placeholder="Product Description (optional)"></textarea>
                <label for="price">Price</label>
                <input type="text" name="price" class="form-control" placeholder="Price" required>
                <label for="file">Image</label>
                <input type="file" name="file" class="form-control-file" accept="image/png, image/jpeg" required>
                <input type="submit" name="submit" value="Submit" class="btn btn-success mt-3">
            </form>
        </div>

        <div class="table-container">
            <?php if (mysqli_num_rows($result) > 0): ?>
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
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
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
                                        <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger delete-button">Delete</a>
                                    </td>
                                </form>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No products found.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
