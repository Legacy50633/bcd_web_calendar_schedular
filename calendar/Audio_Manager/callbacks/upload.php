<?php
require("./config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        // Set the uploads directory
        $uploads_dir = '/var/www/html/calendar/Audio_Manager/upload'; // Use forward slashes

        // Check if the upload directory exists and is writable
        if (!is_dir($uploads_dir)) {
            echo json_encode(['success' => false, 'error' => 'Upload directory does not exist.']);
            exit;
        } elseif (!is_writable($uploads_dir)) {
            echo json_encode(['success' => false, 'error' => 'Upload directory is not writable.']);
            exit;
        }

        $tmp_name = $_FILES['file']['tmp_name'];
        $name = basename($_FILES['file']['name']);
        $target_file = $uploads_dir . '/' . $name;

        // Check for file type (optional)
        $file_type = mime_content_type($tmp_name);
        if (strpos($file_type, 'image') === false) {
            echo json_encode(['success' => false, 'error' => 'Uploaded file is not an image.']);
            exit;
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($tmp_name, $target_file)) {
            // Create a relative URL for the frontend
            $img_url = './calendar/Audio_Manager/upload/' . $name;

            // Update the database (update the record where id = 1)
            $stmt = $con->prepare("UPDATE upload_image SET img_url = ? WHERE id = 1");
            $stmt->bind_param("s", $img_url);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'img_url' => $img_url]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Database update failed.']);
            }

            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to move uploaded file.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'No file uploaded or there was an upload error.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}

?>
