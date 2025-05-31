<?php
include __DIR__ . '/functions.php';
set_config_inc();

require(MYSQL);

// Check if the 'id' and 'requirement_name' parameters are set in the URL
if (isset($_GET['id']) && isset($_GET['requirement_name'])) {
    $id = mysqli_real_escape_string($dbc, $_GET['id']);
    $requirement_name = mysqli_real_escape_string($dbc, $_GET['requirement_name']);

    // Check if the file exists in the database
    $checkFileQuery = "SELECT id, file_name FROM client_requirements WHERE client_id = $id AND requirement_name = '$requirement_name'";
    $checkFileResult = mysqli_query($dbc, $checkFileQuery);

    if ($checkFileResult && mysqli_num_rows($checkFileResult) > 0) {
        $fileRow = mysqli_fetch_assoc($checkFileResult);

        // File path
        $filePath = '../uploads/' . $fileRow['file_name'];

        // Check if the file exists before attempting to delete
        if (file_exists($filePath)) {
            // Attempt to delete the file
            if (unlink($filePath)) {
                // Delete record from the database
                $deleteFileQuery = "DELETE FROM client_requirements WHERE id = {$fileRow['id']}";
                $deleteFileResult = mysqli_query($dbc, $deleteFileQuery);

                // Update the status in the clients table to NULL
                $updateClientQuery = "UPDATE clients SET status = NULL WHERE id = $id";
                $updateClientResult = mysqli_query($dbc, $updateClientQuery);

                if ($deleteFileResult && $updateClientResult) {
                    // Redirect back to the view_details.php page after updating the status
                    header("Location: view_details.php?id=$id");
                    exit();
                } else {
                    echo "Error updating status: " . mysqli_error($dbc);
                }
            } else {
                echo "Error deleting file.";
            }
        } else {
            echo "File not found.";
        }
    } else {
        echo "Error checking file: " . mysqli_error($dbc);
    }
} else {
    echo "Invalid request.";
}
