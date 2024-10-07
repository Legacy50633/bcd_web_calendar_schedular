<?php
// Database connection settings
$servername = "localhost"; // Replace with your server name
$username = "root";        // Replace with your database username
$password = "root";            // Replace with your database password
$dbname = "timebase_sys"; // Replace with your database name

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is received via POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data and validate it
     
    $runningStatus = isset($_POST['audio_running_status']) ? intval($_POST['audio_running_status']) : 0;
    $stopStatus = isset($_POST['audio_stop_status']) ? intval($_POST['audio_stop_status']) : 0;
    $pauseStatus = isset($_POST['audio_pause_status']) ? intval($_POST['audio_pause_status']) : 0;

    // Print form data for debugging
    print_r($_POST);

    // Ensure at least one field is filled out

        // Define the SQL query to update data in the table
        $sql = "UPDATE thirukural_running_status SET audio_running_status = ?, audio_stop_status = ?, audio_pause_status= ? WHERE id = 1";
        
        // Prepare and bind the statement
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("iii", $runningStatus,  $stopStatus,$pauseStatus);

            // Execute the statement
            if ($stmt->execute()) {
                echo "True";
            } else {
                echo "Error executing query: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    } else {
        echo "Please provide Adhigaram No or Thirukkural No.";
    }


// Close the database connection
$conn->close();
?>
