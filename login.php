<?php
include_once 'database.php'; // Include the database connection file

// Start the session to store user login information
session_start();

// Define variables and set to empty values
$email = $password = "";
$emailErr = $passwordErr = $loginErr = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Basic validation
    if (empty($email)) {
        $emailErr = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    }
    if (empty($password)) {
        $passwordErr = "Password is required";
    }

    // If no validation errors, proceed with checking credentials
    if (empty($emailErr) && empty($passwordErr)) {
        open_connection(); // Open the database connection

        // Prepare an SQL statement to fetch the customer with the given email
        $stmt = $conn->prepare("SELECT CustomerID, FirstName, LastName, Email, Password FROM Customer WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if a customer with the provided email exists
        if ($result->num_rows == 1) {
            // Fetch the customer data
            $customer = $result->fetch_assoc();

            // Verify the provided password with the hashed password from the database
            if (password_verify($password, $customer['Password'])) {
                // If password is correct, store user data in the session
                $_SESSION['customer_id'] = $customer['CustomerID'];
                $_SESSION['customer_name'] = $customer['FirstName'] . " " . $customer['LastName'];

                // Redirect the user to a protected page (e.g., dashboard.php)
                header("Location: User/userdashboard.php");
                exit();
            } else {
                $loginErr = "Invalid email or password";
            }
        } else {
            $loginErr = "Invalid email or password";
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
    <title>Login</title>
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
        input[type="email"], input[type="password"] {
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
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #0056b3;
        }
        .register-link {
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Login</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
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
        <span class="error"><?php echo $loginErr; ?></span>
        <button type="submit" class="submit-btn">Login</button>
    </form>
    <div class="register-link">
        Don't have an account? <a href="registration.php">Register here</a>.
    </div>
</div>

</body>
</html>
