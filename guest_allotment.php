<?php
session_start();
include 'database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php");
    exit();
}

// Get the user ID from the session
$loggedInUserID = $_SESSION['id'];

// Query the database to fetch user details using the logged-in user ID
$getUserQuery = "SELECT * FROM usersss WHERE id = $loggedInUserID";
$userResult = $con->query($getUserQuery);

// Check if user exists
if ($userResult->num_rows === 0) {
    echo '<script>alert("Invalid user ID.");</script>';
    exit();
}

// Fetch user data
$userData = $userResult->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle file uploads
    $photoPath = ''; // Initialize variables for photo and excel paths
    $excelFilePath = '';

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

    // Process form data
    $name = $_POST['name'];
    $department = $_POST['department'];
    $tsdate = date('Y-m-d');
    $tedate =date('Y-m-d');
    $schools = $_POST['schools'];
    $board = $_POST['board'];
    $date = $_POST['date'];
    $pname = $_POST['pname'];
    $pcont = $_POST['pcont'];
    $twelve = $_POST['twelve'];
    $topic_covered = $_POST['topic_covered'];
    $visit_remark = $_POST['visit_remark'];
    $region = $_POST['region'];

    // Prepare SQL statement for inserting data
    $sql = "INSERT INTO faculty_fill_data (user_id, name, department, tsdate, tedate, schools, board, date, pname, pcont, twelve, topic_covered, visit_remark,  region, photo_path, excel_path) VALUES ('$loggedInUserID', '$name', '$department', '$tsdate', '$tedate', '$schools', '$board', '$date', '$pname', '$pcont',  '$twelve', '$topic_covered', '$visit_remark',  '$region', '$photoPath', '$excelFilePath')";

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

      echo "<script>
    alert('Success! Your action was completed.');
    window.location.href='guest_allotment.php';
</script>";
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
        <a href="guest_allotment.php"  class="active">
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
        <span class="dashboard">Data Form</span>
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
$loggedInUserID = $_SESSION['id'];

    // Query to fetch a specific user's data
    $sql = "SELECT id, name, department FROM usersss WHERE id = $loggedInUserID";
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
                    <input type="text" id="name" name="id" value="<?php echo $row["id"]; ?>" class="form-control" readonly>
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
                                    <label for="regions">Region:</label>
                                    <select id="regions" name="region" class="form-control">
                                        <!-- Options will be populated here by PHP -->
                                        <?php
                                            include('database.php');
            
                                            $query = "SELECT region_id, region_name FROM regions";
                                            $result = mysqli_query($con, $query);
            
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<option value="'.$row['region_id'].'">'.$row['region_name'].'</option>';
                                                }
                                            } else {
                                                echo '<option value="">No regions available</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
            <!--<div class="col-md-3">-->
            <!--    <div class="form-group">-->
            <!--        <label for="tsdate">Target Start Date:</label>-->
            <!--                               <input type="text" id="tsdate"  name="tsdate" class="form-control" readonly>-->

            <!--    </div>-->
            <!--</div>-->
           
        </div>
            <div class="row">
      <!--      <div class="col-md-3">-->
      <!--          <div class="form-group">-->
      <!--              <label for="tedate">Target End Date:</label>-->
      <!--                                      <input type="text" id="tedate" name="tedate"  class="form-control" readonly>-->

      <!--          </div>-->
      <!--      </div>-->
        
            <div class="col-md-3">
                <div class="form-group">
                    <label for="schools">School:</label>
                    <input type="text" id="schools" name="schools"  class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="board">Board:</label>
                   <Select name="board" class="form-control" required>
                      <option value="" disabled selected>-- Select Board --</option>
                    <option value="U.P. BOARD">U.P. Board</option>
            <option value="CBSE Board">CBSE Board</option>
            <option value="ICSE Board">ICSE Board</option>
                </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" class="form-control" required>
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
        <input type="text" id="pcont" name="pcont" class="form-control" placeholder="Enter 10-digit number" required pattern="[0-9]{10}" title="Please enter exactly 10 digits" maxlength="10">
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
                        <input type="text" name="tgt[0][contact]" class="form-control" placeholder="Enter 10-digit number" required pattern="[0-9]{10}" title="Please enter exactly 10 digits" maxlength="10" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tgt_dob"> DOB:</label>
                        <input type="date" name="tgt[0][dob]" class="form-control" id="tgt_dob" required>
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
        <button type="button" class="btn btn-primary" onclick="addTgtInfo()">Add More</button>

        <!-- PGT Information Section -->
        <h5 style="background:#233142; padding:5px; color:#fff;"><b>PGT Teacher Information</b></h5>
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
                        <input type="text" name="pgt[0][contact]" class="form-control" placeholder="Enter 10-digit number" pattern="[0-9]{10}" title="Please enter exactly 10 digits" maxlength="10"  required>
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
        <button type="button" class="btn btn-primary" onclick="addPgtInfo()">Add More</button>

        <button type="submit" class="btn btn-primary" style="background:#f96d00">Submit</button>
      </form>
    <?php
            
        } else {
            echo "User ID not set.";
        }
    ?>
    </div>
<?php include 'footer.php';?>
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
    <script>
        // Get the current date in YYYY-MM-DD format
        const currentDate = new Date().toISOString().split('T')[0];

        // Set the current date as the value for the input fields
        document.getElementById('tsdate').value = currentDate;
        document.getElementById('tedate').value = currentDate;
    </script>
</body>

</html>