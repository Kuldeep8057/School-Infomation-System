<?php

// Include the database connection
include('database.php');

// Check if the 'search' parameter is present in the URL
if (isset($_GET['search'])) {
    $search = $_GET['search'];

    // Perform a SQL query to fetch name suggestions from the 'usersss' table
    $sql = "SELECT DISTINCT name, department FROM usersss WHERE name LIKE '%$search%' OR department LIKE '%$search%'";
    $result = $con->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {
        $suggestions = array();

        // Fetch and store the name and department suggestions in an array
        while ($row = $result->fetch_assoc()) {
            $suggestions[] = array('name' => $row['name'], 'department' => $row['department']);
        }

        // Return the suggestions as JSON
        echo json_encode($suggestions);
    } else {
        // No suggestions found
        echo json_encode([]);
    }
} else {
    // No search parameter provided
    echo json_encode([]);
}

// Close the database connection
$con->close();

?>
