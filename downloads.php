
<?php
if (isset($_POST['downloadCSV'])) {
    // Retrieve selected values
    $fromYear = $_POST['fromYear'];
    $toYear = $_POST['toYear'];

    // Connect to the database
    include 'database.php';
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to get the total number of students and faculty name for each school in the selected year range
    $query = "SELECT schools, YEAR(STR_TO_DATE(date, '%Y-%m-%d')) as year, 
                     SUM(twelve) as totalStudents, GROUP_CONCAT(DISTINCT name) as facultyNames
              FROM faculty_fill_data
              WHERE YEAR(STR_TO_DATE(date, '%Y-%m-%d')) BETWEEN ? AND ?
              GROUP BY schools, year";

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $fromYear, $toYear);
    $stmt->execute();
    $result = $stmt->get_result();

    // Generate CSV content
    $csvContent = "School Name,Year,Total Students,Faculty Names\n";

    while ($row = $result->fetch_assoc()) {
        $csvContent .= "{$row['schools']},{$row['year']},{$row['totalStudents']},{$row['facultyNames']}\n";
    }

    // Close the prepared statement and the database connection
    $stmt->close();
    $conn->close();

    // Set headers for CSV download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="analytics_data"');

    // Output the CSV content
    echo $csvContent;
    exit();
} else {
    // Redirect to the main page if accessed without proper parameters
    header('Location: index.php');
    exit();
}
?>
