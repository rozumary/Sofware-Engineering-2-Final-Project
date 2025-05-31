<?php

include __DIR__ . '/functions.php';
set_config_inc();

show_header();
display_navbar();
display_sidebar();

// $email = $_SESSION['email'];


require(MYSQL);

// Check if the 'id' and 'requirement_name' parameters are set in the URL
if (isset($_GET['id']) && isset($_GET['requirement_name'])) {
    $id = mysqli_real_escape_string($dbc, $_GET['id']);
    $requirement_name = mysqli_real_escape_string($dbc, $_GET['requirement_name']);

    // Check the current status in the database
    $checkStatusQuery = "SELECT uploaded_by, status FROM client_requirements WHERE client_id = $id AND requirement_name = '$requirement_name'";
    $checkStatusResult = mysqli_query($dbc, $checkStatusQuery);

    if ($checkStatusResult) {
        // Check if there are rows to fetch
        if ($statusRow = mysqli_fetch_assoc($checkStatusResult)) {
            $email = $statusRow['uploaded_by'];

            // Check if the status is not already "valid"
            if ($statusRow['status'] !== 'valid') {
                // Update the status in the database
                $updateQuery = "UPDATE client_requirements SET status = 'valid' WHERE client_id = $id AND requirement_name = '$requirement_name'";
                $updateResult = mysqli_query($dbc, $updateQuery);
                
                
                if ($updateResult) {
                    // Create notification
                    // $email = $statusRow['uploaded_by'];
                    // $subject = 'Valid File';
                    $message = "{$requirement_name} is valid!";
                    createNotification($dbc, $id, $email, "Valid File", $message);
                    

                    // Redirect back to the view_details.php page after updating the status
                    success(
                        "validated!",
                        "view_details.php?id=$id"
                    );
                    exit();
                } else {
                    echo "Error updating status: " . mysqli_error($dbc);
                }
            } else {
                errorMsg("file is already valid", "view_details.php?id=$id");
            }
        } else {
            // Handle the case where there are no rows to fetch
            errorMsg("No record found", "{$_SERVER['HTTP_REFERER']}");
        }
    } else {
        echo "Error checking status: " . mysqli_error($dbc);
    }
} else {
    errorMsg("Invalid request", "{$_SERVER['HTTP_REFERER']}");
}

