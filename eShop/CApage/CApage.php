<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="CApage/CApage.css">
</head>
<body>
<section class="about" id="about">
    <h2>About Us</h2>
    <p>Welcome to e-Shop, your number one source for all electronic devices. We're dedicated to providing you the best of electronics, with a focus on dependability, customer service, and uniqueness.</p>
    <p>Founded in 2024 , e-Shop has come a long way from its beginnings in janakpur. When _____ first started out, their passion for providing the best equipment for their fellow tech enthusiasts drove them to start their own business.</p>
    <p>We hope you enjoy our products as much as we enjoy offering them to you. If you have any questions or comments, please don't hesitate to contact us.</p>
</section>

<section class="contact" id="contact">
    <h2>Contact Us</h2>
    <form action="send_message.php" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="message">Message:</label>
        <textarea id="message" name="message" required></textarea>
        
        <button type="submit">Send Message</button>
    </form>
</section>

<footer>
<p>&copy; 2024 e-Shop. All rights reserved.</p>
</footer>

</body>
</html>