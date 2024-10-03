<?php
include_once 'database.php'; // Include the database connection functions

// Define variables and set to empty values
$firstName = $lastName = $email = $password = $confirmPassword = $phone = $address = $city = $postalCode = $country = "";
$firstNameErr = $lastNameErr = $emailErr = $passwordErr = $confirmPasswordErr = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $firstName = trim($_POST["first_name"]);
    $lastName = trim($_POST["last_name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirmPassword = trim($_POST["confirm_password"]);
    $phone = trim($_POST["phone"]);
    $address = trim($_POST["address"]);
    $city = trim($_POST["city"]);
    $postalCode = trim($_POST["postal_code"]);
    $country = trim($_POST["country"]);

    // Basic validation
    if (empty($firstName)) {
        $firstNameErr = "First name is required";
    }
    if (empty($lastName)) {
        $lastNameErr = "Last name is required";
    }
    if (empty($email)) {
        $emailErr = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    }
    if (empty($password)) {
        $passwordErr = "Password is required";
    }
    if ($password !== $confirmPassword) {
        $confirmPasswordErr = "Passwords do not match";
    }

    // If no validation errors, proceed with the registration
    if (empty($firstNameErr) && empty($lastNameErr) && empty($emailErr) && empty($passwordErr) && empty($confirmPasswordErr)) {
        open_connection(); // Open the database connection

        // Prepare an SQL statement to insert the new customer
        $stmt = $conn->prepare("INSERT INTO Customer (FirstName, LastName, Email, Password, Phone, Address, City, PostalCode, Country) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password for security
        $stmt->bind_param("sssssssss", $firstName, $lastName, $email, $hashedPassword, $phone, $address, $city, $postalCode, $country);

        // Execute the statement and check if the registration was successful
        if ($stmt->execute()) {
            echo "Registration successful! You can now <a href='login.php'>login</a>.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close(); // Close the statement
        close_connection(); // Close the database connection
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .form-container {
            max-width: 500px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-weight: bold;
        }
        input[type="text"], input[type="email"], input[type="password"], input[type="tel"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .error {
            color: red;
            font-size: 0.9em;
        }
        .submit-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #218838;
        }
        .login-link {
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Register</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" value="<?php echo htmlspecialchars($firstName); ?>">
            <span class="error"><?php echo $firstNameErr; ?></span>
        </div>
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" value="<?php echo htmlspecialchars($lastName); ?>">
            <span class="error"><?php echo $lastNameErr; ?></span>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>">
            <span class="error"><?php echo $emailErr; ?></span>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
            <span class="error"><?php echo $passwordErr; ?></span>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password">
            <span class="error"><?php echo $confirmPasswordErr; ?></span>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="tel" name="phone" id="phone" value="<?php echo htmlspecialchars($phone); ?>">
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($address); ?>">
        </div>
        <div class="form-group">
            <label for="city">City</label>
            <input type="text" name="city" id="city" value="<?php echo htmlspecialchars($city); ?>">
        </div>
        <div class="form-group">
            <label for="postal_code">Postal Code</label>
            <input type="text" name="postal_code" id="postal_code" value="<?php echo htmlspecialchars($postalCode); ?>">
        </div>
        <div class="form-group">
            <label for="country">Country</label>
            <input type="text" name="country" id="country" value="<?php echo htmlspecialchars($country); ?>">
        </div>
        <button type="submit" class="submit-btn">Register</button>
    </form>
    <div class="login-link">
        Already have an account? <a href="login.php">Login here</a>.
    </div>
</div>

</body>
</html>