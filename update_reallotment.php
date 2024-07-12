<?php

include('database.php');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $allocationId = $_POST['allocationId'];

    $endDate = $_POST['endDate'];



    // Perform the database update

    $sql = "UPDATE faculty_data SET status = 'Pending', tedate = ? WHERE id = ?";

    $stmt = $con->prepare($sql);

    $stmt->bind_param("si", $endDate, $allocationId);



    if ($stmt->execute()) {

        // Successful update

        echo "Success";

    } else {

        // Error updating the database

        echo "Error";

    }



    $stmt->close();

    $con->close();

} else {

    // Invalid request

    echo "Invalid Request";

}

?>

