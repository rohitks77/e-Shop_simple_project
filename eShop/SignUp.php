<?php
session_start();

$name = "";
$email = "";
$password = "";
$confirm_password = "";
$account_status = "";

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_SESSION['email'] = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password === $confirm_password) {
        $account_status = "Account created successfully, please log in";

        $servername = "localhost";
        $servername_username = "root";
        $server_password = "";
        $conn = mysqli_connect("localhost", "root", "");

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // create database if not exists
        $sql = "CREATE DATABASE IF NOT EXISTS ecommerce";
        mysqli_query($conn, $sql);

        // select database
        mysqli_select_db($conn, "ecommerce");

        // Create table if not exists
        $tableSql = "CREATE TABLE IF NOT EXISTS users (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(30) NOT NULL,
            email VARCHAR(50),
            password VARCHAR(50)
        )";
        mysqli_query($conn, $tableSql);

        // Insert into table
        $insertSql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
        if (mysqli_query($conn, $insertSql)) {
            // echo "New record inserted successfully";
        } else {
            echo "Error: " . $insertSql . "<br>" . mysqli_error($conn);
        }

        mysqli_close($conn); // Close the connection

        // Redirect to user account pages
        if ($account_status) {
            $url = 'home.php'; // Replace this with your desired URL
            $delay = 2; // Delay in seconds
        
            header("refresh:$delay;url=$url");
            exit; // To prevent further execution of the script
        }
    } else {
        $account_status = "Passwords do not match";
    }
}



?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp</title>
    <style>
        body {
            display: flex;
            height: 80vh;
            align-items: center;
            justify-content: center;
            height: 95vh;
        }

        .container {
            
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;

            width: 50%;
            max-width: 500px;
            min-width: 320px;
            min-height: 400px;
            /* height: 70%; */
            border-radius: 7px;
            padding: 10px;
            background-color: rgb(0, 35, 51);
            color: white;
            margin: auto;
        }

        a {
            text-decoration: none;
        }

        .top_part {
            /* background-color: black; */
            height: 60px;

        }

        .bottom_part {
            /* background-color: red; */
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;

        }

        .bottom_part h1 {
            color: rgb(0, 0, 184);
            /* background-color: red; */
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-weight: 800;
        }

        form {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;

            /* align-items: center; */
            /* background-color: blue; */
            /* padding-top: 15px; */

        }


        .form_fillup {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            column-gap: 10px;
            /* background-color: red; */
        }

        .form_fillup input {

           
            background-color: transparent;
           color: white;
            /* padding-left: 20px; */
            font-size: 17px;
            height: 30px;
            outline: none;
            /* border: none; */
            border: 0;
            border-bottom: 2px solid rgb(100, 70, 20);
            width: 40%;
            min-width: 250px;
            margin-top: 10px;

        }

        form button {
            width: 40%;
            min-width: 270px;
            border-radius: 7px;
            border: none;
            margin-top: 10px;
            margin-bottom: 10px;
            /* width: 100%; */
            height: 35px;
            cursor: pointer;
        }

        form button:hover {
            background-color: rgb(214, 219, 224);
        }

        .terms_condition {
            text-align: center;
            padding: 0px 20px 0px 20px;
            opacity: 80%;
            /* background-color: red; */
        }
    </style>
</head>

<body>

    <div class="container">
        
        <div class="top_part"><a href="index.php"><img src="images/e_shop.png" width="160px" alt=""></a></div>
        <div class="bottom_part">
            <h3><?php echo $account_status; ?></h3>
            <h1>Sign Up</h1>
            <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
                <div class="form_fillup">
                    <input type="text" name="name" placeholder="Name" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="password" name="confirm_password" placeholder="confirm password" required>
                </div>
                <button name="submit">Submit</button>
            </form>
        </div>
        <div class="already_account">
            <h3>Has an already account? <a href="LogIn.php"> Log In </a></h3>
        </div>
        <div class="terms_condition">
            By signing up to create an account i accept company's Terms of condition and privacy policy
        </div>
    </div>
</body>

</html>
