<?php  
include __DIR__ . '/../database.php'; // Adjust path as needed
session_start(); // Start the session to handle user login information
open_connection();
close_connection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('../images/background.jpg'); /* Use background.jpg */
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            color: black; /* Change text color for better readability */
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
        .Scontainer {
            text-align: center;
            margin: 40px auto;
            max-width: 600px;
            padding: 20px;
            background: rgba(255, 215, 0, 0.8); /* Yellow background with slight opacity */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
        .input-container {
            position: relative;
            margin: 20px 0;
        }
        input, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: rgba(255, 255, 255, 0.8);
            transition: border-color 0.3s;
        }
        input:focus, textarea:focus {
            border-color: #4CAF50;
            outline: none;
        }
        .input-container label {
            position: absolute;
            top: 12px;
            left: 12px;
            color: #888;
            transition: 0.3s;
            pointer-events: none;
        }
        input:focus + label,
        textarea:focus + label,
        input:not(:placeholder-shown) + label,
        textarea:not(:placeholder-shown) + label {
            top: -10px;
            left: 10px;
            font-size: 12px;
            color: #4CAF50;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
    <script>
        function validate() {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const message = document.getElementById('message').value;

            if (!name || !email || !message) {
                alert('All fields are required!');
                return false;
            }

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert('Please enter a valid email address.');
                return false;
            }

            alert('Message sent successfully!');
            return true;
        }
    </script>
</head>
<body>

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

<div class="Scontainer">
    <h2>Get In Touch</h2>
    <h3>Leave your message</h3>
    
    <div class="input-container">
        <input type="text" id="name" placeholder=" " required>
        <label for="name">Your Full Name</label>
    </div>
    <div class="input-container">
        <input type="email" id="email" placeholder=" " required>
        <label for="email">Your Email Address</label>
    </div>
    <div class="input-container">
        <textarea id="message" placeholder=" " required></textarea>
        <label for="message">Your Message Here...</label>
    </div>
    <button class="btn" onclick="validate()">Send Message</button>
</div>

</body>
</html>
