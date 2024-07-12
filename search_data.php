<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $region = $_POST["region"] ?? '';
  $school = $_POST["school"] ?? '';
  $board = $_POST["board"] ?? '';

  // Connect to your MySQL database
  $conn = new mysqli("localhost", "prahlads_d", "6qe7]Q?Np[&-", "prahlads_dksha");

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Build the query based on selected criteria
  $query = "SELECT * FROM faculty_fill_data WHERE 1=1";
  if (!empty($region)) {
    $query .= " AND region = '$region'";
  }
  if (!empty($school)) {
    $query .= " AND schools = '$school'";
  }
  if (!empty($board)) {
    $query .= " AND board = '$board'";
  }

  // Fetch data based on the selected criteria
  $result = $conn->query($query);

  echo "<html>";
  echo "<head>";
  echo "<style>";
  echo "h2 { color: #e74c3c; }"; /* Light red heading color */
  echo "table {
            width: 100%;
          }
          th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #dee2e6;
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
          }"; /* White table background */
  echo ".view-button { 
            background-color: #e74c3c; 
            color: white; 
            padding: 5px 10px; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; 
          }"; /* Light red button color */
  echo "</style>";
  echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
  echo "</head>";
  echo "<body>";

  echo "<h2>Search Results</h2>";

  if ($result->num_rows > 0) {
    echo "<table><tr><th>Sr.No.</th><th>Region</th><th>School</th><th>Board</th><th>Year</th><th>Action</th></tr>";
    $cnt = 1;
    while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>{$cnt}</td>";
      echo "<td>{$row["region"]}</td>";
      echo "<td>{$row["schools"]}</td>";
      echo "<td>{$row["board"]}</td>";
      echo "<td>" . date("Y", strtotime($row["date"])) . "</td>"; // Display only the year
      echo "<td><a class='view-button' href='user_report.php?id={$row["id"]}'>View</a></td>";
      echo "</tr>";
      $cnt++;
    }
    echo "</table>";
  } else {
    echo "<p>No results found.</p>";
  }

  echo "</body>";
  echo "</html>";

  $conn->close();
}
?>
