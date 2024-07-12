<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Check if the necessary parameters are set

    if (isset($_POST["allocationId"]) && isset($_POST["reason"])) {

        $allocationId = $_POST["allocationId"];

        $reason = $_POST["reason"];



        // Include your database connection file

        include('database.php');



        // Update the database with the reason and set applied_for_reallotment to 'Yes'

        $sql = "UPDATE faculty_data SET reallotment_reason = ?, applied_for_reallotment = 'Yes' WHERE id = ?";

        $stmt = $con->prepare($sql);

        $stmt->bind_param("si", $reason, $allocationId);



        if ($stmt->execute()) {

            // Return a success response

            echo json_encode(["success" => true]);

        } else {

            // Return an error response

            echo json_encode(["success" => false, "error" => $stmt->error]);

        }



        // Close the database connection

        $con->close();

    } else {

        // Return an error response if parameters are not set

        echo json_encode(["success" => false, "error" => "Missing parameters"]);

    }

} else {

    // Return an error response if not a POST request

    echo json_encode(["success" => false, "error" => "Invalid request method"]);

}

?>

