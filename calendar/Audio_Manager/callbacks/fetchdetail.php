<?php
require("./config.php"); // Include database connection

header('Content-Type: application/json'); // Set the content type to JSON

$sql = "SELECT `id`, `v1`, `v2`, `v3`, `v4`, `v5` FROM `audio_details` WHERE 1";
$result = $con->query($sql);

$audioDetails = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $audioDetails[] = $row; // Collect all audio details
    }
}

echo json_encode($audioDetails); // Return data as JSON
$con->close();
?>
