<?php
// view_data.php

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  $region = $_GET["region"];
  $school = $_GET["school"];
  $date = $_GET["date"];

  // Connect to your MySQL database
  $conn = new mysqli("localhost", "prahlads_d", "6qe7]Q?Np[&-", "prahlads_dksha");

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Fetch detailed data for the selected row
  $result = $conn->query("SELECT * FROM faculty_fill_data WHERE region = '$region' AND schools = '$school' AND date = '$date'");
 
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
  <title>Admin Panel || SCHOOL Info</title>

    <!-- Boxicons CDN Link -->

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Panel || Given Allotments</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            width: 100%;
            max-width: none;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #FF6961; /* Light red header background */
            color: #fff;
            padding: 10px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .card-body {
            padding: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333; /* Dark text color */
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }

        .col {
            width: calc(50% - 12px);
            margin-right: 20px;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 10px;
            border: 1px solid #ccc; /* Light gray border */
            border-radius: 4px;
        }

        input[type="date"] {
            appearance: none;
            padding: 8px;
            border: 1px solid #ccc; /* Light gray border */
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #e74c3c; /* Light red button color */
            color: #fff;
            cursor: pointer;
            border: none;
            padding: 10px;
            border-radius: 8px;
        }

        @media (max-width: 600px) {
            .col {
                width: 100%;
                margin-right: 0;
            }
        }
    </style>
</head>

<body>
      <div class="sidebar">
    <div class="logo-details">

      <span class="logo_name" style="margin-left:1px"><img width="59" height="55" src="kcmtlogos.jpg" alt="d"/></span> &nbsp;<H5 style="color:#fff;text-align:center;">SIMS</H5>
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
        <a href="add_users.php">
           <i class='bx bx-user-plus'></i>
          <span class="links_name">Add Faculty</span>
        </a>
      </li>
       <li>
        <a href="add_schools.php" >
           <i class='bx bx-plus'></i>
          <span class="links_name">Add Schools</span>
        </a>
      </li>
      
      <li>
        <a href="school_info.php" class="active">
           <i class='bx bx-info-circle'></i>
          <span class="links_name">School Info</span>
        </a>
      </li>
      
      <li class="log_out">
        <a href="logout.php">
          <i class='bx bx-log-out bx-fade-left-hover'></i>
          <span class="links_name">Log out</span>
        </a>
      </li>
    </ul>
  </div>
  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">School Information</span>
      </div>
    </nav>

    <div class="home-content">
<?php if ($result->num_rows >0): ?>
    <div class="container">

 
<?php while ($row = $result->fetch_assoc()): ?>
        <div class="card">
            <div class="card-header">
                <h3>School Information</h3>
            </div>
            <div class="card-body">

                    <div class="row">
                        <div class="col">
                            <label for="schoolName">Name:</label>
                            <input type="text" id="schoolName" value="<?= $row["schools"] ?>" name="schoolName" readonly>
                        </div>
                        <div class="col">
                            <label for="city">Region:</label>
                            <input type="text" id="city" value="<?= $row["region"] ?>" name="city" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="medium">Medium:</label>
                            <input type="text" id="medium" value="<?= $row["board"] ?>" name="medium" readonly>
                        </div>
                       
                    </div>
                
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>Key Person Information</h3>
            </div>
            <div class="card-body">
               
                    <div class="row">
                        <div class="col">
                            <label for="keyPersonName">Name:</label>
                            <input type="text" id="keyPersonName" value="<?= $row["pname"] ?>" name="keyPersonName" readonly>
                        </div>
                        <div class="col">
                            <label for="keyPersonType">Type:</label>
                            <input type="text" id="keyPersonType" value="Principal" name="keyPersonType" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="keyPersonPhone">Phone Number:</label>
                            <input type="tel" id="keyPersonPhone" value="<?= $row["pcont"] ?>"name="keyPersonPhone" readonly>
                        </div>
                   
                    </div>
               
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>PGT Teacher Information</h3>
            </div>
            <div class="card-body">
               
                    <div class="row">
                        <div class="col">
                            <label for="teacherName">Name:</label>
                            <input type="text" id="teacherName" value="<?= $row["pgtname"] ?>" name="teacherName" readonly>
                        </div>
                       
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="teacherContact">Contact Number:</label>
                            <input type="tel" id="teacherContact" value="<?= $row["pgtcont"] ?>" name="teacherContact" readonly>
                        </div>
                        
                    </div>
                
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h3>Student Information</h3>
            </div>
            <div class="card-body">
               
                    <div class="row">
                        <div class="col">
                            <label for="teacherName">Total Students:</label>
                            <input type="text" id="teacherName" value="<?= $row["twelve"] ?>" name="teacherName" readonly>
                        </div>
                       
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="teacherContact">Stream:</label>
                            <input type="tel" id="teacherContact" value="<?= $row["stream"] ?>" name="teacherContact" readonly>
                        </div>
                        
                    </div>
           <div class="row">
                        <div class="col">
                           <?php if (!empty($row["excel_path"])): ?>
      <label for="downloadPdf">Download Data:</label>
      <a href="<?= $row["excel_path"] ?>" id="downloadPdf" class="btn btn-primary" download>Download Data</a>
    <?php endif; ?>
                        </div>
                        
                    </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>Visit Details Information</h3>
            </div>
            <div class="card-body">
                
                    <div class="row">
                        <div class="col">
                            <label for="visitDate">Date:</label>
                            <input type="date" id="visitDate" value="<?= $row["date"] ?>" name="visitDate" readonly>
                        </div>
                
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="remarks">Remarks:</label>
                            <input type="text" id="remarks" value="<?= $row["visit_remark"] ?>"name="remarks" readonly>
                        </div>
                        <div class="col">
                            <label for="visitedBy">Topic:</label>
                            <input type="text" id="visitedBy" value="<?= $row["topic_covered"] ?>"name="visitedBy" readonly>
                        </div>
                    </div>
                
            </div>
        </div>

      
 <?php endwhile; ?>
    </div>
 <?php else: ?>
        <p>No details found for the selected row.</p>
    <?php endif; ?>
    </div>
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
<?php
  $conn->close();
}
?>