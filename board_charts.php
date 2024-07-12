<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="your-styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
        }

        .dashboard {
            text-align: center;
            margin: 20px;
        }

        .charts-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .chart-container {
            width: 45%; /* Adjust the width as needed */
            margin: 20px;
        }
    </style>
    <title>Dashboard with Charts</title>
</head>

<body>
    <div class="dashboard">
        <h1>Dashboard with Charts</h1>
        <div class="charts-container">
            <div class="chart-container">
                <canvas id="userChart"></canvas>
            </div>
            <div class="chart-container">
                <canvas id="boardBarChart"></canvas>
            </div>
        </div>
    </div>

    <?php
    // Include the database connection
    include('database.php');

    // Get the total number of users with the role 'user'
    $sqlTotalUsers = "SELECT COUNT(*) as totalUsers FROM usersss WHERE role = 'user'";
    $resultTotalUsers = $con->query($sqlTotalUsers);
    $rowTotalUsers = $resultTotalUsers->fetch_assoc();
    $totalUsers = $rowTotalUsers['totalUsers'];

    // Get the count of users with 'Pending' status
    $sqlPendingUsers = "SELECT COUNT(*) as pendingUsers FROM faculty_data WHERE status = 'Pending'";
    $resultPendingUsers = $con->query($sqlPendingUsers);
    $rowPendingUsers = $resultPendingUsers->fetch_assoc();
    $pendingUsers = $rowPendingUsers['pendingUsers'];

    // Get the count of users with 'Completed' status
    $sqlCompletedUsers = "SELECT COUNT(*) as completedUsers FROM faculty_data WHERE status = 'Completed'";
    $resultCompletedUsers = $con->query($sqlCompletedUsers);
    $rowCompletedUsers = $resultCompletedUsers->fetch_assoc();
    $completedUsers = $rowCompletedUsers['completedUsers'];

    // Get the count of records in the faculty_data table for given allotments
    $sqlGivenAllotments = "SELECT COUNT(*) as givenAllotments FROM faculty_data";
    $resultGivenAllotments = $con->query($sqlGivenAllotments);
    $rowGivenAllotments = $resultGivenAllotments->fetch_assoc();
    $givenAllotments = $rowGivenAllotments['givenAllotments'];

    // Query to retrieve the count of each board type from the faculty_fill_data table
    $sqlBoardDistribution = "SELECT school_status, COUNT(*) as count FROM faculty_fill_data GROUP BY school_status";
    $resultBoardDistribution = $con->query($sqlBoardDistribution);

    // Fetch data for board distribution
    $labels = array();
    $data = array();

    while ($row = $resultBoardDistribution->fetch_assoc()) {
        $labels[] = $row['school_status'];
        $data[] = $row['count'];
    }

    // Close the database connection
    $con->close();
    ?>

    <script>
        // Data for the user chart
        var userChartCanvas = document.getElementById('userChart').getContext('2d');
        var userChartData = {
            labels: ['Total Users', 'Pending Users', 'Completed Users', 'Given Allotments'],
            datasets: [{
                label: 'User Statistics',
                data: [<?php echo $totalUsers; ?>, <?php echo $pendingUsers; ?>, <?php echo $completedUsers; ?>, <?php echo $givenAllotments; ?>],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(54, 162, 235, 0.5)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Chart options for the user chart
        var userChartOptions = {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        };

        // Create the user chart
        var userChart = new Chart(userChartCanvas, {
            type: 'bar',
            data: userChartData,
            options: userChartOptions
        });

        // Data for the board bar chart
        var boardBarChartCanvas = document.getElementById('boardBarChart').getContext('2d');
        var boardBarChartData = {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Board Distribution',
                data: <?php echo json_encode($data); ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    // Add more colors as needed
                ],
                borderWidth: 1,
            }],
        };

        // Chart options for the board bar chart
        var boardBarChartOptions = {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        };

        // Create the board bar chart
        var boardBarChart = new Chart(boardBarChartCanvas, {
            type: 'bar',
            data: boardBarChartData,
            options: boardBarChartOptions
        });
    </script>
</body>

</html>
