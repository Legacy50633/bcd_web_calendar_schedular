<?php
// Include the database connection configuration
include("./config.php");
session_start();
if ($_SESSION["usertype"] == 0) {

    // Enable error reporting for debugging
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Function to generate a random hex color
    function generateRandomColor() {
        $red = rand(0, 255);
        $green = rand(0, 255);
        $blue = rand(0, 255);
        return sprintf("#%02x%02x%02x", $red, $green, $blue);
    }

    // Initialize variables
    $count = 1;
    $event_id = 0;

    // Fetch the max event_id from the database
    $sql = "SELECT MAX(event_id) AS id FROM taskmanager"; 
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $event_id = $row['id'] + 1;  // Increment event_id for the new event
    } else {
        $event_id = 1;  // Default event_id if no rows found
    }

    if (isset($_POST['upload'])) {
        if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
            $file_tmp = $_FILES['csv_file']['tmp_name'];
            $file = fopen($file_tmp, 'r');

            // Skip the first row (header)
            fgetcsv($file);

            // Prepare the SQL insert query with placeholders
            $stmt = $conn->prepare("INSERT INTO taskmanager (event_id, message, startdate, enddate, timing, notallowed, colour, days, audio, audioname, paulid, adhikaramid, thirukkuralid, bellid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $colour = generateRandomColor();

            while (($row = fgetcsv($file)) !== FALSE) {
                // Check if the necessary fields exist before accessing them
                if (isset($row[1]) && isset($row[3]) && isset($row[5])) {
                    $formattedDate = date("Y-m-d", strtotime($row[1]));
                    $event = htmlspecialchars($event_id);
                    $message = htmlspecialchars($row[5], ENT_QUOTES, 'UTF-8');  
                    $startdate = $formattedDate;
                    $enddate = $formattedDate;
                    $timing = htmlspecialchars($row[3]);
                    $days = "";  
                    $audio = "";  
                    $audioname = "";  
                    $notallowed = "";  

                    // Check for empty values and assign NULL or default values
                    $paulid = !empty($row[6]) ? (int)$row[6] : NULL;
                    $adhikaramid = !empty($row[7]) ? (int)$row[7] : NULL;
                    $thirukkuralid = !empty($row[8]) ? (int)$row[8] : NULL;
                    $bellid = !empty($row[4]) ? (int)$row[4] : NULL;

                    // Check the number of entries for the date in the database
                    $check_sql = "SELECT COUNT(*) AS count FROM taskmanager WHERE startdate = '$formattedDate'";
                    $check_result = mysqli_query($conn, $check_sql);
                    $check_row = mysqli_fetch_assoc($check_result);
                    $existing_entries = $check_row['count'];

                    // If there are already 16 entries for the date, stop further insertions for that date
                    if ($existing_entries >= 16) {
                        echo "<script>alert('Duplicate entry for date $formattedDate. Maximum 16 entries allowed.'); window.location.href='./index.php';</script>";
                        exit; // Stop further execution
                    }

                    // Bind parameters
                    if (!empty($timing) && !empty($message) && !empty($startdate) && !empty($enddate)) {
                        $stmt->bind_param('isssssssssssss', $event, $message, $startdate, $enddate, $timing, $notallowed, $colour, $days, $audio, $audioname, $paulid, $adhikaramid, $thirukkuralid, $bellid);
                        
                        // Execute the query
                        $stmt->execute();
                    }

                    $count++;
                    if ($count == 17) {
                        $event_id++;  // Increment event_id after every 15 records
                        $count = 1;   // Reset count for the next batch
                        $colour = generateRandomColor();
                    }
                } else {
                    echo "<script>alert('CSV file is missing required fields. Please check the template.'); window.location.href='./index.php';</script>";
                    exit;
                }
            }

            // Close the file and prepared statement
            fclose($file);
            $stmt->close();

            echo "<script>alert('Successfully Inserted'); window.location.href='./index.php';</script>";
        } else {
            echo "<script>alert('No file selected or invalid format. Check CSV template.'); window.location.href='./index.php';</script>";
        }
    }
} else {
    echo "<script>alert('Please contact authorized person'); window.location.href='./index.php';</script>";
}

// Close the database connection
$conn->close();
?>
