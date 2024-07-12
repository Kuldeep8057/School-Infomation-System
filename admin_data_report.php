<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php"); // Redirect to the login page if not logged in or not an admin
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
    <link rel="stylesheet" type="text/css" href="sidebar.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel || Data Report</title>
    <style>
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
        <a href="admin_data_report.php" class="active">
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
                <span class="dashboard">Completed Deeksha</span>
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
            <!-- Search Bar -->
            <div class="search-bar">
                <form method="GET" autocomplete="off">
                    <input type="text" name="search" placeholder="Search by name" id="searchInput">
                    <div class="search-suggestions" id="searchSuggestions"></div>
                    <button type="submit">Search</button>
                </form>
            </div>
            <!--<button id="downloadCsvBtn" >Download as CSV</button>-->

            <!-- Display Search Results or Default Results -->
          <?php
    if (isset($_GET['search'])) {
        echo "<div class='search-results'>";
    }
    include('database.php'); // Include the database connection

    // Pagination
    $records_per_page = 10;
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start_from = ($current_page - 1) * $records_per_page;

    // Check if the search parameter is present in the URL
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $sql = "SELECT id, name, schools,board, department, photo_path, creation_date FROM faculty_fill_data WHERE name LIKE '%$search%' ORDER BY creation_date DESC LIMIT $start_from, $records_per_page";
    } else {
        $sql = "SELECT id, name, schools,board, department, photo_path, creation_date FROM faculty_fill_data ORDER BY creation_date DESC LIMIT $start_from, $records_per_page";
    }

    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Sr.No.</th><th>Person Name</th><th>Department</th><th>School</th><th>Board</th><th>Image</th><th>Action</th></tr>";
        $cnt = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$cnt."</td>";
            echo "<td>" . $row["name"];
            
            $rowId = $row['id'];
            $messageKey = "viewed_message_$rowId";

            // Check if the user has viewed the message for this row
            if (!isset($_SESSION[$messageKey]) && !isset($_SESSION['viewed_messages'][$rowId])) {
                echo "<span id='newMessage_$rowId' class='new-message'>New!</span>";
            }
echo "</td>";
           
            echo "<td>" . $row["department"] . "</td>";
            echo "<td>" . $row["schools"] . "</td>";
             echo "<td>" . $row["board"] . "</td>";
             echo "<td>";
                if (!empty($row["photo_path"])) {
                    echo "<img src='" . $row["photo_path"] . "' alt='Image' style='max-width: 100px; max-height: 100px;'>";
                } else {
                    echo "No Image";
                }
                echo "</td>";
             // Display the "View" link with an onclick event to remove the message
            echo "<td><a href='user_report.php?id=$rowId' class='button' onclick='removeNewMessage($rowId)'>View</a></td>";

            echo "</tr>";
            $cnt = $cnt + 1;
        }
        echo "</table>";
    } else {
        echo "<h1>No persons found.......</h1>";
    }

    if (isset($_GET['search'])) {
        echo "</div>";
    }

    // Pagination Links
    $total_pages_sql = "SELECT COUNT(*) AS total_records FROM faculty_fill_data";
    $result = $con->query($total_pages_sql);
    $total_records = $result->fetch_assoc()['total_records'];
    $total_pages = ceil($total_records / $records_per_page);

    echo "<div class='pagination'>";
    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<a href='admin_data_report.php?page=$i'>$i</a>";
    }
       echo  "<span>Go to page: <input type='text' id='gotoPageInput' style='width: 50px;'> <button onclick='gotoPage()'>Go</button></span>";
    echo "</div>";

    ?>
        </div>
        <?php include 'footer.php';?>
    </section>
    <script>
    function gotoPage() {
        var input = document.getElementById('gotoPageInput').value;
        var page = parseInt(input);

        // Check if the entered page number is valid
        if (page >= 1 && page <= <?php echo $total_pages; ?>) {
            window.location.href = 'admin_data_report.php?page=' + page;
        } else {
            alert('Invalid page number!');
        }
    }
</script>

     <script>
        function removeNewMessage(rowId) {
            // Remove the "New Message!" span for the clicked row
            var newMessageSpan = document.getElementById('newMessage_' + rowId);
            if (newMessageSpan) {
                newMessageSpan.remove();
            }

            // Set a flag in session storage to remember the click
            sessionStorage.setItem('viewed_message_' + rowId, true);

            // Alternatively, use localStorage for a more persistent solution
            var viewedMessages = JSON.parse(localStorage.getItem('viewed_messages')) || {};
            viewedMessages[rowId] = true;
            localStorage.setItem('viewed_messages', JSON.stringify(viewedMessages));
        }

        // Check for previously viewed messages on page load
        document.addEventListener('DOMContentLoaded', function () {
            var viewedMessages = JSON.parse(localStorage.getItem('viewed_messages')) || {};
            Object.keys(viewedMessages).forEach(function (rowId) {
                var newMessageSpan = document.getElementById('newMessage_' + rowId);
                if (newMessageSpan) {
                    newMessageSpan.remove();
                }
            });
        });
    </script>
    <script>
        // document.getElementById('downloadCsvBtn').addEventListener('click', function () {
        //     window.location.href = 'download_data.php';
        // });

        // let sidebar = document.querySelector(".sidebar");
        // let sidebarBtn = document.querySelector(".sidebarBtn");
        // sidebarBtn.onclick = function () {
        //     sidebar.classList.toggle("active");
        //     if (sidebar.classList.contains("active")) {
        //         sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        //     } else
        //         sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
        // }

      
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
