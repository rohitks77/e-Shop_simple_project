<?php
session_start();

if (isset($_POST['submit'])) {
    $_SESSION['address']= $_POST['address'];
    header("Location: payment/checkout.php");
    exit(); // Ensure no further code is executed after the redirect
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="billingaddress.css">
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <h2>Shipping Address</h2>
        <!-- <div>
            <label for="fullname">Full Name:</label>
            <input type="text" id="fullname" name="fullname" required>
        </div> -->
        <div class="input-group">
            <select id="country" name="country_code" required>
                
                <option value="+977">+977</option>
                <option value="+975">+91</option>
                <option value="+880">+975</option>
                <option value="+92">+92</option>
                <option value="+93">+93</option>
            </select>
            <input type="tel" id="mobile" name="mobile" placeholder="Mobile Number" required>
        </div>
        
        <div>
            <label for="address">Address:</label>
            <textarea id="address" name="address" rows="4" required></textarea>
        </div>
        <div>
            <label for="city">City:</label>
            <input type="text" id="city" name="city" required>
        </div>
        <div>
            <label for="state">State:</label>
            <input type="text" id="state" name="state" required>
        </div>
        <div>
            <label for="postal_code">Postal Code:</label>
            <input type="text" id="postal_code" name="postal_code" required>
        </div>
        <div>
            <label for="country">Country:</label>
            <select id="country" name="country" required>
                <option value="" disabled selected>Select your country</option>
                <option value="India">India</option>
                <option value="Nepal">Nepal</option>
                <option value="Bhutan">Bhutan</option>
                <option value="Bangladesh">Bangladesh</option>
                <option value="Pakistan">Pakistan</option>
                <option value="Afghanistan">Afghanistan</option>
            </select>
        </div>
        <div>
            <label for="payment">Payment Options:</label>
            <select id="payment" name="payment" required>
                <option value="" disabled selected>Choose a payment option</option>
                <option value="eshewa">e-Shewa</option>
                <option value="khalti">Khalti</option>
                <option value="connectips">Connect IPS</option>
                <option value="mypay">MyPay</option>
                <option value="paypal">PayPal</option>
                <option value="visa">Visa Card/Master Card</option>
                <option value="bitcoins">Bitcoins</option>
            </select>
        </div>
        <button type="submit" name="submit">Continue</button>
    </form>
</body>
</html>
