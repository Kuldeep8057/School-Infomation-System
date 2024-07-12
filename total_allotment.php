
<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php"); // Redirect to login page if not logged in or not an admin
    exit();
}
include 'update_status.php';
include 'database.php';

// Handle delete action
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];

    // Check if the record status is 'pending' or 'expired' before deleting
    $check_status_sql = "SELECT status FROM faculty_data WHERE id = ?";
    $stmt = $con->prepare($check_status_sql);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->bind_result($status);
    $stmt->fetch();
    $stmt->close();

    if ($status === 'Pending' || $status === 'Expired') {
        $delete_sql = "DELETE FROM faculty_data WHERE id = ?";
        $stmt = $con->prepare($delete_sql);
        $stmt->bind_param("i", $delete_id);
        if ($stmt->execute()) {
        echo "<script>alert('Record deleted successfully.');</script>";
        } else {
        echo "<script>alert('Error deleting record: " . addslashes($con->error) . "');</script>";
        }
        $stmt->close();
    } else {
    echo "<script>alert('Only pending or expired records can be deleted.');</script>";
    }
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
    <title>Admin Panel || Total Allotments</title>
    <style>
 .search-bar {
            margin-bottom: 20px;
            position: relative;
        }

        .search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            width: 100%;
            background: #fff;
            border: 1px solid #ddd;
            border-top: none;
            display: none;
        }

        .search-suggestions ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .search-suggestions li {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
        }

        /* Add search results styles */
        .search-results table {
            width: 100%;
        }

        /* Add search bar styles */
        .search-bar {
            margin-bottom: 20px;
        }

        /* Style the input field */
        .search-bar input[type="text"] {
            padding: 10px;
            border: 1px solid #385170; /* Dark red border */
            border-radius: 4px;
            outline: none;
            color: #333;
            background-color: #fff; /* White background */
            transition: border-color 0.3s ease-in-out;
        }

        /* Style the search button */
        button,.search-bar button {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background-color: #385170; /* Dark red background color */
            color: #fff; /* White text color */
            transition: background-color 0.3s ease-in-out;
        }

        /* Adjust styles on hover/focus */
        .search-bar input[type="text"] {
            border-color: #385170; /* Darker red on focus/hover */
            background-color:#fff; /* Darker red on focus/hover */
        }

        body {
            background-color: #f5f5f5;
        }

        .container {
            margin-top: 50px;
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
        /* Add search bar styles */
        .search-bar {
            margin-bottom: 20px;
            position: relative;
        }

        .search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            width: 100%;
            background: #fff;
            border: 1px solid #ddd;
            border-top: none;
            display: none;
        }

        .search-suggestions ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .search-suggestions li {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
        }

        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .pagination span {
            margin-right: 10px;
        }

        .pagination input {
            width: 40px;
            text-align: center;
        }

      .pagination a,
        .pagination button {
            padding: 8px 16px;
            margin: 0 5px;
            text-decoration: none;
            background-color: #ff3333;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }

        .pagination a.active,
        .pagination button.active {
            background-color: #ff3333;
        }
        .dropdown {
    position: relative;
    display: inline-block;
}

/* profile avt */
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

    </style>
</head>

<body>
    <div class="sidebar">
        <div class="logo-details">
            <span class="logo_name" style="margin-left:1px"><img width="59" height="55" src="kcmtlogos.jpg"
                    alt="d" /></span> &nbsp;<H5 style="color:#fff;text-align:center;">DEEKSHA</H5>
        </div> <ul class="nav-links">
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
       <a href="total_allotment.php" class="active">
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
    <section

 class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">Deeksha Status</span>
            </div>
             <div class="avt dropdown">
        <button class="dropdown-toggle" id="profile-dropdown-toggle">
            <img src="pro_avt.png" alt="Profile Avatar" class="profile-avatar">
        </button>
        <ul class="dropdown-menu" id="profile-dropdown">
            <li><a href="10-Profile.php">Profile</a></li>
            <li><a href="students/students_data.php">Upload</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
        </nav>

        <div class="home-content">
            <!-- Search Bar -->
            <div class="search-bar">
                <form method="GET" autocomplete="off">
                    <input type="text" name="search" placeholder="Search by name" id="searchInput">
                    <div class="search-suggestions" id="searchSuggestions"></div>
                    <button type="submit">Search</button>
                </form>
            </div>
 <!-- Display Search Results or Default Results -->
            <?php
            if (isset($_GET['search'])) {
                echo "<div class='search-results'>";
            }
            include 'database.php';

            // Check if the search parameter is present in the URL
            if (isset($_GET['search'])) {
                $search = $_GET['search'];
               $sql = "SELECT faculty_data.*, regions.region_name, schools.board
        FROM faculty_data
        LEFT JOIN regions ON faculty_data.region_id = regions.region_id
        LEFT JOIN schools ON faculty_data.schools = schools.school_name
                        WHERE name LIKE '%$search%'";
            } else {
              $sql = "SELECT faculty_data.*, regions.region_name, schools.board
        FROM faculty_data
        LEFT JOIN regions ON faculty_data.region_id = regions.region_id
        LEFT JOIN schools ON faculty_data.schools = schools.school_name
                        ORDER BY faculty_data.id DESC";
            }

            // Define the number of results per page
            $resultsPerPage = 10;

            // Get the current page from the URL parameter
            $currentpage = isset($_GET['page']) ? $_GET['page'] : 1;

            // Calculate the offset for the query
            $offset = ($currentpage - 1) * $resultsPerPage;

            // Modify SQL query to include LIMIT and OFFSET
            $sql .= " LIMIT $offset, $resultsPerPage";

            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>Sr.No.</th><th>Department</th><th>Name</th><th>Region Name</th><th>Schools</th><th>Board</th><th>Start Date</th><th>End Date</th><th>Status</th><th>Action</th></tr>";
                 $srNo = $offset + 1; 
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                     echo "<td>" . $srNo . "</td>";
                    echo "<td>" . $row["department"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["region_name"] . "</td>";
                    echo "<td>" . $row["schools"] . "</td>";
   echo "<td>" . $row["board"] . "</td>";
                    echo "<td>" . $row["tsdate"] . "</td>";
                    echo "<td>" . $row["tedate"] . "</td>";
                    echo "<td>" . $row["status"] . "</td>";
                      echo "<td>";
                    echo "<form method='POST' onsubmit=\"return confirm('Are you sure you want to delete this record?');\">";
                    echo "<input type='hidden' name='delete_id' value='" . $row["id"] . "'>";
                    echo "<button type='submit' class='btn btn-danger btn-sm'>Delete</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                      $srNo++; // Increment serial number
                }
                echo "</table>";

                // Pagination links
                $totalResults = $con->query("SELECT COUNT(*) as total FROM faculty_data")->fetch_assoc()['total'];
                $totalPages = ceil($totalResults / $resultsPerPage);

                echo "<div class='pagination'>";
                echo "<span>Page:</span>";
                echo "<form action='total_allotment.php' method='GET'>";
                echo "<input type='number' name='page' min='1' max='$totalPages' value='$currentpage'>";
                echo "<button type='submit'>Go</button>";
                echo "</form>";
                for ($i = 1; $i <= $totalPages; $i++) {
                    echo "<a href='total_allotment.php?page=$i' ";
                    if ($i == $currentpage) echo "class='active'";
                    echo ">$i</a>";
                }
                echo "</div>";
            } else {
                echo "<h1>No allotment details available......</h1>";
            }

            if (isset($_GET['search'])) {
                echo "</div>";
            }
            ?>
           <script>
    // Fetch name and department suggestions from the usersss table
    const searchInput = document.getElementById('searchInput');
    const searchSuggestions = document.getElementById('searchSuggestions');

    searchInput.addEventListener('input', function () {
        const inputValue = this.value;

        // Send an AJAX request to fetch name and department suggestions
        if (inputValue.length >= 1) { // Adjust the minimum length as needed
            fetch(`get_name_suggestions.php?search=${inputValue}`)
                .then(response => response.json())
                .then(data => {
                    // Display name and department suggestions
                    if (data.length > 0) {
                        const suggestions = data.map(item => `<li>${item.name} (${item.department})</li>`).join('');
                        searchSuggestions.innerHTML = `<ul>${suggestions}</ul>`;
                        searchSuggestions.style.display = 'block';
                    } else {
                        searchSuggestions.innerHTML = '';
                        searchSuggestions.style.display = 'none';
                    }
                })
                .catch(error => console.error('Error fetching name and department suggestions:', error));
        } else {
            searchSuggestions.innerHTML = '';
            searchSuggestions.style.display = 'none';
        }
    });

    // Handle click on name or department suggestion
    searchSuggestions.addEventListener('click', function (event) {
        if (event.target.tagName === 'LI') {
            const suggestionText = event.target.textContent;
            const [name, department] = suggestionText.split(' (');
            searchInput.value = name;
            searchSuggestions.innerHTML = '';
            searchSuggestions.style.display = 'none';
        }
    });
</script>

        </div>
       <?php include 'footer.php';?>
    </section>
    <script>
        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".sidebarBtn");
        sidebarBtn.onclick = function () {
            sidebar.classList.toggle("active");
            if (sidebar.classList.contains("active")) {
                sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
            } else
                sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
        }
    </script>
 




</body>

</html>
