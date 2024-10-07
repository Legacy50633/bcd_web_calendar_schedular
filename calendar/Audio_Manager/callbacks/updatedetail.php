<?php
require("./config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the values from the form
    $input1 = $_POST['input1'];
    $input2 = $_POST['input2'];
    $input3 = $_POST['input3'];
    $input4 = $_POST['input4'];
    $input5 = $_POST['input5'];
    $id = 1; // Change this to the appropriate ID you want to update

    // Prepare the SQL statement
    $sql = "UPDATE audio_details SET v1 = ?, v2 = ?, v3 = ?, v4 = ?, v5 = ? WHERE id = ?";
    
    // Prepare and execute the statement
    if ($stmt = $con->prepare($sql)) {
        // Bind parameters: "ssssi" means five strings and one integer
        $stmt->bind_param("sssssi", $input1, $input2, $input3, $input4, $input5, $id);
        
        // Execute the statement
        if ($stmt->execute()) {
          echo "<script>alert(' Updated Successfully'); window.location.href='../../../index.php';</script>";
        } else {
            echo "Error updating record: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $con->error;
    }
}
?>
