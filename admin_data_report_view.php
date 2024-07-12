<?php
include('database.php'); // Include the database connection

// Check if the user is logged in or authorized (you can use your authentication logic here)
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php"); // Redirect to the login page if not logged in or not authorized
    exit();
}

if (isset($_GET['user_id'])) {
    $name = $_GET['user_id'];

    // Query to retrieve all data entries for the specific user based on their identifier (e.g., name)
    $sql = "SELECT * FROM faculty_fill_data WHERE user_id = $name";
    $result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Panel || Data Report View</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            text-align: center;
        }

        h1 {
            color: #ff6666;
            margin-bottom: 20px;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ffcccc;
            padding: 15px;
            text-align: left;
            background-color: #ffffff;
        }

        th {
            color: #ff6666;
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

        .go-back-link {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: #ff6666;
            border: 2px solid #ff6666;
            padding: 8px 12px;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
        }

        .go-back-link:hover {
            background-color: #ff6666;
            color: #fff;
        }
    </style>
</head>

<body>
 

    <?php
    // Check if there is data to display
    if ($result->num_rows > 0) {
        echo '<table>';
        echo '<tr><th>School</th><th>School Status</th><th>Topic Covered</th><th>View Full Detail</th></tr>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row["schools"] . '</td>';
            echo '<td>' . $row["school_status"] . '</td>';
            echo '<td>' . $row["topic_covered"] . '</td>';
            echo '<td><a href="user_report.php?id=' . $row['id'] . '" class="card-link">View</a></td>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo "No data found for $name.";
    }
}
    ?>
    
 
</body>

</html>
