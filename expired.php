<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php"); // Redirect to login page if not logged in or not an admin
    exit();
}
include 'update_status.php';

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

   
   
        h1 {
            color: #ff6666;
            margin-bottom: 20px;
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
            padding: 8px 32px;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
            cursor: pointer; /* Add cursor pointer */
        }

        .card-link:hover {
            background-color: #ff6666;
            color: #fff;
        }

        /* Popup styles */
        .popup {
            display:none ;
            flex-direction: column;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background: #fff;
            color:#ff6666;
            z-index: 1000;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        /* Overlay styles */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        
        #reasonForm{
            display:flex;
            align-items:center;
            justify-content:center;
            flex-direction:column;
            border-radius:20%;
        } 
        #button{
            background:#ff6666;
            color:#fff;
            padding:4px;
        }
        /* Close button styles */
        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }
        
        @media screen and (max-width: 600px) {
            .container {
                padding: 10px;
            }
        
    

  </style>
</head>

<body>

<div class="sidebar">
    <div class="logo-details">

       <span class="logo_name" style="margin-left:1px"><img width="59" height="55" src="kcmtlogos.jpg" alt="d"/></span> &nbsp;<H5 style="color:#fff;                    text-align:center;">DEEKSHA</H5>
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
        <a href="given_allotments.php">
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
        <a href="expired.php" class="active">
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
        <span class="dashboard">Expired Allotments</span>
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
                header("Location: index.php"); // Redirect to login page if not logged in or not a user
                exit();
            }

            $userID = $_SESSION['id'];

            // Prepare and execute a SELECT query to fetch all pending rows for the user with region_name
            $sql = "SELECT faculty_data.*, regions.region_name
                    FROM faculty_data
                    LEFT JOIN regions ON faculty_data.region_id = regions.region_id
                    WHERE faculty_data.user_id = ? AND faculty_data.status = 'Expired'";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("i", $userID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {

                echo '<table>';
                echo '<tr>
                        <th>Sr.No.</th>
                        <th>Region</th>
                        <th>School</th>
                         <th>Board</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Apply for Reallotment</th>
                        <th>Reallotment Reason</th>
                        <th>Action</th>
                      </tr>';
                $cnt = 1;
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $cnt . '</td>';
                    echo '<td>' . $row["region_name"] . '</td>';
                    echo '<td>' . $row["schools"] . '</td>';
                      echo '<td>' . $row["board"] . '</td>';
                    echo '<td>' . $row["tsdate"] . '</td>';
                    echo '<td>' . $row["tedate"] . '</td>';
                    echo '<td>' . $row["status"] . '</td>';
                    echo '<td>' . $row["applied_for_reallotment"] . '</td>';
                    echo '<td>' . $row["reallotment_reason"] . '</td>';
                      echo '<td>';
                if ($row["applied_for_reallotment"] === 'No') {
                    echo '<a onclick="openPopup(' . $row["id"] . ')" class="card-link">apply</a>';
                } else {
                    echo '<span class="card-link disabled">Applied</span>';
                }
                echo '</td>';
                    $cnt = $cnt + 1;
                }

                echo '</table>';
            } else {
                echo "<h1>No Expired Allotments found ...</h1>";
            }

            // Close the database connection
            $con->close();
            ?>

    </div>

<?php include 'footer.php';?>
  </section>
    <!-- Popup -->
    <div class="overlay" id="overlay"></div>
    <div class="popup" id="popup">
        <span class="close-btn" onclick="closePopup()">&times;</span>
        <h2>Request for Reallotment</h2>
        <form id="reasonForm">
            <label for="reason">Reason:</label>
            <textarea id="reason" name="reason" rows="4" cols="55" required></textarea>
            <br>
            <button id="button" type="submit">Submit</button>
        </form>
    </div>

    <script>
        function openPopup(allocationId) {
            document.getElementById('reasonForm').addEventListener('submit', function (e) {
                e.preventDefault();
                submitReason(allocationId);
            });

            document.getElementById('overlay').style.display = 'block';
            document.getElementById('popup').style.display = 'block';
        }

        function closePopup() {
            document.getElementById('reasonForm').reset();
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('popup').style.display = 'none';
        }

        function submitReason(allocationId) {
            let reason = document.getElementById('reason').value;

            // Perform AJAX or form submission to update the reason and applied_for_reallotment
            let xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Successfully updated, you can handle the response as needed
                        alert("Reallotment applied for Allocation ID: " + allocationId);
                        // Close the popup after submission
                        closePopup();
                        // You may want to reload or update the table after reallotment application
                        location.reload();
                    } else {
                        // Handle error
                        alert('Error applying for reallotment. Please try again.');
                    }
                }
            };

            // Adjust the URL and parameters based on your server-side script
            xhr.open('POST', 'apply_reallotment', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('allocationId=' + allocationId + '&reason=' + reason);
        }
    </script>
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