<?php
session_start();

include 'database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php");
    exit();
}

// Get the user ID from the session
$loggedInUserID = $_SESSION['id'];

// Get the user ID from the URL
if (isset($_GET['id'])) {
    $requestedUserID = $_GET['id'];

    // Query the database to check if the logged-in user has access to the requested user ID
    $checkAccessQuery = "SELECT * FROM faculty_data WHERE id = $requestedUserID AND user_id = $loggedInUserID";
    $result = $con->query($checkAccessQuery);

    // If the result is empty, it means no access
    if ($result->num_rows === 0) {
        echo '<script>alert("You do not have access to this user ID.");</script>';
        exit();
    }
} else {
    echo '<script>alert("Invalid user ID.");</script>';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['photo']['name']);

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
            $photoPath = $uploadFile;
        } else {
            echo "Error uploading file.";
            exit();
        }
    }

    if (isset($_FILES['excel_file']) && $_FILES['excel_file']['error'] == 0) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['excel_file']['name']);

        if (move_uploaded_file($_FILES['excel_file']['tmp_name'], $uploadFile)) {
            $excelFilePath = $uploadFile;
        } else {
            echo "Error uploading Excel file.";
            exit();
        }
    }

    // Existing form handling code
    $user_id = $_SESSION['id'];
    $name = $_POST['name'];
    $department = $_POST['department'];
    $tsdate = $_POST['tsdate'];
    $tedate = $_POST['tedate'];
    $schools = $_POST['schools'];
    $board = $_POST['board'];
    $date = $_POST['date'];
    $pname = $_POST['pname'];
    $pcont = $_POST['pcont'];
    $twelve = $_POST['twelve'];
    $topic_covered = $_POST['topic_covered'];
    $visit_remark = $_POST['visit_remark'];
    $region = $_POST['region'];

    $sql = "INSERT INTO faculty_fill_data (user_id, name, department, tsdate, tedate, schools, board, date, pname, pcont, twelve, topic_covered, visit_remark, region, photo_path, excel_path) VALUES ('$user_id', '$name', '$department', '$tsdate', '$tedate', '$schools', '$board', '$date', '$pname', '$pcont', '$twelve', '$topic_covered', '$visit_remark', '$region', '$photoPath', '$excelFilePath')";

    if ($con->query($sql) === TRUE) {
        $facultyFillDataID = $con->insert_id; // Get the last inserted ID

        // Insert TGT information
        if (!empty($_POST['tgt'])) {
            foreach ($_POST['tgt'] as $tgt) {
                $tgtName = $tgt['name'];
                $tgtContact = $tgt['contact'];
                $tgtDOB = $tgt['dob'];
                $tgtDOA = $tgt['doa'];
                $tgtSubject = $tgt['subject'];
                $tgtEmail = $tgt['email'];

                $tgtSQL = "INSERT INTO tgt_info (faculty_fill_data_id, tgt_name, tgt_contact, dob, doa, subject, email) VALUES ('$facultyFillDataID', '$tgtName', '$tgtContact', '$tgtDOB', '$tgtDOA', '$tgtSubject', '$tgtEmail')";
                $con->query($tgtSQL);
            }
        }

        // Insert PGT information
        if (!empty($_POST['pgt'])) {
            foreach ($_POST['pgt'] as $pgt) {
                $pgtName = $pgt['name'];
                $pgtContact = $pgt['contact'];
                $pgtDOB = $pgt['dob'];
                $pgtDOA = $pgt['doa'];
                $pgtSubject = $pgt['subject'];
                $pgtEmail = $pgt['email'];

                $pgtSQL = "INSERT INTO pgt_info (faculty_fill_data_id, pgt_name, pgt_contact, dob, doa, subject, email) VALUES ('$facultyFillDataID', '$pgtName', '$pgtContact', '$pgtDOB', '$pgtDOA', '$pgtSubject', '$pgtEmail')";
                $con->query($pgtSQL);
            }
        }

        // Update status
        $updateStatusSql = "UPDATE faculty_data SET status = 'Completed' WHERE id = $requestedUserID AND user_id = $loggedInUserID";
        if ($con->query($updateStatusSql) === TRUE) {
           echo "<script>
    alert('Success! Your action was completed.');
    window.location.href='given_allotmenst.php';
</script>";
        } else {
            echo "Error updating status: " . $con->error;
        }
    } else {
        echo "Error: " . $con->error;
    }

    $con->close();
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
  <title>Faculty Panel || Fill Allotment</title>
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
      margin: 15px;
    }

    .head {
      position: relative;
      font-size: 30px;
      font-weight: 600;
      color: #333;
      margin: 15px;
      align-items: center;
    }



    .head::before {
      content: "";
      position: relative;
      left: 0;
      bottom: -2px;
      height: 3px;
      width: 50px;
      border-radius: 8px;
      background-color: #4070f4;
    }

    .btn {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 45px;
      max-width: 200px;
      width: 100%;
      border: none;
      outline: none;
      color: #fff;
      border-radius: 5px;
      margin: 25px 10px;
      background-color: #66bfbf;
      transition: all 0.3s linear;
      cursor: pointer;
    }

   #photo-preview {
      width: 200px;
      height: 200px;
      border: 1px solid black;
      margin-top: 10px;
    }
      label {
    font-weight: bold;
}
input[type="text"],
input[type="email"],
input[type="date"],
input[type="number"],
select {
    border: 2px solid; /* Adjust the border width as needed */
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
        <a href="user_dash.php">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">Dashboard</span>
        </a>
      </li>
      <li>
        <a href="guest_allotment.php" >
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
        <a href="given_allotments.php"  class="active">
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
        <span class="dashboard">Fill Allotment</span>
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
        include 'database.php'; // Include the database connection

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            // Query to fetch a specific user's data
         $sql = "SELECT faculty_data.*, regions.region_name, schools.board
        FROM faculty_data
        LEFT JOIN regions ON faculty_data.region_id = regions.region_id
        LEFT JOIN schools ON faculty_data.schools = schools.school_name
        WHERE faculty_data.id = $id";
            $result = $con->query($sql);

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
        ?>
      <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group">
          <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="name">UID:</label>
                    <input type="text" id="name" name="id" value="<?php echo $row["user_id"]; ?>" class="form-control" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="name">Faculty Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo $row["name"]; ?>" class="form-control" readonly>
                </div> 
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="name">Department:</label>
                    <input type="text" id="department" name="department" value="<?php echo $row['department']; ?>"class="form-control" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="tsdate">Target Start Date:</label>
                                           <input type="text" id="tsdate" value="<?php echo $row['tsdate']; ?>" name="tsdate" class="form-control" readonly>

                </div>
            </div>
        </div>
          <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="tedate">Target End Date:</label>
                                            <input type="text" id="tedate" name="tedate" value="<?php echo $row['tedate']; ?>" class="form-control" readonly>

                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="region">Region:</label>
                    <input type="text" id="region" name="region" value="<?php echo $row['region_name']; ?>" class="form-control" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="schools">School:</label>
                    <input type="text" id="schools" name="schools" value="<?php echo $row['schools']; ?>" class="form-control" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="board">Board:</label>
                    <input type="text" id="board" name="board" value="<?php echo $row['board']; ?>" class="form-control" readonly>
                </div>
            </div>
               <div class="col-md-3">
                <div class="form-group">
                    <label for="twelve">No. of Students:</label>
                    <input type="number" id="twelve" name="twelve" class="form-control" required>
                </div>
            </div>
              <div class="col-md-3">
                <div class="form-group">
                <label for="name">Date:</label>
                <input type="date" id="date" name="date" class="form-control" onchange="validateDate()" required>
                <small id="dateError" style="color: red;"></small>
                </div>
            </div>
            
               <div class="col-md-3">
            <div class="form-group">
            <label for="photo">Upload Photo:</label>
            <input type="file" id="photo" name="photo" class="form-control-file">
            </div>
        </div>
        <div class="col-md-3">
        <div class="form-group">
            <label for="excel_file">Upload Student Data in Excel Format:</label>
            <input type="file" id="excel_file" name="excel_file" class="form-control-file">
            </div>
          </div>
         
         
            <!--<div class="col-md-3">-->
            <!--    <div class="form-group">-->
            <!--        <label for="data_collected">Data Collected:</label>-->
            <!--        <select id="data_collected" name="data_collected" class="form-control" required>-->
            <!--            <option value="Yes">Yes</option>-->
            <!--            <option value="No">No</option>-->
            <!--        </select>-->
            <!--    </div>-->
            <!--</div>-->
            
        </div>
         <h5 style="background:#233142; padding:5px; color:#fff;"><b>Principal Information</b></h5>
         <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="pname">Principal Name:</label>
                    <input type="text" id="pname" name="pname" class="form-control" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="pcont">Principal Contact No.:</label>
                    <input type="text" id="pcont" name="pcont" class="form-control"  placeholder="Enter 10-digit number" pattern="[0-9]{10}" title="Please enter exactly 10 digits" maxlength="10" required>
                </div>
            </div>
            <!--<div class="col-md-3">-->
            <!--    <div class="form-group">-->
            <!--        <label for="stream">Stream:</label>-->
            <!--        <input type="text" id="stream" name="stream" class="form-control" required>-->
            <!--    </div>-->
            <!--</div>-->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="topic_covered">Topic Covered:</label>
                    <input type="text" id="topic_covered" name="topic_covered" class="form-control" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="visit_remark">Visit Remark:</label>
                    <input type="text" id="visit_remark" name="visit_remark" class="form-control" required>
                </div>
            </div>
          </div>

        <!-- TGT Information Section -->
               <h5 style="background:#233142; padding:5px; color:#fff;"><b>Graduation Teacher Information</b></h5>
        <div id="tgt-info-container">
            <div class="row tgt-info">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tgt_name"> Name:</label>
                        <input type="text" name="tgt[0][name]" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tgt_contact"> Contact No.:</label>
                        <input type="text" name="tgt[0][contact]" class="form-control"  placeholder="Enter 10-digit number" pattern="[0-9]{10}" title="Please enter exactly 10 digits" maxlength="10" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tgt_dob"> DOB:</label>
                        <input type="date" id="tgt_dob" name="tgt[0][dob]" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tgt_doa"> DOA:</label>
                        <input type="date" name="tgt[0][doa]" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tgt_subject"> Subject:</label>
                        <input type="text" name="tgt[0][subject]" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tgt_email"> Email:</label>
                        <input type="email" name="tgt[0][email]" class="form-control" required>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-secondary" onclick="addTgtInfo()">Add More</button>

        <!-- PGT Information Section -->
               <h5 style="background:#233142; padding:5px; color:#fff;"><b>PG Teacher Information</b></h5>

        <div id="pgt-info-container">
            <div class="row pgt-info">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="pgt_name">Name:</label>
                        <input type="text" name="pgt[0][name]" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="pgt_contact">Contact No.:</label>
                        <input type="text" name="pgt[0][contact]" class="form-control"  placeholder="Enter 10-digit number" pattern="[0-9]{10}" title="Please enter exactly 10 digits" maxlength="10" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="pgt_dob">DOB:</label>
                        <input type="date" id="pgt_dob" name="pgt[0][dob]" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="pgt_doa">DOA:</label>
                        <input type="date" name="pgt[0][doa]" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="pgt_subject">Subject:</label>
                        <input type="text" name="pgt[0][subject]" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="pgt_email">Email:</label>
                        <input type="email" name="pgt[0][email]" class="form-control" required>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-secondary" onclick="addPgtInfo()">Add More</button>

        <button type="submit" class="btn btn-primary" style="background:#f96d00">Submit</button>
      </form>
    <?php
            } else {
                echo "Invalid user ID.";
            }
        } else {
            echo "User ID not set.";
        }
    ?>
    </div>
  </section>
  <script>
    // Calculate minimum and maximum dates allowed
    var today = new Date();
    var minDate = new Date('1950-01-01'); // Minimum allowed date (1950-01-01)
    var maxDate = new Date(today.getFullYear() - 5, today.getMonth(), today.getDate()); // Five years ago from today

    // Format minimum and maximum dates as YYYY-MM-DD
    var minDateString = minDate.toISOString().slice(0, 10);
    var maxDateString = maxDate.toISOString().slice(0, 10);

    // Set the minimum and maximum attributes for the date input
    document.getElementById('pgt_dob').setAttribute('min', minDateString);
    document.getElementById('pgt_dob').setAttribute('max', maxDateString);
       // Set the minimum and maximum attributes for the date input
    document.getElementById('tgt_dob').setAttribute('min', minDateString);
    document.getElementById('tgt_dob').setAttribute('max', maxDateString);
