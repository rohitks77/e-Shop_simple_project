<?php

session_start();
// session_destroy();

$conn = mysqli_connect("localhost", "root","", "ecommerce");
// Check if both email and password are provided
$login_success= "";
$login_failed="";
$usercheck="";
if(isset($_POST['submit'])){
    $email= $_SESSION['email']= $_POST['email'];
    $password=$_SESSION['password']=$_POST['password'];
    


if (!empty($email) && !empty($password)) {
    // Fetch user based on email
    $selectSql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $selectSql);
    if (mysqli_num_rows($result) > 0) {
        // User found, check password
        $row = mysqli_fetch_assoc($result);
        if ($row['password'] == $password) {
            $_SESSION['user_id']=$row['id'];
            $login_success = "Login granted sucessfully !";
        //    redirect to the home page 
        $url = 'home.php'; // Replace this with your desired URL
        $delay = 0; // Delay in seconds

        header("refresh:$delay;url=$url");
        exit; // To prevent further execution of the script
        } else {
        //    echo"Incorrect password";
            $login_failed= "Incorrect password";
        }
    } else{
        $usercheck="User not found ! please create account";
    }
    
}
}
// echo "password is: ".$email,$password;
mysqli_close($conn); // Close the connection
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
            align-items: center;
            justify-content: center;
            height: 95vh;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 40%;
            max-width: 500px;
            min-width: 320px;
            min-height: 400px;
            /* height: 70%; */
            border-radius: 7px;
            padding: 10px;
            background-color: rgb(0, 35, 51);
            color: white;
            /* margin: 10px; */
        }
        .container h3{
            text-align: center;
        }
a{
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
        }

        .form_fillup input {
            background-color: transparent;
           color: white;
           
            /* padding-left: 20px; */
            font-size: 17px;
            height: 30px;
            /* border-radius: 7px; */
            outline: none;
            border: 0;
            border-bottom: 2px solid rgb(100, 70, 20);
            /* border: 1px solid; */
            width: 70%;
            min-width: 250px;
            margin-top: 10px;

        }

        form button {
            width: 68%;
            min-width: 270px;
            border-radius: 7px;
            border: none;
            margin-top: 10px;
            margin-bottom: 10px;
            /* width: 100%; */
            height: 35px;
            cursor: pointer;
        }
        form button:hover{
            background-color: rgb(214, 219, 224);
        }
        .terms_condition{
            text-align: center;
            padding: 0px 20px 0px 20px;
            opacity: 80%;
            /* background-color: red; */
        }
        p{
            text-align: center;
            margin-top: -10px;
            /* color: red; */
        }
        a{
            /* color: rgb(250, 189, 5); */
        }
    </style>
</head>
<script>

    // After 5 seconds, hide the message
    setTimeout(function(){
        document.getElementById("login_failed_message").style.display = "none";
        document.getElementById("usercheck").style.display = "none";
        

    }, 5000); // 5000 milliseconds = 5 seconds
</script>
<body>
    



    <div class="container">
        <h3 style="color: red;"><?php echo $login_success;
         echo "<span id='login_failed_message'>$login_failed</span>"; // Display the message
         echo "<span id='usercheck'>$usercheck</span>"; // Display the message
          ?></h3>
        <div class="top_part"><a href="index.php"><img src="e_shop.png" width="160px" alt=""></a></div>
        <div class="bottom_part">
            <h1>Log In<Inp></Inp></h1>
            <form  method="post" action="LogIn.php">
                <div class="form_fillup">

                    <input type="email" name="email" placeholder="Email" required  >
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button name="submit">Submit</button>
            </form>
        </div>
        <div class="No_account">
            <h3>Don't have an account? <a href="SignUp.php">Sign Up</a></h3>
            <p>Reset your password ? <a href="resetpassword.php">Click here</a></hp>
        </div>
        </div>
</body>

</html>