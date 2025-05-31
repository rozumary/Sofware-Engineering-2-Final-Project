<?php
// This is the logout page for the site.
require './includes/config.inc.php';
require './functions.php';

include './inc/header.php';
include './inc/navbar.php';

// If no first__name session variable exists, redirect the user:
if (!isset($_SESSION['first_name'])) {

    $url = BASE_URL . 'index.php'; // Define the URL.
    ob_end_clean(); // Delete the buffer.
    header("Location: $url");
    exit(); // Quit the script.

} else { //Log out the user.

    $_SESSION = []; // Destroy the variables
    session_destroy(); // Destroy the session itself.
    setcookie(session_name(), '', time()-3600); // Destroy the cookie.

}

// Print the customized message:
// echo '<h3>You are now logged out.</h3> <br />';
// $url = BASE_URL . 'index.php'; // Define the URL.
// header("Location: $url");
// include 'includes/footer.php';

logoutSuccesAllert("Logout Successfully!", "index.php");


?>