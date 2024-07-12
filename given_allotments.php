<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php"); // Redirect to login page if not logged in or not an admin
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  
  <!-- Boxicons CDN Link -->
  <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
 <link href='sidebar.css' rel='stylesheet'>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Faculty Panel || Given Allotments</title>
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


 
      
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #dee2e6;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #a2a8d3;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #fff;
        }

        tr:nth-child(odd) {
            background-color: #e7eaf6;
        }
          .card-link {
            text-decoration: none;
            color: #ff6666;
            border: 2px solid #ff6666;
            padding: 8px 12px;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
        }

        .card-link:hover {
            background-color: #ff6666;
            color: #fff;
        }
        h1 {
            color: #ff6666;
            margin-bottom: 20px;
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
        <a href="user_dash.php" >
         <i class='bx bx-grid-alt'></i>
          <span class="links_name">Dashboard</span>
        </a>
      </li>
       <li>
        <a href="guest_allotment.php">
          <i class='bx bx-id-card'></i>
          <span class="links_name">Data Form</span>
        </a>
      </li>
       <li>
        <a href="analytics_user.php">
          <i class='bx bx-pie-chart-alt'></i>
          <span class="links_name"> Search Analytics</span>
        </a>
      </li>
      <li>
        <a href="given_allotments.php" class="active">
          <i class='bx bx-highlight'></i>
          <span class="links_name">Allotted Deeksha</span>
        </a>
      </li>
      <li>
        <a href="completed_allotments.php">
          <i class='bx bx-check-double'></i>
          <span class="links_name">Completed Deeksha</span>
        </a>
      </li>
      <li>
        <a href="pending_allotments.php">
          <i class='bx bx-pulse'></i>
          <span class="links_name">Pending Deeksha</span>
        </a>
      </li>
       <li>
        <a href="expired.php">
          <i class='bx bx-calendar-x'></i>
          <span class="links_name">Expired Deeksha</span>
        </a>
      </li>


    
    </ul>
  </div>
  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard"> Allotted Deeksha</span>
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
<?php
include('database.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php");
    exit();
}

$userID = $_SESSION['id'];

$sql = "SELECT faculty_data.*, regions.region_name, schools.board
        FROM faculty_data
        LEFT JOIN regions ON faculty_data.region_id = regions.region_id
        LEFT JOIN schools ON faculty_data.schools = schools.school_name
        WHERE faculty_data.user_id = ? AND faculty_data.status = 'Pending'
        ORDER BY faculty_data.id DESC";;
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // echo '<div class="card">';
                    echo "<table border='1'>";
    echo '<tr><th>Sr.No.</th><th>Date</th><th>Region</th><th>School Name</th><th>Board</th><th>Start Date</th><th>End Date</th><th>Status</th><th>Action</th></tr>';
    $cnt = 1;
    while ($row = $result->fetch_assoc()) {
        // Check if end_date has passed
        $currentDate = date('Y-m-d');
        if ($row["tedate"] < $currentDate && $row["status"] !== 'Expired') {
            // Update the status to "Expired" in the database
            $updateSql = "UPDATE faculty_data SET status = 'Expired' WHERE id = ?";
            $updateStmt = $con->prepare($updateSql);
            $updateStmt->bind_param("i", $row["id"]);
            
            if ($updateStmt->execute()) {
                // Update successful
                $updateStmt->close();
            } else {
                // Handle update error (log, display an error message, etc.)
                echo "Error updating status to 'Expired' for ID: " . $row["id"];
            }
        }

        echo '<tr>';
        echo '<td>' . $cnt . '</td>';
        echo '<td>' . $row["creation_date"] . '</td>';
        echo '<td>' . $row["region_name"] . '</td>';
        echo '<td>' . $row["schools"] . '</td>';
        echo '<td>' . $row["board"] . '</td>';
        echo '<td>' . $row["tsdate"] . '</td>';
        echo '<td>' . $row["tedate"] . '</td>';
        echo '<td>' . $row["status"] . '</td>';
        echo '<td><a href="faculty_panel.php?id=' . $row["id"] . '" class="card-link">View</a></td>';
        echo '</tr>';
        $cnt = $cnt + 1;
    }

    echo '</table>';
    // echo '</div>';
} else {
    echo "<h1>Currently There Is No Allotment.....</h1>";
}

$con->close();
?>

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