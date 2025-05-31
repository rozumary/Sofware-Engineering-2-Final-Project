<?php
include __DIR__ . '/functions.php';
set_config_inc();

require(MYSQL);

// Validate notificationId
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    // Invalid input; handle the error, log it, or redirect to an error page.
    echo "Invalid notification ID.";
    exit();
}

// Sanitize the notification ID
$notificationId = intval($_GET['id']);

// Now you can safely use $notificationId in your database query
markNotificationAsRead($dbc, $notificationId);

// Redirect back to the previous page (e.g., the page with the notifications).
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();

// $notificationId = $_GET['id']; // Ensure proper validation and sanitation.
// markNotificationAsRead($dbc, $notificationId);

// // Redirect back to the previous page (e.g., the page with the notifications).
// header("Location: " . $_SERVER['HTTP_REFERER']);
// exit();
