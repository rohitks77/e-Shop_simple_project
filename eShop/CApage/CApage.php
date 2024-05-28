
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="CApage/CApage.css">
    <style>
        
.team-section {
    text-align: center;
    padding: 50px 20px;
    padding-top: 0px;
    z-index: 1;
}

.team-section h2 {
    font-size: 2.5em;
    margin-bottom: 20px;
    color: #FFC0CB;
    text-align: center;
    text-shadow: 2px 2px #000;
}

.team-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
}

.team-member {
    background-color: #3C4F58;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.3);
    overflow: hidden;
    max-width: 300px;
    width: 100%;
    text-align: left;
    transition: transform 0.3s;
}

.team-member:hover {
    z-index: 1;
    transform: scale(1.05);
}

.team-member img {
    width: 100%;
    height: 250px; /* Fixed height for images */
    object-fit: cover; /* Ensure images cover the area without distortion */
    object-position: top; /* Crop images from the top */
    display: block;
}

.team-member h3 {
    text-align: center;
    font-size: 1.5em;
    margin: 10px 0;
    padding: 0 10px;
    color: #FFC0CB;
}

.team-member p {
    font-size: 1em;
    padding: 0 10px 10px;
    color: #A9CCE3;
}

@media (max-width: 768px) {
    .team-container {
        flex-direction: column;
        align-items: center;
    }
}


    </style>
</head>
<body>
<section class="about" id="about">
    <h2>About Us</h2>
    <p>Welcome to e-Shop, your number one source for all electronic devices. We're dedicated to providing you the best of electronics, with a focus on dependability, customer service, and uniqueness.</p>
    <p>Founded in 2024 , e-Shop has come a long way from its beginnings in janakpur. When _____ first started out, their passion for providing the best equipment for their fellow tech enthusiasts drove them to start their own business.</p>
    <p>We hope you enjoy our products as much as we enjoy offering them to you. If you have any questions or comments, please don't hesitate to contact us.</p>
</section>
<section class="team-section">
        <h2>Our Team Members</h2>
        <div class="team-container">
            <div class="team-member">
                <img src="images/rks.png" alt="Guy Hawkins">
                <h3>Rohit Kumar sah</h3>
                <p>
                    “Together, we challenge ourselves for a better tomorrow by meaningful designs that help live our best life and maintain lasting relevance.”
                </p>
            </div>
            <div class="team-member">
                <img src="images/prem_image.jpg" alt="Jenny Wilson">
                <h3>Prem Lal Khatbe</h3>
                <p>“Contemporary design and well-made products are things that we think everybody should be able to have. It’s the reason we do what we do.”</p>
            </div>
            <div class="team-member">
                <img src="images\rafique_image.jpg" alt="Bessie Cooper">
                <h3>Rafik Khan</h3>
                <p>“Our collection is ever-evolving. Yet, it remains consistently relatable and accessible. Our purpose is to inspire and help create the look you want.”</p>
            </div>
            <div class="team-member">
                <img src="images/radhika_image.jpg" alt="Team Member">
                <h3>Radhika Yadav</h3>
                <p>“Quality and innovation are at the core of everything we do. We believe everyone deserves access to well-designed and thoughtfully crafted products. This principle drives our passion and creativity each day”</p>
            </div>
        </div>
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