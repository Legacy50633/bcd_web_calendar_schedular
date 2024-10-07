<?php

include("./config.php");

date_default_timezone_set("Asia/Kolkata");

$currentTime = date("H:i");
$currentDate = date('Y-m-d');

// SQL query to select required columns from `taskmanager` table
$sql = "SELECT audio, paulid, adhikaramid, thirukkuralid, bellid FROM `taskmanager` 
        WHERE timing = '$currentTime' AND startdate = '$currentDate'";

// Execute the query
$result = mysqli_query($conn, $sql);

// Initialize the $events array
$events = [];

// Check if the query returned any rows
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Add the original row to the events array
        $event = [
            'audio' => $row["audio"],
            
        ];      if (!empty($row["bellid"])) {
            $bid = substr($row["bellid"],0,4);
            $audio_sql = "SELECT `bell_path` FROM `bell_audio` WHERE `bid` = '$bid'";
            $audio_result = mysqli_query($conn, $audio_sql);
            if ($audio_row = mysqli_fetch_assoc($audio_result)) {
                $event['bell_path'] = $audio_row['bell_path'];
            }
        }

        // Fetch additional audio paths
        if (!empty($row["paulid"])) {
            $audio_sql = "SELECT `paalpath` FROM `paal_audio` WHERE `paalname` = '" . $row["paulid"] . "'";
            $audio_result = mysqli_query($conn, $audio_sql);
            if ($audio_row = mysqli_fetch_assoc($audio_result)) {
                $event['paalpath'] = $audio_row['paalpath'];
            }
        }
        
        if (!empty($row["adhikaramid"])) {
            $aid = substr($row["adhikaramid"], -3);
            $audio_sql = "SELECT `Adhikkaram_path` FROM `adhigaram_audio` WHERE `aid` = '$aid'";
            $audio_result = mysqli_query($conn, $audio_sql);
            if ($audio_row = mysqli_fetch_assoc($audio_result)) {
                $event['adhikaram_path'] = $audio_row['Adhikkaram_path'];
            }
        }
        
        if (!empty($row["thirukkuralid"])) {
            $audio_sql = "SELECT `audio_path` FROM `thirukuralaudios` WHERE `tid` = '" . $row["thirukkuralid"] . "'";
            $audio_result = mysqli_query($conn, $audio_sql);
            if ($audio_row = mysqli_fetch_assoc($audio_result)) {
                $event['thirukkural_path'] = $audio_row['audio_path'];
            }
        }

       

  

        // Add the event to the events array
        $events[] = $event;
    }

    // Output the JSON-encoded data
    header('Content-Type: application/json'); // Set the content type to JSON
    echo json_encode($events);
} else {
    // If no rows returned, display a message in JSON format
    header('Content-Type: application/json'); // Set the content type to JSON
    http_response_code(204);
    echo json_encode(["message" => "No events found for the current time and date."]);
}

mysqli_close($conn);
?>
