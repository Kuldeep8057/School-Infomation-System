<?php
// success_page.php

// Check if the message parameter is set in the URL
if (isset($_GET['message'])) {
    $successMessage = urldecode($_GET['message']);
    echo "<p>$successMessage</p>";
} else {
    // Handle the case where the message parameter is not set
    echo "<p>Success message not available.</p>";
}

// Your success page content goes here
// ...
?>