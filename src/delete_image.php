<?php
include __DIR__ . '/functions.php';
set_config_inc();

show_header();
display_navbar();
display_sidebar();

require(MYSQL);

$userLevel = $_SESSION['user_level'];

if (
    isset($_GET['id']) && is_numeric($_GET['id']) &&
    isset($_GET['requirement_name']) && !empty($_GET['requirement_name'])
) {
    $id = $_GET['id'];
    $requirement_name = $_GET['requirement_name'];

    // Check if the file exists in the database
    $checkFileQuery = "SELECT id, file_name FROM client_requirements WHERE client_id = ? AND requirement_name = ?";
    $checkFileStmt = $dbc->prepare($checkFileQuery);
    $checkFileStmt->bind_param("is", $id, $requirement_name);
    $checkFileStmt->execute();
    $checkFileStmt->store_result();

    if ($checkFileStmt->num_rows > 0) {
        $checkFileStmt->bind_result($fileId, $fileName);
        $checkFileStmt->fetch();

        // Check if the file exists in the uploads directory
        $filePath = '../uploads/' . $fileName;
        if (file_exists($filePath)) {
            // Delete file from uploads directory
            unlink($filePath);
        }

        // Delete record from the database
        $deleteFileQuery = "DELETE FROM client_requirements WHERE id = ?";
        $deleteFileStmt = $dbc->prepare($deleteFileQuery);
        $deleteFileStmt->bind_param("i", $fileId);
        $deleteFileStmt->execute();
        $deleteFileStmt->close();

        // Update status to "invalid" for user_level 1
        if ($userLevel == 1) {
            $updateStatusQuery = "UPDATE clients SET status = 'invalid' WHERE id = ?";
            $updateStatusStmt = $dbc->prepare($updateStatusQuery);
            $updateStatusStmt->bind_param("i", $id);
            $updateStatusStmt->execute();
            $updateStatusStmt->close();
        }

        // Redirect to the previous page
        success("Successfully Deleted!", "{$_SERVER['HTTP_REFERER']}");
        exit();
    } else {
        // No valid file found
        errorMsg("No valid file found!", "{$_SERVER['HTTP_REFERER']}");
        exit();
    }
}

// If the file or client ID is not valid, redirect to the dashboard or homepage
errorMsg("Something went wrong!", "upload_requirements.php?id={$id}");
// header("Location: {$_SERVER['HTTP_REFERER']}");
exit();
// header("Location: " . ($userLevel == 1 ? 'admin_dashboard.php' : 'user_dashboard.php'));
// exit();
