<?php
include __DIR__ . '/functions.php';
set_config_inc();

show_header();
display_navbar();
display_sidebar();

require(MYSQL);

if (isset($_GET['file'])) {
    $file = $_GET['file'];
    $filePath = '../uploads/' . $file;

    // Check if the file exists
    if (!file_exists($filePath)) {
        die(errorMsg("File not found", "{$_SERVER['HTTP_REFERER']}"));
    }

    // Check if the file exists
    if (file_exists($filePath)) {
        // Get the file extension
        $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        // Map file extensions to content types
        $contentTypeMap = [
            'pdf'  => 'application/pdf',
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png'  => 'image/png',
            // Add more mappings for other file types if needed
        ];

        // Set the appropriate headers based on file extension
        if (isset($contentTypeMap[$fileExtension])) {
            header('Content-Type: ' . $contentTypeMap[$fileExtension]);
        } else {
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        }

        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));

        ob_clean(); // Clear output buffer
        flush();    // Flush output buffer

        // Read the file and output it to the browser
        readfile($filePath);
    } else {
        // File not found, redirect to an error page or display a user-friendly message
        errorMsg("File not found: $file", "{$_SERVER['HTTP_REFERER']}");
    }
} else {
    // No file specified, redirect to an error page or display a user-friendly message
    errorMsg('Invalid request.', "{$_SERVER['HTTP_REFERER']}");
}
