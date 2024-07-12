<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php"); // Redirect to login page if not logged in or not an admin
    exit();
}

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
                        window.location.href = 'add_users.php';
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
                            window.location.href = 'add_users.php';
                        });
                    }
                  </script>";
        } else {
            $query = mysqli_prepare($con, "INSERT INTO usersss(name, department, role, username, password) VALUES (?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($query, "sssss", $name, $department, $role, $username, $pass);

            if (mysqli_stmt_execute($query)) {
                echo "<script>
                        window.onload = function() {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Registered successfully!',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(function() {
                                window.location.href = 'add_users.php';
                            });
                        }
                      </script>";
            } else {
                echo "<script>
                        window.onload = function() {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Registration failed!',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            }).then(function() {
                                window.location.href = 'add_users.php';
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel || Add Faculty</title>
   <style>
  
   .container {
              padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            width: 100%;
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
        
        
        
        
        .dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-toggle {
    background-color: transparent;
    border: none;
    cursor: pointer;
    padding: 8px 16px;
}

.dropdown-menu {
    display: none;
    position: absolute;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    z-index: 1;
    list-style-type: none;
    padding: 0;
}

.dropdown-menu li {
    padding: 8px 16px;
}

.dropdown-menu li:hover {
    background-color: #f2f2f2;
}

.dropdown:hover .dropdown-menu {
    display: block;
}
.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-toggle {
    background-color: transparent;
    border: none;
    cursor: pointer;
    padding: 0;
}

.profile-avatar {
    width: 40px; /* Adjust according to your design */
    height: 40px; /* Adjust according to your design */
    border-radius: 50%; /* Makes the image round */
}

.dropdown-menu {
    display: none;
    position: absolute;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    z-index: 1;
    list-style-type: none;
    padding: 0;
}

.dropdown-menu li {
    padding: 8px 16px;
}

.dropdown-menu li:hover {
    background-color: #f2f2f2;
}

.dropdown:hover .dropdown-menu {
    display: block;
}

    
  </style>
</head>

<body>
  <div class="sidebar">
    <div class="logo-details">

       <span class="logo_name" style="margin-left:1px"><img width="59" height="55" src="kcmtlogos.jpg" alt="d"/></span> &nbsp;<H5 style="color:#fff;text-align:center;">DEEKSHA</H5>
    </div>
   <ul class="nav-links">
      <li>
        <a href="admin.php">
          <i class='bx bx-home'></i>
          <span class="links_name">Admin Dasboard</span>
        </a>
      </li>
        <li>
        <a href="analytics.php">
          <i class='bx bx-pie-chart-alt'></i>
          <span class="links_name">Analytics</span>
        </a>
      </li>
       <li>
        <a href="regi_list.php" >
          <i class='bx bx-calendar-check'></i>
          <span class="links_name">Give Allotments</span>
        </a>
      </li>
      <li>
        <a href="admin_data_report.php">
          <i class='bx bx-book-alt'></i>
          <span class="links_name">Completed Allotment</span>
        </a>
      </li>
      <li>
       <a href="total_allotment.php">
           <i class='bx bx-clipboard'></i>
          <span class="links_name">Total Given Allotment</span>
        </a>
      </li>
         <li>
        <a href="reallotment.php">
                      <i class='bx bx-archive-in'></i>
          <span class="links_name">Re-allotments</span>
        </a>
      </li>
      <li>
        <a href="add_users.php"class="active">
           <i class='bx bx-user-plus'></i>
          <span class="links_name">Add Faculty</span>
        </a>
      </li>
       <li>
        <a href="add_schools.php">
           <i class='bx bx-plus'></i>
          <span class="links_name">Add Schools</span>
        </a>
      </li>
       <li>
        <a href="all_users.php" >
                      <i class='bx bx-group'></i>
          <span class="links_name">User Status</span>
        </a>
      </li>
      <li>
        <a href="school_info.php">
           <i class='bx bx-info-circle'></i>
          <span class="links_name">School Info</span>
        </a>
      </li>
      
      
    </ul>
  </div>
  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">Add Faculties</span>
      </div>
      <div class="avt dropdown">
        <button class="dropdown-toggle" id="profile-dropdown-toggle">
            <img src="pro_avt.png" alt="Profile Avatar" class="profile-avatar">
        </button>
        <ul class="dropdown-menu" id="profile-dropdown">
            <li><a href="Profile.php?id=<?php echo $_SESSION['id']; ?>">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    </nav>

    <div class="home-content">
<div class="container">
        <form class="form-container" action="" method="post" enctype="multipart/form-data">
            <?php
            if (isset($message)) {
                foreach ($message as $msg) {
                    echo '<div class="message">' . $msg . '</div>';
                }
            }
            ?>
            
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
                    <option value="admin">admin</option>
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
    </div>
<footer class="footer mt-auto py-3">
            <div class="container text-center">
                <span class="text-muted">Developed By Prahlad Singh & Kuldeep Gangwar</span>
            </div>
            </footer>
  </section>
  
  <script>
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".sidebarBtn");
    sidebarBtn.onclick = function() {
      sidebar.classList.toggle("active");
      if (sidebar.classList.contains("active")) {
        sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
      } else
        sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
    }
  </script>
</body>

</html>