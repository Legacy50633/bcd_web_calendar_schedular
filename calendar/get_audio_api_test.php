<?php
// Database connection parameters
$host = 'localhost'; // Replace with your database host
$dbname = 'timebase_sys'; // Replace with your database name
$username = 'root'; // Replace with your database username
$password = 'root'; // Replace with your database password

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Set error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL query to fetch all data
    $sql = "SELECT * FROM `thirukural_running_status` WHERE 1";
    $stmt = $pdo->query($sql);

    // Fetch all results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Debugging: Print fetched results
    error_log("Fetched results: " . json_encode($results));
    
    // Check if results are fetched
    if (empty($results)) {
        echo "No records found in thirukural_running_status.";
        exit;
    }

    // Extract specific values from results
    $aid = $results[0]["adhigaram"];
    $tid = $results[0]["thirukkural"];
    $running_status = $results[0]["audio_running_status"];
    $pause_status = $results[0]["audio_stop_status"]; // audio_pause_status
    $stop_status = $results[0]["audio_pause_status"];
    


    // Debugging: Print extracted values
    error_log("Extracted aid: $aid, tid: $tid, running_status: $running_status");

    // Check which IDs are provided and set the query accordingly
    if ($running_status == 1) {
        if ($aid !== 0 && $tid === 0) {
            // Only `aid` is provided
            $query1 = "SELECT audio_path FROM `thirukuralaudios` WHERE `aid` = :aid";
            $stmt = $pdo->prepare($query1);
            $stmt->bindParam(':aid', $aid, PDO::PARAM_INT);
        } elseif ($tid !== 0 && $aid === 0) {
            // Only `tid` is provided
            $query1 = "SELECT audio_path FROM `thirukuralaudios` WHERE `tid` = :tid";
            $stmt = $pdo->prepare($query1);
            $stmt->bindParam(':tid', $tid, PDO::PARAM_INT);
        } else {
            $query1 = "SELECT audio_path FROM `thirukuralaudios` WHERE `tid` = :tid";
            $stmt = $pdo->prepare($query1);
            $stmt->bindParam(':tid', $tid, PDO::PARAM_INT);

        }

        // Execute the SQL query
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Debugging: Print fetched data
        error_log("Fetched data: " . json_encode($data));

        // Encode data to JSON and print it
        $data["audio_stop_status"] = $pause_status;
        $data["audio_pause_status"] = $stop_status;
        echo json_encode($data);
    } else {
        echo "Audio is not running.";
    }
} catch (PDOException $e) {
    // Handle connection errors
    echo "Connection failed: " . $e->getMessage();
}
?>