</script>
  <script>
 //Date validation
    function validateDate() {
    let startDate = new Date('<?php echo $row['tsdate']; ?>');
    let endDate = new Date('<?php echo $row['tedate']; ?>');
    let selectedDate = new Date(document.getElementById('date').value);

    let dateError = document.getElementById('dateError');

    if (selectedDate < startDate || selectedDate > endDate) {
        dateError.innerText = 'Date must be between target start date and target end date.';
        document.getElementById('date').value = ''; // Reset the date input
    } else {
        dateError.innerText = '';
    }
}


    function addTgtInfo() {
        const container = document.getElementById('tgt-info-container');
        const index = container.getElementsByClassName('tgt-info').length;

        const tgtInfoHtml = `
        <hr style=" border: none;
            height: 2px;
            background-color: black;">
            <div class="row tgt-info">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tgt_name">Name:</label>
                        <input type="text" name="tgt[${index}][name]" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tgt_contact">Contact No.:</label>
                        <input type="text" name="tgt[${index}][contact]" class="form-control"  placeholder="Enter 10-digit number" pattern="[0-9]{10}" title="Please enter exactly 10 digits" maxlength="10" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tgt_dob">DOB:</label>
                        <input type="date" id="tgt_dob" name="tgt[${index}][dob]" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tgt_doa">DOA:</label>
                        <input type="date" name="tgt[${index}][doa]" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tgt_subject">Subject:</label>
                        <input type="text" name="tgt[${index}][subject]" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tgt_email">Email:</label>
                        <input type="email" name="tgt[${index}][email]" class="form-control" required>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', tgtInfoHtml);
    }

    function addPgtInfo() {
        const container = document.getElementById('pgt-info-container');
        const index = container.getElementsByClassName('pgt-info').length;

        const pgtInfoHtml = `
          <hr style=" border: none;
            height: 2px;
            background-color: black;">
            <div class="row pgt-info">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="pgt_name">Name:</label>
                        <input type="text" name="pgt[${index}][name]" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="pgt_contact">Contact No.:</label>
                        <input type="text" name="pgt[${index}][contact]" class="form-control"  placeholder="Enter 10-digit number" pattern="[0-9]{10}" title="Please enter exactly 10 digits" maxlength="10" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="pgt_dob">DOB:</label>
                        <input type="date" id="pgt_dob" name="pgt[${index}][dob]" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="pgt_doa">DOA:</label>
                        <input type="date" name="pgt[${index}][doa]" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="pgt_subject">Subject:</label>
                        <input type="text" name="pgt[${index}][subject]" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="pgt_email">Email:</label>
                        <input type="email" name="pgt[${index}][email]" class="form-control" required>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', pgtInfoHtml);
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


    // Mobile number validation
    // Add an event listener to validate contact numbers on input
    document.getElementById('pcont').addEventListener('input', validateContactNumber);
    document.getElementById('tgtcont').addEventListener('input', validateContactNumber);
    document.getElementById('pgtcont').addEventListener('input', validateContactNumber);

    // Function to validate contact numbers
    function validateContactNumber() {
        let contactNumber = this.value;
        let errorElement = document.getElementById(`${this.id}Error`);

        // Use a regular expression to check for a valid 10-digit phone number
        if (/^[0-9]{10}$/.test(contactNumber)) {
            errorElement.innerText = '';
        } else {
            errorElement.innerText = 'Enter a valid 10-digit phone number.';
        }
    }
  </script>
</body>

</html>