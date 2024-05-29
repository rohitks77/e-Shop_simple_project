<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "ecommerce");
$output_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["email"])) {
    $email = $_POST["email"];

    // Check if the email exists in the database
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Email exists in the database
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];

        // Generate a random password
        $new_password = generateRandomPassword();

        // Send email with the new password
        $to = $email;
        $subject = "Your New Password";

        $message = "<html><body>";
        $message .= "<h2>Password Reset</h2>";
        $message .= "<p>Hello, $name !</p>";
        $message .= "<p style='color: rgb(130, 72, 130);'>Your password has been successfully reset for your E-Shop account.</p>";
        $message .= "<p>Your new password is: <strong>$new_password</strong></p>"; // Placeholder for new password
        $message .= "<p>If you did not request this change, please contact us immediately.</p>";
        $message .= "<p>Thank you!</p>";
        $message .= "<p>You can visit the owner's website <a href='http://rohitks77.com.np'>here</a>.</p>"; // Link to owner's website
        $message .= "</body></html>";

        $headers = "Content-Type: text/html; charset=UTF-8\r\n";

        if (mail($to, $subject, $message, $headers)) {
            // Update user's password in the database after the email is sent successfully
            $update_sql = "UPDATE users SET password = '$new_password' WHERE email = '$email'";
            if (mysqli_query($conn, $update_sql)) {
                $output_message = "Check your email! We just sent your reset password to your email address. 😊";
                header("Refresh: 7; URL=".'LogIn.php');
            } else {
                $output_message = "Error: Failed to update password. 😌";
            }
        } else {
            $output_message = "Error: Failed to send email, try again. 😌";
        }
    } else {
        // Email does not exist in the database
        $output_message = "Email not found. 😌";
    }
}

function generateRandomPassword($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $password;
}

mysqli_close($conn);
?>




 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
            box-sizing: border-box;
        }
  body{
    height: 90vh;
    width: 100wh;
display: flex;
align-items: center;
justify-content: center;

  }
  .forget_password_div{
    min-height: 400px;
    min-width: 350px;
    width: 35%;
    max-width: 600px;
    border-radius: 5px;
    text-align: center;
    color: white;
    background-color: rgb(0, 35, 51);
    /* height: 300px; */
    padding: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
   
  }
  a{
    text-decoration: none;
  }
  .forget_password_div form{
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 20px;
  }
  .forget_password_div form input{
    width: 100%;
    height: 40px;
    outline: none;
    border: none;
    border-radius: 4px;
    padding-left: 10px;
font-size: 20px;

  }
  button{
    width: 100%;
    height: 40px;
    outline: none;
    border: none;
    border-radius: 4px;
    font-size: 20px;
    font-weight: 600;
    cursor: pointer;
    
  }

    </style>
 </head>
 <body>
 <div class="forget_password_div">
 <div class="top_part"><a href="index.php"><img src="images/e_shop.png" width="160px" alt=""></a></div>
 <!-- Forgot Password Form -->
<form id="forgot-password-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
 <h2>Forget password ?</h2>
 <input type="email" name="email" id="email" placeholder="Enter your email" required>
 <button type="submit" name="submit">Reset Password</button>
 <div class="bottom">
 <h3 class="output" style="color: red;"> <?php echo $output_message; ?>  </h3>
 <h3>Don you remember the password ?<br>
  <a href="LogIn.php">Log In</a></h3>
 </div>
 
</form>
</div>
<script>
        // JavaScript code to hide the message after 5 seconds
        setTimeout(function() {
            document.querySelector('.output').style.display = 'none';
        }, 10000); // 5 seconds
    </script>
 </body>
 </html>