<?php
// Enable full error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "timebase_sys";
$change_current_id=0;

$conn = mysqli_connect($servername, $username, $password, $dbname);

$sql = "SELECT MAX(event_id) AS id FROM taskmanager"; // Combines timestamp and 16-character random string

$result = mysqli_query($conn, $sql);

if ($result) {

  $row = mysqli_fetch_assoc($result);

  $event_id = $row['id'];                                   //-- fetch event id from database and create new id for new event.

  $event_id++;
} else {

  $event_id = 1;
}

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form was submitted
if (isset($_FILES['csv_file'])) {
    // Check if file was uploaded without errors
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
        $file_name = $_FILES['csv_file']['tmp_name'];

        // Open the CSV file
        if (($file = fopen($file_name, "r")) !== FALSE) {
            // Skip the first line (header)
            fgetcsv($file);

            // Loop through the CSV rows
            while (($row = fgetcsv($file, 1000, ",")) !== FALSE) {
                // Prepare SQL query
                echo $event_id."<br>".$row[2]. $row[3]. $row[4]. $row[5]. $row[6]. $row[7]. $row[8]. $row[9]. $row[10];
                $sql = "INSERT INTO taskmanager (event_id, message, startdate, enddate, timing, colour, paulid, adhikaramid, thirukkuralid, bellid) 
                VALUES (
                    '" . $event_id . "', 
                    '" . $row[2] . "', 
                    '" . $row[3] . "', 
                    '" . $row[4] . "', 
                    '" . $row[5] . "', 
                    '" . $row[6] . "', 
                    '" . $row[7] . "', 
                    '" . $row[8] . "', 
                    '" . $row[9] . "', 
                    '" . $row[10] . "')";
        

                // Execute SQL query and check for errors
                if (mysqli_query($conn, $sql)) {
                    echo "Row inserted successfully<br>";
                    $change_current_id++;
                } else {
                    echo "Error inserting row: " . mysqli_error($conn) . "<br>";
                }
                if ($change_current_id==15){
                    $event_id++;
                  }
            }

            // Close the CSV file
            fclose($file);

        } else {
            echo "Error opening the file.";
        }
    } else {
        echo "No file uploaded or there was an error during the upload.";
    }
}

// Close the database connection
mysqli_close($conn);
?>
