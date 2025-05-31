<?php
// view_image.php

// Check if parameters are provided in the URL
if (isset($_GET['id']) && isset($_GET['requirement_name']) && isset($_GET['file_name'])) {
    // Get parameters from the URL
    $id = $_GET['id'];
    $requirement_name = $_GET['requirement_name'];
    $file_name = $_GET['file_name'];

    // Assuming your images are stored in a directory named 'uploads'
    $imagePath = "../uploads/{$file_name}";

    // Check if the file exists
    if (file_exists($imagePath)) {
        // Output appropriate headers for an image
        header('Content-Type: image/jpeg');
        header('Content-Disposition: inline; filename="' . $file_name . '"');
        header('Content-Length: ' . filesize($imagePath));

        // Output the image file
        readfile($imagePath);
        exit;
    } else {
        // Handle the case when the file does not exist
        echo "Image not found.";
    }
} else {
    // Handle the case when parameters are not provided
    echo "Invalid parameters.";
}
