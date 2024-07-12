<?php
session_start();
error_reporting(0);

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin.php");
    } elseif ($_SESSION['role'] === 'user') {
        header("Location: user_dash.php");
    }
    exit();
}

$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle form submission
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Establish a database connection (replace with your actual database credentials)
    include 'database.php';

    // Securely hash the password (replace with a better hashing algorithm in production)

    // Prepare and execute a query
    $stmt = $con->prepare("SELECT id, username, role, status FROM usersss WHERE username = ? AND password = ? AND role = ?");
    $stmt->bind_param("sss", $username, $password, $role);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($dbUserId, $dbUsername, $dbRole, $dbStatus);
    $stmt->fetch();

    if ($stmt->num_rows > 0) {
        // Check if the user's status is active
        if ($dbStatus === 'active') {
            // Successful login
            $_SESSION['id'] = $dbUserId;
            $_SESSION['username'] = $dbUsername;
            $_SESSION['role'] = $dbRole;
            if ($dbRole === 'admin') {
                header("Location: admin.php");
            } elseif ($dbRole === 'user') {
                header("Location: user_dash.php");
            }
        } else {
            // User is inactive
            $errorMessage = "Your account is inactive. Please contact the administrator.";
        }
    } else {
        // Invalid credentials
        $errorMessage = "Invalid username, password, or role.";
    }

    $stmt->close();
    $con->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>KCMT's Deeksha</title>
  <link rel="stylesheet" href="./style.css">
</head>
<body>
<h2>KCMT's Deeksha</h2>
<div class="container" id="container">
    <div class="form-container sign-up-container">
        <form action="" method="POST">
            <h1>Admin Login</h1>
            <input type="hidden" name="role" value="admin">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <a href="forgot_password.php" id="forgotPassword">Forgot Password?</a>
            <!-- Link to signup page -->
            <a href="signup.php" id="signUpLink">Sign Up</a>
        </form>
    </div>
    <div class="form-container sign-in-container">
        <form action="" method="POST">
            <h1>Faculty Login</h1>
            <input type="hidden" name="role" value="user">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <a href="forgot_password.php" id="forgotPassword">Forgot Password?</a>
            <!-- Link to signup page -->
            <a href="signup.php" id="signUpLink">Sign Up</a>
        </form>
    </div>
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h1>Faculty Login</h1>
                <p>To login as a Faculty, please click the button below</p>
                <button class="ghost" id="signIn">Login</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h1>Admin Login</h1>
                <p>To login as an Admin, please click the button below</p>
                <button class="ghost" id="signUp">LogIn</button>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($errorMessage)) : ?>
    <div style="max-width: 400px; margin: 20px auto; padding: 15px; border: 1px solid red; border-radius: 5px; background-color: #ffebeb; text-align: center; color: red;">
        <?php echo htmlspecialchars($errorMessage); ?>
    </div>
<?php endif; ?>

<script src="./script.js"></script>
</body>
</html>
