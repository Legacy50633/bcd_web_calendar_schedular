<?php
// Start the session
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Redirect to the login page or homepage
 echo "<script>alert(' Successfully logged out'); window.location.href='../../../index.php';</script>"; // or replace with your preferred page
exit;
?>
    