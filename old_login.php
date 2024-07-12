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
    $stmt = $con->prepare("SELECT id, username, role FROM usersss WHERE username = ? AND password = ? AND role = ?");
    $stmt->bind_param("sss", $username, $password, $role);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($dbUserId, $dbUsername, $dbRole);
    $stmt->fetch();

    if ($stmt->num_rows > 0) {
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Deeksha || Login</title>
  <link href="https://fonts.googleapis.com/css?family=Asap" rel="stylesheet">
  <style>
    body {
      background-color:  #FF6961;;
      font-family: "Asap", sans-serif;
      margin: 0;
      padding: 0;
    }

    .login {
      overflow: hidden;
      background-color: white;
      padding: 40px 30px 30px 30px;
      border-radius: 10px;
      position: absolute;
      top: 50%;
      left: 50%;
      width: 80%; /* Adjusted width for mobile */
      max-width: 400px; /* Set a maximum width */
      transform: translate(-50%, -50%);
      transition: transform 300ms, box-shadow 300ms;
      box-shadow: 5px 10px 10px rgba(2, 128, 144, 0.2);
    }

    .login::before, .login::after {
      content: "";
      position: absolute;
      width: 600px;
      height: 600px;
      border-top-left-radius: 40%;
      border-top-right-radius: 45%;
      border-bottom-left-radius: 35%;
      border-bottom-right-radius: 40%;
      z-index: -1;
    }

    .login::before {
      left: 40%;
      bottom: -130%;
      background-color: rgba(69, 105, 144, 0.15);
      animation: wawes 6s infinite linear;
    }

    .login::after {
      left: 35%;
      bottom: -125%;
      background-color: rgba(2, 128, 144, 0.2);
      animation: wawes 7s infinite;
    }

    .login > input {
      font-family: "Asap", sans-serif;
      display: block;
      border-radius: 5px;
      font-size: 16px;
      background: white;
      width: 100%;
      border: 0;
      padding: 10px 10px;
      margin: 15px -10px;
    }

    .login > button {
      font-family: "Asap", sans-serif;
      cursor: pointer;
      color: #fff;
      font-size: 16px;
      text-transform: uppercase;
      width: 80px;
      border: 0;
      padding: 10px 0;
      margin-top: 10px;
      margin-left: -5px;
      border-radius: 5px;
      background-color: #f45b69;
      transition: background-color 300ms;
    }

    .login > button:hover {
      background-color: #f24353;
    }

    .login__check {
      display: flex;
      column-gap: 0.5rem;
      align-items: center;
      color: red;
    }

    .login__check-input {
      appearance: none;
      width: 16px;
      height: 16px;
      border: 2px solid hsl(244, 4%, 36%);
      background-color: hsla(244, 16%, 92%, 0.2);
      border-radius: 0.25rem;
    }

    .login__check-input:checked {
      background: hsl(244, 75%, 57%);
    }

    .login__check-input:checked::before {
      content: "✔️";
      display: block;
      color: #fff;
      font-size: 0.75rem;
      transform: translate(1.5px, -2.5px);
    }

    .login__check-label {
      font-size: .9rem;
      color: black;
      font-weight: 600;
    }
    .forgot-password {
      text-align: center;
      margin-top: 15px;
    }

    .forgot-password a {
      text-decoration: none;
      color: #333;
    }

    @media screen and (max-width: 600px) {
      .login {
        width: 90%; /* Adjusted width for smaller screens */
      }
    }

    @keyframes wawes {
      from {
        transform: rotate(0);
      }
      to {
        transform: rotate(360deg);
      }
    }
  </style>
</head>
<body>
  <!-- partial:index.partial.html -->
  <form action="" method="POST" class="login">
    <input style="border:1.5px solid black;" type="text" placeholder="Username or Email" name="username">
    <input style="border:1.5px solid black;" type="password" placeholder="Password"  name="password">
    <div class="login__check">
      <div>
        <input id="check1" type="radio" name="role" value="admin" required >
        <label for="check1" class="login__check-label">Admin</label>
      </div>
      <div>
        <input id="check2" type="radio" name="role" value="user" required>
        <label for="check2" class="login__check-label">User</label>
      </div>
    </div>
    <button type="submit" value="login">Login</button>

  </form>
  <!-- Display error message in a card -->
  <?php if (!empty($errorMessage)) : ?>
    <div style="max-width: 400px; margin: 20px auto; padding: 15px; border: 1px solid red; border-radius: 5px; background-color: #ffebeb; text-align: center; color: red;">
      <?php echo htmlspecialchars($errorMessage); ?>
    </div>
  <?php endif; ?>
  <!-- partial -->

</body>
</html>