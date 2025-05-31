<?php

use Twilio\Rest\Client;

include __DIR__ . '/functions.php';
require __DIR__ . '/vendor/autoload.php';
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
    $checkQuery = "SELECT COUNT(*) FROM revoked_clients WHERE client_id = ?";
    $checkStmt = $dbc->prepare($checkQuery);
    $checkStmt->bind_param("i", $clientId);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();  // Close the statement to free up resources

    if ($count > 0) {
        // Client_id already exists, show an error message
        errorMsg("Client already revoked. Duplicate entry is not allowed.", "revoked_list.php");
    } else {
        // Perform database update
        $updateQuery = "UPDATE clients SET status = 'revoked' WHERE id = ?";
        $stmt = $dbc->prepare($updateQuery);
        $stmt->bind_param("i", $clientId);

        if ($stmt->execute()) {
            // Store the result set
            $stmt->store_result();

            // Insert denial details into denied_clients table
            $insertQuery = "INSERT INTO revoked_clients (client_id, reason, date_revoked, revoked_by) VALUES (?, ?, NOW(), ?)";
            $stmt = $dbc->prepare($insertQuery);
            $stmt->bind_param("iss", $clientId, $reason, $_SESSION['email']);

            if ($stmt->execute()) {

                // Fetch data from client_requirements
                $rc_query = "SELECT uploaded_by as ub FROM client_requirements WHERE client_id = $clientId";
                $rc_result = $dbc->query($rc_query);
                $rc_row = $rc_result->fetch_assoc();
                $rc = $rc_row['ub'];

                //Fetch the data from clients
                $client_query = "SELECT email as em FROM clients WHERE id = $clientId";
                $client_result = $dbc->query($client_query);
                $client_row = $client_result->fetch_assoc();
                $client_email = $client_row['em'];

                $url = BASE_URL . 'index.php';

                $recipients = ["$rc", "$client_email"];
                $subject = 'Application Status';
                $body = "We're sorry, but your prationary status has been revoked!<br />
                for more info, <a href='$url'>Click here:</a>To visit our website.";

                send_email($recipients, $subject, $body);

                $acc_sid = ACC_SID;
                $auth_token = AUTH_TOKEN;

                $twilio_number = "+18635785922";

                $client = new Client($acc_sid, $auth_token);
                $client->messages->create(
                    // Where to send a text message (your cell phone?)
                    '+639287591634',
                    array(
                        'from' => $twilio_number,
                        'body' => "We're sorry, but your prationary status has been revoked!"
                    )
                );

                
                $message = "Sorry, but your probation...";
                createNotification($dbc, $clientId, $rc, 'Revoked', $message);

                // Denial successfully recorded
                success("Client revoked successfully recorded!", "revoked_list.php");
                exit();
            } else {
                // Handle the error appropriately
                error("Error recording revoked details.");
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
                <h3 class="page-title">Revoked Probation</h3>
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
                                    <h5 class="card-title">Revoked Probationer</h5>
                                    

                                    <!-- Denial Form -->
                                    <form method="post">
                                        <div class="mb-3">
                                            <input type="hidden" name="client_id" value="<?= $clientId ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="reason" class="form-label">Reason for Revocation:</label>
                                            <textarea class="form-control" name="reason" id="reason" rows="4" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit Revoked</button>
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