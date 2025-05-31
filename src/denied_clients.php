<?php
// Include necessary files and initialize your session
include __DIR__ . '/functions.php';
set_config_inc();

show_header();
display_navbar();
display_sidebar();
set_send_email();

require(MYSQL);

$userLevel = $_SESSION['user_level'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize inputs
    $clientId = isset($_POST['client_id']) ? (int)$_POST['client_id'] : 0;
    $reason = isset($_POST['reason']) ? trim($_POST['reason']) : '';

    // Check if the client_id already exists in denied_clients
    $checkQuery = "SELECT COUNT(*) FROM denied_clients WHERE client_id = ?";
    $checkStmt = $dbc->prepare($checkQuery);
    $checkStmt->bind_param("i", $clientId);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();  // Close the statement to free up resources

    if ($count > 0) {
        // Client_id already exists, show an error message
        errorMsg("Client already denied. Duplicate denial entry not allowed.", "petitioners_list_v02.php");
    } else {
        // Perform database update
        $updateQuery = "UPDATE clients SET status = 'denied' WHERE id = ?";
        $stmt = $dbc->prepare($updateQuery);
        $stmt->bind_param("i", $clientId);

        if ($stmt->execute()) {
            // Store the result set
            $stmt->store_result();

            // Insert denial details into denied_clients table
            $insertQuery = "INSERT INTO denied_clients (client_id, reason, date_denied, denied_by) VALUES (?, ?, NOW(), ?)";
            $stmt = $dbc->prepare($insertQuery);
            $stmt->bind_param("iss", $clientId, $reason, $_SESSION['email']);

            if ($stmt->execute()) {

                // Fetch data from client_requirements
                $cr_query = "SELECT uploaded_by as ub FROM client_requirements WHERE client_id = $clientId";
                $cr_result = $dbc->query($cr_query);
                $cr_row = $cr_result->fetch_assoc();
                $cr = $cr_row['ub'];

                //Fetch the data from clients
                $client_query = "SELECT email as em FROM clients WHERE id = $clientId";
                $client_result = $dbc->query($client_query);
                $client_row = $client_result->fetch_assoc();
                $client_email = $client_row['em'];

                $url = BASE_URL . 'index.php';

                $recipients = ["$cr", "$client_email"];
                $subject = 'Application Status';
                $body = "We're sorry, but your application has not been approved!<br />
                for more info, <a href='$url'>Click here:</a>To visit our website.";

                send_email($recipients, $subject, $body);

                $message = "Sorry, Application denied";
                createNotification($dbc, $clientId, $cr, 'Application Denied', $message);

                // Denial successfully recorded
                success("Client denied successfully recorded!", "petitioners_list_v02.php");
                exit();
            } else {
                // Handle the error appropriately
                error("Error recording denial details.");
            }
        } else {
            // Handle the error appropriately
            error("Error updating client status.");
        }
    }

} else {
    // Display the denial form
    $clientId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
?>

    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title">Denied</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo $userLevel == 1 ? 'admin_dashboard.php' : 'user_dashboard.php'; ?>">Dashboard</a></li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Denied Petitioner</h5>
                                    <hr />

                                    <!-- Denial Form -->
                                    <form method="post">
                                        <div class="mb-3">
                                            <input type="hidden" name="client_id" value="<?= $clientId ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="reason" class="form-label">Reason for Denial:</label>
                                            <textarea class="form-control" name="reason" id="reason" rows="4" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit Denial</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>

<?php
}

// ... Additional HTML/PHP code ...
?>