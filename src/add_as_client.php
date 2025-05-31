<?php

include __DIR__ . '/functions.php';

set_config_inc();

show_header();
display_navbar();
display_sidebar();

require(MYSQL);

$email = $_SESSION['email'];
$user_id = $_SESSION['user_id'];

// Get the client ID from the URL parameter
$clientID = (isset($_GET['id']) && is_numeric($_GET['id'])) ? $_GET['id'] : null;

if (!$clientID) {
    die(errorMsg("Invalid Client ID", "{$_SERVER['HTTP_REFERER']}"));
    exit;
}

// Update the clients table
$update_client_query = "UPDATE clients SET caretaker_user_id='$user_id' WHERE id='$clientID'";
$update_client_result = mysqli_query($dbc, $update_client_query);

if (!$update_client_result) {
    // Handle database error
    errorMsg("An error occurred!", "user_dashboard.php");
    exit;
}

// Update the users table
$update_user_query = "UPDATE users SET client='$clientID' WHERE user_id='$user_id'";
$update_user_result = mysqli_query($dbc, $update_user_query);


if ($update_client_result) :
    success("Successfully added as your Client", "user_dashboard.php");
    exit;
else:
    errorMsg("An Error occurred", "user_dashboard.php");
endif;

