<?php
// Start the session to access session variables
session_start();
include 'database.php';

// Function to sanitize input data
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}



$id = $_SESSION['id'];
$error_message = "";

// Retrieve user ID from the URL parameter
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve user details based on the user ID
    $query = "SELECT * FROM usersss WHERE id = $id";
    $result = mysqli_query($con, $query);

    // Process the query result
    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Sanitize input data
            $password = sanitizeInput($_POST['password']);
            $confirm_password = sanitizeInput($_POST['confirm_password']);

            // Check if password and confirm password match
            if ($password === $confirm_password) {
                // Update user's password in the database
                $update_query = "UPDATE usersss SET password = '$password' WHERE id = $id";
                if (mysqli_query($con, $update_query)) {
                    $success_message = "Password updated successfully!";
                } else {
                    $error_message = "Error updating password: " . mysqli_error($con);
                }
            } else {
                $error_message = "Passwords do not match!";
            }
        }
    } else {
        // Handle error if user not found
        $error_message = "User not found!";
    }
} else {
    // Handle error if user ID parameter is missing
    $error_message = "User ID parameter is missing!";
}

// Close the database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
    <!-- SweetAlert JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <style>
        body {
            background-color: #f9f9f9; /* Light red background */
            color: #333; /* Dark text color */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #ffcccc; /* Light red header background */
            color: #333; /* Dark header text color */
            padding: 10px;
        }

        .container {
            background-color: #fff; /* White container background */
            padding: 20px;
            margin: 20px auto;
            max-width: 600px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Light shadow */
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc; /* Light gray border */
            border-radius: 5px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            background-color: #ff6666; /* Light red button background */
            color: #fff; /* White button text color */
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #ff4d4d; /* Darker red on hover */
        }

        .error {
            color: #ff0000; /* Red text color for error messages */
        }

        .success {
            color: #006600; /* Green text color for success messages */
        }
    </style>
</head>
<body>
    <h1><center>Profile</center></h1>
    <div class="container">
        <?php if (isset($user)): ?>
            <p>Name: <b><?php echo $user['name']; ?></b></p>
            <p>Department: <b><?php echo $user['department']; ?></b></p>
            <p>Email: <b><?php echo $user['username']; ?></b></p>
            <p>Role: <b><?php echo $user['role']; ?></b></p>
            <!-- Add other user details here -->

            <form method="post" action="">
                <div>
                    <label for="password">New Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div>
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit">Update Password</button>
            </form>

            <?php if (!empty($error_message)): ?>
                <script>
                    // Display error message using SweetAlert
                    swal("Error", "<?php echo $error_message; ?>", "error");
                </script>
            <?php endif; ?>
            <?php if (!empty($success_message)): ?>
                <script>
                    // Display success message using SweetAlert
                    swal("Success", "<?php echo $success_message; ?>", "success");
                </script>
            <?php endif; ?>
        <?php else: ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>