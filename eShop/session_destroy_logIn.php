<?php
if (isset($_SESSION['admin'])) {
    unset($_SESSION['admin']);
    header("Location: LogIn.php");
}

try {

    if (isset($_SESSION['email']) || !isset($_SESSION['email'])) {
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();


    if (empty($_SESSION['email']) || !isset($_SESSION['email'])) {
        $url = 'index.php'; // Replace this with your desired URL
        $delay = 0; // Delay in seconds

        header("refresh:$delay;url=$url");
        exit; // To prevent further execution of the script
    }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}


mysqli_close($conn); // Close the connection

?>