<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php"); // Redirect to login page if not logged in or not an admin
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
   <link href='sidebar.css' rel='stylesheet'>
  <!-- Boxicons CDN Link -->
  <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel || Registered Faculty</title>
   <style>
  

        .container {
           
            background-color: #fff;
           
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
              display: flex;
    flex-wrap: wrap;
    gap: 20px; /* Adjust the gap between the cards */
        }

        h1, h2 {
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }


.card {
    flex: 1 1 calc(50% - 20px); /* Adjust the width of each card */
    margin-bottom: 20px;
     border: 2px solid;  /* Light red border */
    border-radius: 8px;
    overflow: hidden;
    background-color: #9fd3c7; /* Light red background color */
}

.card-body {
    padding: 20px;
}

.card-title {
    font-size: 1.2rem;
    color: #385170; /* Dark red text color */
    margin-bottom: 10px;
}

.card-text {
    margin-bottom: 10px;
    font-weight: bold;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #385170; /* Dark red background color */
    color: #fff;
    text-decoration: none;
    border-radius: 4px;
    transition: background-color 0.3s ease-in-out;
}

.btn:hover {
    background-color: #ff3333; /* Darker red on hover */
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
        <a href="regi_list.php" class="active" >
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
        <span class="dashboard">Deeksha Allotments</span>
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
    <div class="container">

        <form method="GET" action="regi_list.php">
            <div style="margin-bottom: 20px;">
                <label for="departmentSelect">Select Faculty by Department:</label>
                <select style="padding: 8px;" id="departmentSelect" name="selected_department">
                    <option value="">Select a Department</option>

                    <?php
                    include 'database.php'; // Include the database connection

                    $sql = "SELECT DISTINCT department FROM usersss";
                    $result = $con->query($sql);

                    $selectedDepartment = isset($_GET['selected_department']) ? $_GET['selected_department'] : '';

                    while ($row = $result->fetch_assoc()) {
                        $department = $row["department"];
                        $selected = ($department === $selectedDepartment) ? 'selected' : '';
                        echo "<option value='$department' $selected>$department</option>";
                    }

                    $con->close();
                    ?>
                </select>
            </div>
            <button style="padding: 10px 20px; background-color: #385170; /* Dark red background color */ color: #fff; border: none; border-radius: 4px; cursor: pointer;" type="submit">Search</button>
        </form>

        <?php
        include 'database.php';

        if (isset($_GET['selected_department'])) {
            $selectedDepartment = $_GET['selected_department'];

           $sql = "SELECT * FROM usersss WHERE department = '$selectedDepartment' AND role = 'user'";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                echo '<h2>Search Results in ' . $selectedDepartment . ' Department</h2>';

                while ($row = $result->fetch_assoc()) {
        ?>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">User ID: <?php echo $row["id"]; ?></h5>
                <p class="card-text">Name: <?php echo $row["name"]; ?></p>
                <p class="card-text">Department: <?php echo $row["department"]; ?></p>
                  <p class="card-text">Role: <?php echo $row["role"]; ?></p>
                <a href="allotment.php?id=<?php echo $row["id"]; ?>" class="btn">Allotment</a>
                <!-- Add the delete icon -->
    <!--<a href="delete_user.php?id=<?php echo $row["id"]; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">-->
    <!--    <i class="bx bx-trash"></i>Delete-->
    <!--</a>-->
            </div>
        </div>
        <?php
                }
            } else {
                echo "<p>No users found in the selected department.</p>";
            }
        }

       $sql = "SELECT * FROM usersss WHERE role = 'user'";
        $result = $con->query($sql);

        if ($result->num_rows > 0 && !isset($_GET['selected_department'])) {
            echo '<h2>All Faculties</h2>';

            while ($row = $result->fetch_assoc()) {
        ?>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">User ID: <?php echo $row["id"]; ?></h5>
                <p class="card-text">Name: <?php echo $row["name"]; ?></p>
                <p class="card-text">Department: <?php echo $row["department"]; ?></p>
                <p class="card-text">Role: <?php echo $row["role"]; ?></p>
                <a href="allotment.php?id=<?php echo $row["id"]; ?>" class="btn">Allotment</a>
                     <!-- Add the delete icon -->
  <!--  <a href="delete_user.php?id=<?php echo $row["id"]; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">
        <i class="bx bx-trash"></i>Delete
    </a>-->
            </div>
        </div>
        <?php
            }
        } elseif ($result->num_rows === 0 && !isset($_GET['selected_department'])) {
            echo "<p>No users found.</p>";
        }

        $con->close();
        ?>
    </div>
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