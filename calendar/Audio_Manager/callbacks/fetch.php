<?php 
require("./config.php"); // Ensure the path to your database connection file is correct
session_start();

// Fetch data from `thirukural_running_status`
$query = "SELECT `id`, `thirukkural`, `adhigaram`, `audio_running_status` FROM `thirukural_running_status` WHERE 1";
$result = $con->query($query);

if (!$result) {
    echo json_encode(['error' => 'Query failed: ' . $con->error]);
    exit;
}

// Fetch the first row of the result set
$data = $result->fetch_assoc();
$aid = $data['adhigaram'];
$tid = $data['thirukkural'];

// Construct the query based on the availability of both or either `aid` or `tid`
if (!empty($tid)) {
    // If `tid` is provided, prioritize fetching by `tid`
    $selected_kurals = "SELECT * FROM thirukural_with_explanation WHERE tid = $tid";
} elseif (!empty($aid)) {
    // If only `aid` is provided, fetch by `aid`
    $selected_kurals = "SELECT * FROM thirukural_with_explanation WHERE aid = $aid";
} else {
    // If neither is provided, handle this edge case (e.g., error or default behavior)
    echo json_encode(['error' => 'Neither tid nor aid is provided.']);
    exit;
}

// Execute the query to fetch the selected kurals
$result1 = $con->query($selected_kurals);

if (!$result1) {
    echo json_encode(['error' => 'Query failed: ' . $con->error]);
    exit;
}

// Fetch all data and return it as JSON
$data1 = $result1->fetch_all(MYSQLI_ASSOC);
echo json_encode($data1);
?>
