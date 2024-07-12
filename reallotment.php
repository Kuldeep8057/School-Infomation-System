<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
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
    <title>Faculty Panel || Reallotments</title>
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
            padding: 8px 12px;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
        }

        .card-link:hover {
            background-color: #ff6666;
            color: #fff;
        }

        .reallotment-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
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
        <a href="reallotment.php" class="active">
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
            <span class="dashboard">Reallotments</span>
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
        <?php
        include('database.php');

        // Fetch all records where status is expired and applied_for_reallotment is 'Yes'
       $sql = "SELECT faculty_data.*, regions.region_name, schools.board
        FROM faculty_data
        LEFT JOIN regions ON faculty_data.region_id = regions.region_id
        LEFT JOIN schools ON faculty_data.schools = schools.school_name
                WHERE faculty_data.status = 'Expired' AND faculty_data.applied_for_reallotment = 'Yes'";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<table>';
            echo '<tr><th>Region</th><th>School</th><th>Board</th><th>Start Date</th><th>End Date</th><th>Status</th><th>Reason</th><th>Reallotment</th></tr>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row["region_name"] . '</td>';
                echo '<td>' . $row["schools"] . '</td>';
                echo '<td>' . $row["board"] . '</td>';
                echo '<td>' . $row["tsdate"] . '</td>';
                echo '<td>' . $row["tedate"] . '</td>';
                echo '<td>' . $row["status"] . '</td>';
                echo '<td>' . $row["reallotment_reason"] . '</td>';
                echo '<td><button class="reallotment-btn" onclick="openModal(' . $row["id"] . ')">Reallotment</button></td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo "<h1>No reallotment records found...</h1>";
        }

        $con->close();
        ?>
    </div>
  <?php include 'footer.php';?>
</section>
<!-- The Modal -->
<div id="reallotmentModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Reallotment</h2>
        <form id="reallotmentForm">
            <label for="endDate">Enter End Date:</label>
            <input type="date" id="endDate" name="endDate" required>
            <input type="submit" value="Submit">
        </form>
    </div>
</div>

<script>
    function openModal(allocationId) {
        document.getElementById('reallotmentForm').addEventListener('submit', function (e) {
            e.preventDefault();
            submitReallotment(allocationId);
        });
        document.getElementById('reallotmentModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('reallotmentForm').reset();
        document.getElementById('reallotmentModal').style.display = 'none';
    }

  function submitReallotment(allocationId) {
    let endDate = document.getElementById('endDate').value;

    // Perform AJAX or form submission to update the status and end date
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                sendEmail(allocationId, endDate);
                // Successfully updated, you can handle the response as needed
                alert("Reallotment requested for Allocation ID: " + allocationId + " with End Date: " + endDate);

                // Send email to the user
                

                // Close the modal after submission
                closeModal();

                // You may want to reload or update the table after reallotment
                location.reload();
            } else {
                // Handle error
                alert('Error updating reallotment. Please try again.');
            }
        }
    };

    // Adjust the URL and parameters based on your server-side script
    xhr.open('POST', 'update_reallotment', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('allocationId=' + allocationId + '&endDate=' + endDate);
}

function sendEmail(allocationId, endDate) {
    // Fetch the user's email from the database based on the allocationId
    let emailRequest = new XMLHttpRequest();
    emailRequest.onreadystatechange = function() {
        if (emailRequest.readyState === XMLHttpRequest.DONE) {
            if (emailRequest.status === 200) {
                let userEmail = emailRequest.responseText;

                // Send email using PHP mail function
                let mailRequest = new XMLHttpRequest();
                mailRequest.onreadystatechange = function() {
                    // Handle the response if needed
                };

                // Adjust the URL and parameters based on your server-side script
                mailRequest.open('POST', 'send_email.php', true);
                mailRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                mailRequest.send('userEmail=' + userEmail + '&allocationId=' + allocationId + '&endDate=' + endDate);
            } else {
                // Handle error
                console.error('Error fetching user email. Please try again.');
            }
        }
    };

    // Adjust the URL and parameters based on your server-side script
    emailRequest.open('GET', 'get_user_email.php?allocationId=' + allocationId, true);
    emailRequest.send();
}

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
