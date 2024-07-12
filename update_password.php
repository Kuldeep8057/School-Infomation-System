<?php
session_start();
include 'database.php';

$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = $_POST['password'];
    $username = $_SESSION['username'];

    // Update password in the database
    $stmt = $con->prepare("UPDATE usersss SET password = ? WHERE username = ?");
    $stmt->bind_param("ss", $password, $username);
    $stmt->execute();

    // Password updated successfully
    echo "<script>
            window.onload = function() {
                swal({
                    title: 'Password Updated',
                    text: 'Your password has been updated successfully.',
                    icon: 'success'
                }).then(function() {
                    window.location = 'login.php';
                });
            }
          </script>";

    $stmt->close();
    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
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

        input[type="password"],
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
        <h2>Update Password</h2>
        <form action="" method="POST">
            <label for="password">New Password:</label><br>
            <input type="password" id="password" name="password" required><br>
            <input type="submit" value="Update Password">
        </form>
    </div>
</body>
</html>
