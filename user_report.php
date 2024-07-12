<!DOCTYPE html>
<html lang="en">

<head>
    <title>Faculty Panel || View Data Report</title>
    <style>
       body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            color: #333;
            text-align: center;
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

        a {
            text-decoration: none;
            color: #ff6666;
            border: 2px solid #ff6666;
            padding: 8px 12px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
            transition: all 0.3s ease-in-out;
        }

        a:hover {
            background-color: #ff6666;
            color: #fff;
        }

        div.container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffe6e6;
            border: 1px solid #ffcccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        @media print {
            body {
                background-color: #ffffff;
            }

            a {
                display: none;
            }

            div.container {
                background-color: #ffffff;
                border: none;
                box-shadow: none;
            }
        }
    </style>
</head>

<body>
    <?php
    include('database.php');
    session_start();

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header("Location: index.php");
        exit();
    }

    if (isset($_GET['id'])) {
        $dataID = $_GET['id'];

        // Fetch data from faculty_fill_data table
        $sql = "SELECT * FROM faculty_fill_data WHERE id = $dataID";
        $result = $con->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            echo "<div class='container'>";
            echo "<h1>".$row["schools"]."</h1>";

            echo "<table>";
            echo "<tr><th>Field</th><th>Value</th></tr>";
            echo "<tr><td>Faculty Name</td><td>" . $row["name"] . "</td></tr>";
            echo "<tr><td>Department</td><td>" . $row["department"] . "</td></tr>";
            echo "<tr><td>Alloted School</td><td>" . $row["schools"] . "</td></tr>";
            echo "<tr><td>Board</td><td>" . $row["board"] . "</td></tr>";
            echo "<tr><td>Date</td><td>" . $row["date"] . "</td></tr>";
            echo "<tr><td>Principal Name</td><td>" . $row["pname"] . "</td></tr>";
            echo "<tr><td>Principal Contact No.</td><td>" . $row["pcont"] . "</td></tr>";

            echo "<tr><td>12th Strength</td><td>" . $row["twelve"] . "</td></tr>";
            echo "<tr><td>Topic Covered</td><td>" . $row["topic_covered"] . "</td></tr>";
            echo "<tr><td>Visit Remark</td><td>" . $row["visit_remark"] . "</td></tr>";
      
            if (!empty($row['excel_path'])) {
                echo "<tr><td>Student Data</td><td><a href='{$row['excel_path']}' download>Download</a></td></tr>";
            } else {
                echo "<tr><td>Student Data</td><td>No file</td></tr>";
            }

            echo "<tr><td>Image</td><td>";
            if (!empty($row["photo_path"])) {
                echo "<img src='" . $row["photo_path"] . "' alt='Image' style='max-width: 200px; max-height: 200px;'>";
            } else {
                echo "No Image";
            }
            echo "</td></tr>";
            echo "</table>";

            // Fetch and display TGT info
            $sql_tgt = "SELECT * FROM tgt_info WHERE faculty_fill_data_id = $dataID";
            $result_tgt = $con->query($sql_tgt);

            echo "<h2>UG Teacher Information</h2>";
            echo "<table>";
            echo "<tr><th>Name</th><th>Contact No.</th><th>DOB</th><th>DOA</th><th>Subject</th><th>Email</th></tr>";

            while ($tgt_row = $result_tgt->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $tgt_row["tgt_name"] . "</td>";
                echo "<td>" . $tgt_row["tgt_contact"] . "</td>";
                echo "<td>" . $tgt_row["dob"] . "</td>";
                echo "<td>" . $tgt_row["doa"] . "</td>";
                echo "<td>" . $tgt_row["subject"] . "</td>";
                echo "<td>" . $tgt_row["email"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";

            // Fetch and display PGT info
            $sql_pgt = "SELECT * FROM pgt_info WHERE faculty_fill_data_id = $dataID";
            $result_pgt = $con->query($sql_pgt);

            echo "<h2>PG Teacher Information</h2>";
            echo "<table>";
            echo "<tr><th>Name</th><th>Contact No.</th><th>DOB</th><th>DOA</th><th>Subject</th><th>Email</th></tr>";

            while ($pgt_row = $result_pgt->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $pgt_row["pgt_name"] . "</td>";
                echo "<td>" . $pgt_row["pgt_contact"] . "</td>";
                echo "<td>" . $pgt_row["dob"] . "</td>";
                echo "<td>" . $pgt_row["doa"] . "</td>";
                echo "<td>" . $pgt_row["subject"] . "</td>";
                echo "<td>" . $pgt_row["email"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";

            echo "<a href='javascript:void(0);' onclick='window.print();'>Print</a>";
            echo "</div>";
        } else {
            echo "<div class='container'>";
            echo "<h1>Data not found</h1>";
            echo "<a href=''>Print</a>";
            echo "</div>";
        }
    } else {
        echo "<div class='container'>";
        echo "<h1>Invalid data ID</h1>";
        echo "<a href=''>Print</a>";
        echo "</div>";
    }
    ?>
</body>

</html>
