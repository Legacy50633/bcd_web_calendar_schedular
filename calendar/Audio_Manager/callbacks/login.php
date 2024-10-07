<?php
// Start the session
session_start();

$login = '<a href="./logout.php" class="logout-link">Logout</a>';
// Include the database connection file
require('../callbacks/config.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Basic validation
    if (empty($username) || empty($password)) {
         header("Location: index.php");
    } else {
        // Prepare the SQL statement
        $sql = "SELECT id, username, password, usertype FROM users WHERE username = ?";
        
        if ($stmt = $con->prepare($sql)) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            // Check if the user exists
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $db_username, $db_password, $usertype);
                $stmt->fetch();

                // Verify the password
                if ($password === $db_password) { // For simplicity, assuming password is not hashed
                    // Set session variables

          $_SESSION['user_id'] = $id;
                    $_SESSION['username'] = $username;
                    $_SESSION['usertype'] = $usertype;
                    if($_SESSION["usertype"] == 2){
                        header("Location: dataview.php");
                    }
                      echo "<script>alert(' Welcome $username'); window.location.href='../../index.php';</script>";
                    // Redirect to a protected page (e.g., dashboard.php)
                    exit;
                } else {
                 echo "<script>alert(' Invalid Password'); window.location.href='../../../index.php';</script>";
                }
            } else {
                echo "<script>alert(' No user flound'); window.location.href='../../../index.php';</script>";
      
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Error: " . $con->error;
        }
    }

    // Close the database connection
    $con->close();
}
else{
    echo "<script>alert(1);</script>";

}}
else{
    echo "<script>alert(2);</script>";
}
?>