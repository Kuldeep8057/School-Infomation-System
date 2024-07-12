<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

if (isset($_POST['downloadCSV'])) {
    $fromYear = $_POST['fromYear'];
    $toYear = $_POST['toYear'];
    $board = $_POST['board'];

    $con = new mysqli("localhost", "prahlads_d", "6qe7]Q?Np[&-", "prahlads_dksha");

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    $query = "SELECT schools, board, YEAR(STR_TO_DATE(date, '%Y-%m-%d')) as year, 
                     SUM(twelve) as totalStudents, GROUP_CONCAT(DISTINCT name) as facultyNames
              FROM faculty_fill_data
              WHERE 1=1";
    $params = [];
    $types = '';

    if (!empty($fromYear)) {
        $query .= " AND YEAR(STR_TO_DATE(date, '%Y-%m-%d')) >= ?";
        $params[] = $fromYear;
        $types .= 's';
    }
    if (!empty($toYear)) {
        $query .= " AND YEAR(STR_TO_DATE(date, '%Y-%m-%d')) <= ?";
        $params[] = $toYear;
        $types .= 's';
    }
    if (!empty($board)) {
        $query .= " AND board = ?";
        $params[] = $board;
        $types .= 's';
    }

    $query .= " GROUP BY schools, year";

    $stmt = $con->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    $csvContent = "School Name,Board,Year,Total Students,Faculty Names\n";
    while ($row = $result->fetch_assoc()) {
        $csvContent .= "{$row['schools']},{$row['board']},{$row['year']},{$row['totalStudents']},{$row['facultyNames']}\n";
    }

    $stmt->close();
    $con->close();

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="analytics_data.csv"');
    echo $csvContent;
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
  <link rel="stylesheet" href="dashboard.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href='sidebar.css' rel='stylesheet'>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel || Dashboard</title>
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

  
    body {
        font-family: 'Arial', sans-serif;
        background-color: #ffffff;
        color: #800000;
        margin: 0;
        padding: 0;
    }

    h2 {
        color: #800000;
    }
   .show {
      display: flex;
      align-items: center;
      gap: 20px; /* Adjust the gap between elements as needed */
    }

    .show label,
    .show select,
    .show button {
      margin: 0;
    }

    .show select,
    .show button {
      padding: 5px 10px; /* Adjust padding for better spacing */
    }


    button {
      margin: 20px auto;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background-color: #385170;
            /* Dark red background color */
            color: #fff;
            /* White text color */
            transition: background-color 0.3s ease-in-out;
            justify-content: center;
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
  </style>
</head>

<body>
      <?php include 'admin_sidebar.php'; ?>
  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">Allotment Analytics</span>
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

    <form class="show" method="post" action="">
                <label for="fromYear">From Year:</label>
                <select name="fromYear" id="fromYear">
                    <option value="">Select From Year</option>
                    <?php
                    for ($year = 2020; $year <= date("Y"); $year++) {
                        echo "<option value='$year'>$year</option>";
                    }
                    ?>
                </select>

                <label for="toYear">To Year:</label>
                <select name="toYear" id="toYear">
                    <option value="">Select To Year</option>
                    <?php
                    for ($year = 2020; $year <= date("Y"); $year++) {
                        echo "<option value='$year'>$year</option>";
                    }
                    ?>
                </select>

                <label for="board">Board:</label>
                <select name="board" id="board">
                    <option value="">Select Board</option>
                    <?php
                    include 'database.php';
                    $boardQuery = "SELECT DISTINCT board FROM faculty_fill_data";
                    $boardResult = $con->query($boardQuery);

                    while ($boardRow = $boardResult->fetch_assoc()) {
                        echo "<option value='{$boardRow['board']}'>{$boardRow['board']}</option>";
                    }

                    $boardResult->close();
                    $con->close();
                    ?>
                </select>

                <button type="submit" name="submit">Get Analytics</button>
            </form>
<?php
if (isset($_POST['submit'])) {
    $fromYear = $_POST['fromYear'];
    $toYear = $_POST['toYear'];
    $board = $_POST['board'];

    $con = new mysqli("localhost", "prahlads_d", "6qe7]Q?Np[&-", "prahlads_dksha");

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    $query = "SELECT id, schools, board, YEAR(STR_TO_DATE(date, '%Y-%m-%d')) as year, 
                     SUM(twelve) as totalStudents, GROUP_CONCAT(DISTINCT name) as facultyNames, 
                     excel_path 
              FROM faculty_fill_data
              WHERE 1=1";
    $params = [];
    $types = '';

    if (!empty($fromYear)) {
        $query .= " AND YEAR(STR_TO_DATE(date, '%Y-%m-%d')) >= ?";
        $params[] = $fromYear;
        $types .= 's';
    }
    if (!empty($toYear)) {
        $query .= " AND YEAR(STR_TO_DATE(date, '%Y-%m-%d')) <= ?";
        $params[] = $toYear;
        $types .= 's';
    }
    if (!empty($board)) {
        $query .= " AND board = ?";
        $params[] = $board;
        $types .= 's';
    }

    $query .= " GROUP BY id, schools, year, excel_path";

    $stmt = $con->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        echo "<form method='post' action=''>";
        echo "<input type='hidden' name='fromYear' value='{$fromYear}'>";
        echo "<input type='hidden' name='toYear' value='{$toYear}'>";
        echo "<input type='hidden' name='board' value='{$board}'>";
        echo "<button type='submit' class='shows' name='downloadCSV'>Download as CSV</button>";
        echo "</form>";
        echo "<table border='1'>";
        echo "<tr><th>School Name</th><th>Board</th><th>Year</th><th>Total Students</th><th>Faculty Names</th><th>Data</th><th>Action</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['schools']}</td>";
            echo "<td>{$row['board']}</td>";
            echo "<td>{$row['year']}</td>";
            echo "<td>{$row['totalStudents']}</td>";
            echo "<td>{$row['facultyNames']}</td>";
            if (!empty($row['excel_path'])) {
                echo "<td><a href='{$row['excel_path']}' download>Download</a></td>";
            } else {
                echo "<td>No file</td>";
            }
            echo '<td><a href="user_report.php?id=' . $row['id'] . '" class="card-link">View</a></td>';
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "Error: " . $con->error;
    }

    $stmt->close();
    $con->close();
}
?>
    </div>
    <?php
    include 'footer.php';
    ?>
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
