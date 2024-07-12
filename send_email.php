<?php
$userEmail = $_POST['userEmail'];
$allocationId = $_POST['allocationId'];
$endDate = $_POST['endDate'];

$subject = 'Reallotment Request';

// Inline CSS for the email body
$message = "
<html>
<body>
  <p style='font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333;'>
    Reallotment requested for Allocation ID: <span style='font-weight: bold;'>$allocationId</span> with End Date: <span style='color: blue;'>$endDate</span>
  </p>
</body>
</html>
";

// Adjust the headers as needed
$headers = "From: admin@ourwebprojects.site\r\n";
$headers .= "Content-type: text/html; charset=utf-8\r\n";

// Send the email
mail($userEmail, $subject, $message, $headers);
?>
