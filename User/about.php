<?php  
include '../database.php'; // Adjusted path to database.php
session_start(); // Start the session to handle user login information
open_connection();

// Optionally fetch any relevant information from the database, if needed
close_connection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: white;
        }
        .background {
            position: fixed; /* Make background fixed */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('../images/background.jpg');
            background-size: cover;
            background-position: center;
            filter: blur(8px); /* Apply blur effect */
            z-index: -1; /* Send to back */
        }
        .logo {
            position: absolute;
            top: 20px;
            left: 20px;
            width: 300px;
            z-index: 10;
        }
        .menu {
            text-align: center;
            background-color: rgba(51, 51, 51, 0.8);
            padding: 10px;
        }
        .menu a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            margin: 0 10px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .menu a:hover {
            background-color: #575757;
        }
        .hero {
            height: 60vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .hero h1 {
            font-size: 3em;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
        }
        .hero p {
            font-size: 1.5em;
            margin-top: 10px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7);
        }
        .content {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background-color: rgba(255, 255, 0, 0.9); /* Yellow background for container */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            text-align: left;
        }
        h2 {
            color: #4CAF50; /* Color for headings */
            margin-top: 20px;
        }
        p {
            line-height: 1.6;
        }
    </style>
</head>
<body>

<div class="background"></div> <!-- Blurred background -->

<img src="images/logo.png" alt="Logo" class="logo"> <!-- Your logo image -->

<div class="menu">
    <a href="userdashboard.php">Home</a>
    <a href="contact.php">Contact Us</a>
    <a href="about.php">About Us</a>
    <?php if (isset($_SESSION['customer_id'])): ?>
        <span class="welcome-message">Welcome, <?php echo htmlspecialchars($_SESSION['customer_name']); ?>!</span>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a>
    <?php endif; ?>
</div>

<div class="hero">
    <h1>About Us</h1>
    <p>Learn more about our mission and values.</p>
</div>

<div class="content">
    <h2>Our Mission</h2>
    <p>At [Your Website Name], our mission is to provide high-quality products that enhance your life. We believe in delivering exceptional value, top-notch customer service, and a seamless shopping experience.</p>

    <h2>Our History</h2>
    <p>Founded in [Year], [Your Website Name] started with a simple idea: to offer [describe the core concept of your business]. Over the years, we have expanded our offerings and built a loyal community of customers who trust us for their needs.</p>

    <h2>Meet Our Team</h2>
    <p>Our team is made up of passionate individuals who are dedicated to making your shopping experience unforgettable. From our customer service representatives to our logistics experts, everyone plays a vital role in our success.</p>

    <h2>Why Choose Us?</h2>
    <ul>
        <li>Quality Products: We handpick the best products to ensure you receive only the finest.</li>
        <li>Exceptional Support: Our customer service team is here to assist you at every step.</li>
        <li>Community Driven: We believe in giving back to our community and supporting local initiatives.</li>
    </ul>

    <h2>Join Us</h2>
    <p>Thank you for choosing [Your Website Name]. We invite you to explore our products and become a part of our growing community!</p>
</div>

</body>
</html>
