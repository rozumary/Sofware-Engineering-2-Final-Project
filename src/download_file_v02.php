<?php

include __DIR__ . '/functions.php';
set_config_inc();

show_header();
display_navbar();
display_sidebar();

require(MYSQL);

// The file to download
$file = $_GET['file'];

// Validate and sanitize the file name
$file = htmlspecialchars($file, ENT_QUOTES);
$file = basename($file); // Ensure the file name does not contain any directory traversal attempts

// The path to the file
$file_path = '../uploads/' . $file;

// Check if the file exists
if (!file_exists($file_path)) {
    die(errorMsg("File not found", "{$_SERVER['HTTP_REFERER']}"));
}

// Retrieve the file's MIME type from the database
$query = "SELECT file_type FROM client_requirements WHERE file_name = ?";
$stmt = $dbc->prepare($query);
$stmt->bind_param("s", $file);
$stmt->execute();
$stmt->bind_result($mime_type);
$stmt->fetch();
$stmt->close();

// Set the headers
header('Content-Description: File Transfer');
header('Content-Type: ' . $mime_type);
header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($file_path));

// Read and output the file
readfile($file_path);

exit;
