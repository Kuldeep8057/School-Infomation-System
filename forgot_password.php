<?php
session_start();
include 'database.php';

$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];

    // Check if email exists in the database
    $stmt = $con->prepare("SELECT id FROM usersss WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Generate OTP and send it to the user's email
        $otp = mt_rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['username'] = $username;

        // Compose email message
        $subject = 'Your OTP for password reset';
        $message = 'Your OTP is: ' . $otp;

        // Send email (you need to implement this part)
        if (mail($username, $subject, $message)) {
            header("Location: validate_otp.php");
            exit();
        } else {
            $errorMessage = "Failed to send OTP. Please try again.";
        }
    } else {
        $errorMessage = "Email not found in our records.";
    }

    $stmt->close();
    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 100px auto;
            background-color: #f8d7da;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #fff;
            background-color: #dc3545;
            padding: 10px;
            border-radius: 5px;
        }

        form {
            margin-top: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="email"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: none;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #dc3545;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #c82333;
        }

        p.error {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <?php if (!empty($errorMessage)): ?>
            <p class="error"><?php echo $errorMessage; ?></p>
        <?php endif; ?>
        <form action="" method="POST">
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="username" required><br>
            <input type="submit" value="Reset Password">
        </form>
    </div>
</body>
</html>
