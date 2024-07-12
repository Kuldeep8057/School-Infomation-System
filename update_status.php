<?php
include 'database.php';

// Get the current date
$currentDate = date("Y-m-d");

// Update the status to "Expired" for rows where the end date has passed and status is "Pending"
$sql = "UPDATE faculty_data SET status = 'Expired' WHERE tedate < ? AND status = 'Pending'";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $currentDate);
$stmt->execute();
$stmt->close();

$con->close();
?>
