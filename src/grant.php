<?php

use Twilio\Rest\Client;

use Infobip\Configuration;
use Infobip\Api\SmsApi;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use Infobip\Model\SmsAdvancedTextualRequest;


include __DIR__ . '/functions.php';
require __DIR__ . '/vendor/autoload.php';
set_config_inc();


show_header();
display_navbar();
display_sidebar();
set_send_email();

require(MYSQL);

$email = $_SESSION['email'];

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    // Retrieve selected probation duration
    $probationDuration = $_POST['probation_duration'];

    // Get the client ID from the URL parameter
    $clientID = (isset($_GET['id']) && is_numeric($_GET['id'])) ? $_GET['id'] : null;

    if (!$clientID) {
        // Handle invalid or missing client ID
        // Redirect or display an error message
        // header("Location: error.php");
        die(errorMsg("Invalid Request", "{$_SERVER['HTTP_REFERER']}"));
        exit();
    }

    // Check if the client_id already exists in grant_clients
    $checkQuery = "SELECT COUNT(*) as count FROM grant_clients WHERE client_id = $clientID";
    $checkResult = mysqli_query($dbc, $checkQuery);
    $row = mysqli_fetch_assoc($checkResult);
    $count = $row['count'];

    if ($count > 0) {
        // Client ID already exists in grant_clients, handle accordingly
        die(errorMsg("Duplicate Entry", "{$_SERVER['HTTP_REFERER']}"));
        exit();
    }

    // Update the client status to 'grant'
    $updateQuery = "UPDATE clients SET status = 'grant' WHERE id = $clientID";
    $updateResult = mysqli_query($dbc, $updateQuery);

    // Fetch data from  client_requirements
    $cr_query = "SELECT uploaded_by as ub FROM client_requirements WHERE client_id = $clientID";
    $cr_result = $dbc->query($cr_query);
    $cr_row = $cr_result->fetch_assoc();
    $cr = $cr_row['ub'];

    $url = BASE_URL . 'index.php';

    $subject = 'Application Status';
    $body = "Congrats! The good news is that your application for probation has been successfully granted!<br />
    <a href='$url'>Click here:</a>To visit our website.";


    send_email($cr, $subject, $body);

    // Send Sms Message twilio
    // $acc_sid = ACC_SID;
    // $auth_token = AUTH_TOKEN;

    // $msg = "Congrats! The good news is that your application for probation has been successfully granted!<br />
    // <a href='$url'>Click here:</a>To visit our website.";

    // $twilio_number = "+18635785922";

    // $client = new Client($acc_sid, $auth_token);
    // $client->messages->create(
    //     // Where to send a text message (your cell phone?)
    //     '+639287591634',
    //     array(
    //         'from' => $twilio_number,
    //         'body' => "Congrats! The good news is that your application for probation has been succesfully granted!"
    //     )
    // );


    $base_url = "l3wnqw.api.infobip.com";
    $api_key = "ba52cab20cf87a990dc9e830aa9a25e7-4e015f48-d3f7-4b01-8c6e-859a1844f58c";

    $msg = "Congrats! The good news is that your application for probation has been successfully granted!
    visit our website for more info. $url";

    $number = '+639812515648';

    $configuration = new Configuration(host: $base_url, apiKey: $api_key);

    $api = new SmsApi(config: $configuration);

    $destination = new SmsDestination(to: $number);

    $msg = new SmsTextualMessage(
        destinations: [$destination],
        text: $msg,
        from: "admin_lppo"
    );

    $request = new SmsAdvancedTextualRequest(messages: [$msg]);

    $response = $api->sendSmsMessage($request);

    


    if ($updateResult) {

        // Check if client_id exists again (double-check)
        $checkResult = mysqli_query($dbc, $checkQuery);
        $row = mysqli_fetch_assoc($checkResult);
        $count = $row['count'];

        if ($count > 0) {
            // Client ID already exists in grant_clients, handle accordingly
            die(errorMsg("Duplicate Entry", "{$_SERVER['HTTP_REFERER']}"));
            exit();
        }

        $grant_query = "INSERT INTO grant_clients (client_id, date_granted, granted_by, probation_duration) VALUES ('$clientID', NOW(), '$email', '$probationDuration')";
        $grant_result = mysqli_query($dbc, $grant_query);

        if ($grant_result) {
            // Successfully updated status
            // Redirect or display a success message
            // header("Location: petitioners_list_v02.php");

            $message = "Congrats! Application is...";
            createNotification($dbc, $clientID, $cr, 'Granted', $message);

            success("Successfully granted!", "petitioners_list_v02.php");
            exit();
        }
    } else {
        // Failed to update status
        // Handle the error
        echo "Error updating status: " . mysqli_error($dbc);
        exit();
    }
}

?>

<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Grant</h3>
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
                                <h5 class="card-title">Grant Petitioner</h5>
                                

                                <form action="grant.php?id=<?php echo $_GET['id']; ?>" method="post">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="probation_duration">Probation Duration:</label>
                                            <select class="form-select" name="probation_duration" id="probation_duration">
                                                <option value="6">6 months</option>
                                                <option value="12">1 year</option>
                                                <option value="24">2 years</option>
                                                <option value="36">3 years</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Grant Probation</button>
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