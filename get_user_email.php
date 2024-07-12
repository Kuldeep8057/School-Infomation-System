<?php
include('database.php');

$allocationId = $_GET['allocationId'];

$sql = "SELECT usersss.username
        FROM faculty_data
        INNER JOIN usersss ON faculty_data.user_id = usersss.id
        WHERE faculty_data.id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param('i', $allocationId);
$stmt->execute();
$stmt->bind_result($userEmail);

if ($stmt->fetch()) {
    echo $userEmail;
} else {
    echo 'User email not found';
}

$stmt->close();
$con->close();
?>
