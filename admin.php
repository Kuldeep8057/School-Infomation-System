<?php
session_start();
include 'database.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php"); // Redirect to login page if not logged in or not an admin
    exit();
}
$updateStatusQuery = "UPDATE faculty_data SET status = 'Expired' WHERE status = 'Pending' AND CURDATE() > tedate";
mysqli_query($con, $updateStatusQuery);

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

  <!-- Boxicons CDN Link -->
  <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="dashboard.css">
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href='sidebar.css' rel='stylesheet'>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel || Dasboard</title>
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


  </style>
</head>

<body>
  <div class="sidebar">
    <div class="logo-details">

       <span class="logo_name" style="margin-left:1px"><img width="59" height="55" src="kcmtlogos.jpg" alt="d"/></span> &nbsp;<H5 style="color:#fff;text-align:center;">DEEKSHA</H5>
    </div>
   <ul class="nav-links">
      <li>
        <a href="admin.php"class="active" >
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
        <span class="dashboard">Dashboard</span>
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
  <div class="main-content">
     
       
        <div class="dashboard-container">
          <div class="tab">
            <div class="tab-content">
              <h1>
                <center>Faculty Details</center>
              </h1>
              <div class="content">
                <p>
                  Faculties:
                  <span>
                    <?php
                    // Create connection
                    include 'database.php';
                    //select only all student number whose status is late
                    $sql = "SELECT COUNT(*) as totalUsers FROM usersss WHERE role = 'user'";
                    $result = mysqli_query($con, $sql);
                    $row = $result->fetch_assoc();
                    echo $row["totalUsers"];
                    $entryCount2 = $row["totalUsers"];
                    ?>
                  </span>
                </p>
                <p>
                  Given Allotments: <span>
                    <?php
                    // Create connection
                    include 'database.php';
                    //select only all student number whose status is late
                    $sql = "SELECT COUNT(*) as givenAllotments FROM faculty_data";
                    $result = mysqli_query($con, $sql);
                    $row = $result->fetch_assoc();
                    echo $row["givenAllotments"];
                    $exitCount2 = $row["givenAllotments"];
                    ?>
                  </span>
                </p>
              </div>
            </div>
            <div class="pie-chart">
              <canvas id="myPieChart2" width="300" height="300"></canvas>
              <script>
                // Get the counts from your PHP code
                var lateEntryCount2 = <?php echo $entryCount2; ?>;
                var earlyExitCount2 = <?php echo $exitCount2; ?>;

                // Get the canvas element
                var ctx2 = document.getElementById("myPieChart2").getContext("2d");
                // Create a bar chart
                var myBarChart = new Chart(ctx2, {
                  type: "pie",
                  data: {
                    labels: ["Total Faculties", "Given Allotments"],
                    datasets: [{
                      data: [lateEntryCount2, earlyExitCount2],
                      backgroundColor: ['#1b4965', '#90EE90'],
                      // borderColor: ['black'],
                    }],
                  },
                  options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                      display: true, // Set to true to display the legend
                      position: "bottom",
                    },
                  },
                });
              </script>
            </div>
          </div>
         
          <div class="tab">
            <div class="tab-content">
              <h1>
                <center>Allotment Details</center>
              </h1>
              <div class="content">
                <p>
                  Pending:
                  <span>
                    <?php
                    // Create connection
                    include 'database.php';
                    //select only all student number whose status is late
                    $sql = "SELECT COUNT(*) as pendingUsers FROM faculty_data WHERE status = 'Pending'";
                    $result = mysqli_query($con, $sql);
                    $row = $result->fetch_assoc();
                    echo $row["pendingUsers"];
                    $entryCount1 = $row["pendingUsers"];
                    ?>
                  </span>
                </p>
                <p>
                  Completed: <span>
                    <?php
                    // Create connection
                    include 'database.php';
                    //select only all student number whose status is late
                    $sql = "SELECT COUNT(*) as completedUsers FROM faculty_data WHERE status = 'Completed'";
                    $result = mysqli_query($con, $sql);
                    $row = $result->fetch_assoc();
                    echo $row["completedUsers"];
                    $exitCount1 = $row["completedUsers"];
                    ?>
                  </span>
                </p>
                 <p>
                  Expired: <span>
                    <?php
                    // Create connection
                    include 'database.php';
                    //select only all student number whose status is late
                    $sql = "SELECT COUNT(*) as ExpiredUsers FROM faculty_data WHERE status = 'Expired'";
                    $result = mysqli_query($con, $sql);
                    $row = $result->fetch_assoc();
                    echo $row["ExpiredUsers"];
                    $exitCount2 = $row["ExpiredUsers"];
                    ?>
                  </span>
                </p>
              </div>
            </div>
            <div class="pie-chart">
              <canvas id="myPieChart1" width="300" height="300"></canvas>
              <script>
                // Get the counts from your PHP code
                var lateEntryCount1 = <?php echo $entryCount1; ?>;
                var earlyExitCount1 = <?php echo $exitCount1; ?>;
                 var earlyExitCount2 = <?php echo $exitCount2; ?>;

                // Get the canvas element
                var ctx1 = document.getElementById("myPieChart1").getContext("2d");

                // Create a pie chart
                var myPieChart = new Chart(ctx1, {
                  type: "doughnut",
                  data: {
                    labels: ["Pending", "Completed","Expired"],
                    datasets: [{
                      data: [lateEntryCount1, earlyExitCount1,earlyExitCount2],
                      backgroundColor: ['#ef233c',
                        '#90EE90','#6610f2'],
                      // borderColor: ['black'],
                    }],
                  },
                  options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                      position: "bottom",
                    },
                  },
                });
              </script>
            </div>
          </div>
         
        </div>
        
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