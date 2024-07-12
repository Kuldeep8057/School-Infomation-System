<?php
session_start();

include('database.php');

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $department = mysqli_real_escape_string($con, $_POST['department']);
    $role = mysqli_real_escape_string($con, $_POST['role']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $pass = mysqli_real_escape_string($con, $_POST['password']);
    $cpass = mysqli_real_escape_string($con, $_POST['cpassword']);

    $select = mysqli_prepare($con, "SELECT * FROM usersss WHERE username = ?");
    mysqli_stmt_bind_param($select, "s", $username);
    mysqli_stmt_execute($select);
    mysqli_stmt_store_result($select);
    $count = mysqli_stmt_num_rows($select);

    if ($count > 0) {
        echo "<script>
                window.onload = function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Email already exists!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    }).then(function() {
                        window.location.href = 'signup.php';
                    });
                }
              </script>";
    } else {
        if ($pass != $cpass) {
            echo "<script>
                    window.onload = function() {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Confirm password does not match!',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then(function() {
                            window.location.href = 'signup.php';
                        });
                    }
                  </script>";
        } else {
            $query = mysqli_prepare($con, "INSERT INTO usersss(name, department, role, username, password) VALUES (?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($query, "sssss", $name, $department, $role, $username, $pass);

            if (mysqli_stmt_execute($query)) {
                // Send email to admin
                $admin_email = "prahlad.singh.education@gmail.com"; // Replace with the admin email
                $subject = "New User Registration";
                $message = "A new user has registered.\n\nName: $name\nDepartment: $department\nEmail: $username \n\n
                Activate the Account so that User can login.";
                $headers = "From: edunoteshub@prahladsingh.cloud"; // Replace with your from email address

                if (mail($admin_email, $subject, $message, $headers)) {
                    echo "<script>
                            window.onload = function() {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Registration successful! An email has been sent to the admin to activate your account.please note:it may take some time to verify and activate your account.THANK YOU!!!!',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(function() {
                                    window.location.href = 'index.php';
                                });
                            }
                          </script>";
                } else {
                    echo "<script>
                            window.onload = function() {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Registration successful, but failed to send email to admin.',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(function() {
                                    window.location.href = 'index.php';
                                });
                            }
                          </script>";
                }
            } else {
                echo "<script>
                        window.onload = function() {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Registration failed!',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            }).then(function() {
                                window.location.href = 'signup.php';
                            });
                        }
                      </script>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

  <!-- Boxicons CDN Link -->
  <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href='sidebar.css' rel='stylesheet'>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel || Add Faculty</title>
   <style>
      .container {
          padding: 20px;
          background-color: #ffffff;
          border-radius: 8px;
          width: 50%;
          display: flex;
          align-items: center;
          justify-content: center;
          max-width: none;
      }
      .form-container {
          padding: 20px;
          background-color: #ffffff;
          border-radius: 8px;
          width: 100%;
          max-width: none;
      }
      label {
          font-weight: 600;
          color: #ff6666;
      }
      input[type="text"],
      input[type="email"],
      input[type="password"],
      select {
          width: 100%;
          padding: 10px;
          margin: 8px 0;
          display: inline-block;
          border: 1px solid #ccc;
          box-sizing: border-box;
          border-radius: 4px;
          font-size: 16px;
      }
      select {
          cursor: pointer;
      }
      .btn {
          background-color: #ff6666;
          color: #ffffff;
          padding: 15px;
          border: none;
          border-radius: 4px;
          cursor: pointer;
          width: 100%;
      }
      .btn:hover {
          background-color: #ff3333;
      }
      p {
          color: #ff6666;
      }
      a {
          color: #ff6666;
          text-decoration: none;
      }
      a:hover {
          color: #ff3333;
      }
      .message {
          color: #ff6666;
          font-weight: bold;
          margin-bottom: 10px;
      }
      h2 {
          color: #ff6666;
          text-align: center;
      }
  </style>
</head>

<body>
  <div class="container">
        <form class="form-container" action="" method="post" enctype="multipart/form-data">
            <?php
            if (isset($message)) {
                foreach ($message as $msg) {
                    echo '<div class="message">' . $msg . '</div>';
                }
            }
            ?>
            <h3><center><b>KCMT's Deeksha - Signup</b></center></h3>
            <div>
                <label for="name">Name</label>
                <input type="text" name="name" id="name" placeholder="Enter your name." required>
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" name="username" id="email" placeholder="Enter your email." pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" required>
            </div>
            <div>
                <label for="department">Department</label>
                <select id="department" name="department">
                    <option value="ZOOLOGY DEPTT.">ZOOLOGY DEPTT.</option>
                    <option value="BOTANY DEPTT.">BOTANY DEPTT.</option>
                    <option value="BIOTECH.">BIOTECH.</option>
                    <option value="CHEMISTRY DEPTT.">CHEMISTRY DEPTT.</option>
                    <option value="MATHS DEPTT.">MATHS DEPTT.</option>
                    <option value="PHYSICS DEPTT.">PHYSICS DEPTT.</option>
                    <option value="HOME SC. DEPTT.">HOME SC. DEPTT.</option>
                    <option value="EDUCATION DEPTT.">EDUCATION DEPTT.</option>
                    <option value="MANAGEMENT">MANAGEMENT</option>
                    <option value="COMPUTER">COMPUTER</option>
                    <option value="STAFF MEMBERS">STAFF MEMBERS</option>
                </select>
            </div>
            <div>
                <label for="role">Role</label>
                <select id="role" name="role">
                    <option value="user">user</option>
                </select>
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your password." required>
            </div>
            <div>
                <label for="cpassword">Confirm Password</label>
                <input type="password" name="cpassword" id="myInput" placeholder="Re-enter your password." required>
            </div>
            <div>
                <input type="submit" name="submit" value="ADD Now" class="btn">
            </div>
        </form>
    </div>
    <script>
        function myFunction() {
            var x = document.getElementById("myInput");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
<?php include 'footer.php';?>
</body>

</html>
