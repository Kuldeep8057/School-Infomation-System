<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php"); // Redirect to login page if not logged in or not an admin
    exit();
}

include('database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $regionId = $_POST['region'];
    $schoolName = $_POST['schoolName'];
    $board = $_POST['board'];

    // Insert the school into the schools table
    $insert_query = "INSERT INTO schools (school_name,board, region_id) VALUES (?,?, ?)";
    $stmt = $con->prepare($insert_query);
    $stmt->bind_param("ssi", $schoolName, $board,$regionId);

    if ($stmt->execute()) {
        echo '<script>
                window.onload = function() {
                    Swal.fire({
                        title: "Success!",
                        text: "School added successfully!",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(function() {
                        window.location.href = "add_schools.php";
                    });
                }
              </script>';
    } else {
        echo '<script>
                window.onload = function() {
                    Swal.fire({
                        title: "Error!",
                        text: "Error adding school: ' . $stmt->error . '",
                        icon: "error",
                        confirmButtonText: "OK"
                    }).then(function() {
                        window.location.href = "add_schools.php";
                    });
                }
              </script>';
    }

    $stmt->close();
    $con->close();
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
  <title>Admin Panel || Add Scholls</title>
   <style>
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

   
   

        .form-group {
            margin-bottom: 20px;
        }

        h2 {
            color: #FF6961; /* Light red */
        }

        label {
            color: #FF6961; /* Light red */
        }

        .form-control {
            border: 1px solid #385170; /* Light red border */
            color: #333;
        }

        .form-control:focus {
            border-color: #385170; /* Darker red on focus */
            box-shadow: 0 0 0 0.2rem rgba(255, 102, 102, 0.25); /* Light red shadow on focus */
        }

        .btn-primary {
            background-color: #385170; /* Light red background */
        }

       
        .alert-success {
            background-color: #FFEBE6; /* Light red background for success message */
            color: #FF6961; /* Light red text for success message */
        }

        .alert-danger {
            background-color: #FFEBE6; /* Light red background for error message */
            color: #FF6961; /* Light red text for error message */
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
        <a href="admin.php" >
          <i class='bx bx-home'></i>
          <span class="links_name">Deeksha Dasboard</span>
        </a>
      </li>
        <li>
        <a href="analytics.php">
          <i class='bx bx-pie-chart-alt'></i>
          <span class="links_name">Allotment Analytics</span>
        </a>
      </li>
        <li>
        <a href="students/upload.php">
          <i class='bx bx-bar-chart'></i>
          <span class="links_name">Student Analytics</span>
        </a>
      </li>
       <li>
        <a href="regi_list.php" >
          <i class='bx bx-calendar-check'></i>
          <span class="links_name">Deeksha Allotments</span>
        </a>
      </li>
      <li>
        <a href="admin_data_report.php">
          <i class='bx bx-book-alt'></i>
          <span class="links_name">Completed Deeksha</span>
        </a>
      </li>
      <li>
       <a href="total_allotment.php">
           <i class='bx bx-clipboard'></i>
          <span class="links_name">Deeksha Status</span>
        </a>
      </li>
         <li>
        <a href="reallotment.php">
                      <i class='bx bx-archive-in'></i>
          <span class="links_name">Re-allotments</span>
        </a>
      </li>
      <!--<li>
        <a href="add_users.php">
           <i class='bx bx-user-plus'></i>
          <span class="links_name">Add Faculty</span>
        </a>
      </li>-->
       <li>
        <a href="add_schools.php" class="active">
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
     
    </ul></div>
  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">Add Schools</span>
      </div>
        <div class="avt dropdown">
        <button class="dropdown-toggle" id="profile-dropdown-toggle">
            <img src="pro_avt.png" alt="Profile Avatar" class="profile-avatar">
        </button>
        <ul class="dropdown-menu" id="profile-dropdown">
            <li><a href="Profile.php?id=<?php echo $_SESSION['id']; ?>">Profile</a></li>
            <li><a href="students/students_data.php">Upload</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    </nav>

    <div class="home-content">
  
        <form action="" method="POST">
            <div class="form-group">
                <label for="region">Select Region:</label>
                <select class="form-control" name="region" id="region" required>
                    <option value="" disabled selected>-- Select Region --</option>
                    <?php
                    include 'database.php';

                    $region_query = "SELECT * FROM regions";
                    $region_result = $con->query($region_query);

                    while ($row = $region_result->fetch_assoc()) {
                        echo "<option value='" . $row['region_id'] . "'>" . $row['region_name'] . "</option>";
                    }

                    $con->close();
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="schoolName">School Name:</label>
                <input type="text" class="form-control" name="schoolName" id="schoolName" required>
            </div>
            <div class="form-group">
                 <label for="schoolName">Board:</label>
                 <Select name="board" class="form-control" required>
                      <option value="" disabled selected>-- Select Board --</option>
                    <option value="U.P. Board">U.P. Board</option>
            <option value="CBSE Board">CBSE Board</option>
            <option value="ICSE Board">ICSE Board</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Add School</button>
        </form>

    </div>
<?php include 'footer.php';?>
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