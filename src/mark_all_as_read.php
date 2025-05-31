<?php
include __DIR__ . '/functions.php';
set_config_inc();

require(MYSQL);

// Mark all notifications as read
markAllNotificationsAsRead($dbc);

// Redirect back to the previous page (or any desired location)
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
