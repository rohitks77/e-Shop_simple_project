<?php
session_start();

if (empty($_SESSION['email']) || !isset($_SESSION['email'])) {
    $url = 'index.php'; // Replace this with your desired URL
    $delay = 0; // Delay in seconds

    header("refresh:$delay;url=$url");
    exit; // To prevent further execution of the script
}

$conn = mysqli_connect("localhost", "root", "", "ecommerce");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$email = $_SESSION['email'];

$selectSql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $selectSql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $name = $row['name'];
        $email = $row['email']; // Change this line
        $password = $row['password'];
    } else {
        $name = "User not found";
    }
} else {
    echo "Query failed: " . mysqli_error($conn);
}
$update_result="";
$updated_name=$name;
$updated_password=$password;
if(isset($_POST['submit'])){
    $updated_name = $_POST['name'];
    $updated_password = $_POST['password'];
    
    $updateSql = "UPDATE users SET name = '$updated_name', password = '$updated_password' WHERE email = '$email'";
    
    if (mysqli_query($conn, $updateSql)) {
        $update_result= "Record updated successfully";
        header("refresh:0");
    } else {
        $update_result="Error updating record: " . mysqli_error($conn);
    }
}


mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .container{
            width: 100wh;
            height: 100vh;
            /* background-color: red; */

        }
        .upper_part{
            width: 100%;
           height: 170px;
           min-height: 100px;
           max-height: 150px;
            background-color: blue;
            position: relative;
        }
        .logo{

            width: 200px;
            height: 200px;
            background-color: teal;
            position: relative;
            left: 50%;
            transform: translateX(-50%);
            bottom: -50px;
            border-radius: 100%;
            background-image: url("logo-user-icon-.png");
            background-position: center; /* Center the image */
            background-size: 100%;

        }
        .logo span{
         background-color: red;
            height: 200px;
            background-color: red;
            text-align: center;
            /* position: relative; */
            left: 50%;
           
            transform: translate(-50%,-50%);
            /* bottom: -20px; */
            font-size: 80px;
        }
        .lower_part{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding-top: 80px;
            position: relative;

            
        }
        .details{
            font-size: 20px;
            /* background-color: red; */
            width: 30%;
            min-width: 300px;
            padding: 10px;
            text-align: start;
            /* border-left: 2px solid black; */
            position: relative;
            box-shadow: 2px 3px 4px black;
            /* left: 10px; */

        }

        button{
            color: white;
            font-size: 17px;
            padding: 10px;
            background-color: teal;
            border: 0;
            border-radius: 3px;
            cursor: pointer;
            text-align: center;
            align-items: center;
        }
        a{
            color: white;
            text-decoration: none;
        }
        .update_container{
            color: white;
            display: none;
            position: absolute;
            right: 50%;
            transform: translateX(50%);
            top: 15%;
            /* transform: translateY(-50%); */
            z-index: 100;
            width: 40%;
            height: 70%;
            min-width: 320px;
            min-height: 400px;
            background-color: rgb(0, 35, 51);
            border-radius: 7px;
        }
        .update_details{
            height: 100%;
            display: flex;
            align-items: center;
            flex-direction: column;
            justify-content: space-around;
            position: relative;

        }
        .btn{
            display: flex;
            align-items: center;
            /* flex-direction: column; */
            justify-content: space-around;
        }
        .update_container h3{
            color: red;
text-align: center;
        }
        .close_icon{
            position: absolute;
            color: while;
            font-size: 35px;
            right: 10px;
            top: 0px;
            cursor: pointer;
        }
        form input{
            font-size: 17px;
            padding-left: 10px;
            background-color: white;
            display: flex;
            height: 30px;
            min-width: 200px;
            border-radius: 3px;
            outline: none;
            border: none;
            margin-top: 5px;
            /* align-items: center; */
            /* flex-direction: column; */
        }
        button[type="submit"] {
            width: 100px;
            display: block;
            text-align: center;
            margin-left: 50%;
            transform: translateX(-50%);
    background-color: rgb(0, 128, 128);
    color: white; /* Add text color to make it visible */
    cursor: pointer;
}

.details p{
    word-wrap: break-word;
}
    </style>
</head>
<body>
<div class="update_container">
    <h3 ><?php echo $update_result; ?></h3>
<div class="update_details">
    <div class="close_icon"><i class="fa-solid fa-circle-xmark"></i></div>
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" id="myForm">
                    <input type="hidden" name="email" value="<?php echo $email; ?>">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo $updated_name; ?>" placeholder="Name"><br><br>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $email; ?>" disabled><br><br>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" value="<?php echo $updated_password; ?>" placeholder="Password"><br><br>
                    <button type="submit" name="submit">Update</button>
                </form>
            </div>

</div>

    <div class="container">
        <div class="upper_part">
            <div class="logo"><span></span></div>
        </div>
        <div class="lower_part">
            <h1>Personal Details</h1>
            <div class="details">
                <p><b>Name:</b> <?php echo $name; ?></p>
                <p><b>Email:</b> <?php echo $email; ?></p>
                <p><b>Password:</b> <?php echo $password; ?></p>
                <div class="btn">
                <button class="update">Update</button>
                <button ><a href="home.php">Go To Home</a></button>
                <button ><a href="session_destroy_logIn.php">Log Out</a></button>
                </div>
                
            </div>
        </div>

    </div>
    <script>
// document.getElementById("myForm").addEventListener("submit", function(event) {
//     event.preventDefault(); // Prevent default form submission
    
//     // Get form data
//     var formData = new FormData(this);
    
//     // Create an XMLHttpRequest object
//     var xhr = new XMLHttpRequest();
    
//     // Configure the request
//     xhr.open("POST", window.location.href, true);
    
//     // Set up a callback function to handle the response
//     xhr.onreadystatechange = function() {
//         if (xhr.readyState === XMLHttpRequest.DONE) {
//             if (xhr.status === 200) {
//                 // Request was successful, handle the response
//                 document.getElementById("response").innerHTML = xhr.responseText;
//             } else {
//                 // Request failed
//                 console.error('Request failed: ' + xhr.status);
//             }
//         }
//     };
    
//     // Send the request with form data
//     xhr.send(formData);
// });






        document.querySelector(".close_icon").addEventListener('click',()=>{
            // alert("shsh");
            document.querySelector(".update_container").style.display="none"
        });
        document.querySelector(".update").addEventListener('click',()=>{
            // alert("shsh");
            
            document.querySelector(".update_container").style.display="block"
        });
    </script>
</body>
</html>