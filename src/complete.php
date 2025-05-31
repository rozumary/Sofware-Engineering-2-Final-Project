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

// Get the client ID from the URL parameter
$clientID = (isset($_GET['id']) && is_numeric($_GET['id'])) ? $_GET['id'] : null;

if (!$clientID) {
    // Handle invalid or missing client ID
    // Redirect or display an error message
    // header("Location: error.php");
    die(errorMsg("Invalid Request", "{$_SERVER['HTTP_REFERER']}"));
    exit();
}

// Check if the client_id already exists in completed_client
$checkQuery = "SELECT COUNT(*) as count FROM completed_client WHERE client_id = $clientID";
$checkResult = mysqli_query($dbc, $checkQuery);
$row = mysqli_fetch_assoc($checkResult);
$count = $row['count'];

if ($count > 0) {
    // Client ID already exists in completed_client, handle accordingly
    die(errorMsg("Duplicate Entry is not allowed", "{$_SERVER['HTTP_REFERER']}"));
    exit();
}

// Update the client status to 'grant'
$updateQuery = "UPDATE clients SET status = 'completed' WHERE id = $clientID";
$updateResult = mysqli_query($dbc, $updateQuery);

//Fetch the data from clients table to send email notification
$email_query = "SELECT email as e FROM clients WHERE id = $clientID";
$email_result = $dbc->query($email_query);
$email_row = $email_result->fetch_assoc();
$email_notif = $email_row['e'];

//Fetch the data from client_requirements and email based on the user who uploaded the files.
$e_query = "SELECT uploaded_by as ub FROM client_requirements WHERE client_id = $clientID";
$e_result = $dbc->query($e_query);
$e_row = $e_result->fetch_assoc();
$e_notif = $e_row['ub'];

$url = BASE_URL . 'index.php';

$recipients = ["$email_notif", "$e_notif"];
$subject = 'Probation Completed';
$body = 'I am thrilled to share the exciting news that you have successfully completed the probation program.<br /> 
This journey has been transformative, and I am grateful for the support and guidance provided throughout.<br />
Thank you for the opportunity to learn, grow, and demonstrate commitment to positive change.<br />
I look forward to apply the lessons you gained during this period as you move forward on your path.<br />
<br />
Best regards,';

send_email($recipients, $subject, $body);

if ($updateResult) {
    // Check if client_id exists again (double-check)
    $checkResult = mysqli_query($dbc, $checkQuery);
    $row = mysqli_fetch_assoc($checkResult);
    $count = $row['count'];

    if ($count > 0) {
        // Client ID already exists in completed_client, handle accordingly
        die(errorMsg("Duplicate Entry.", "{$_SERVER['HTTP_REFERER']}"));
        exit();
    }

    // Insert into completed_client
    $complete_query = "INSERT INTO completed_client (client_id, date_completed, completed_by) VALUES ('$clientID', NOW(), '$email')";
    $complete_result = mysqli_query($dbc, $complete_query);

    if ($complete_result) {

        $message = "Congrats! You completed...";
        createNotification($dbc, $clientID, $e_notif, 'Completed', $message); //client requirements based on who's user uploaded.

        // // Send Sms Message TWILIO
        // $acc_sid = ACC_SID;
        // $auth_token = AUTH_TOKEN;

        // $twilio_number = "+18635785922";

        // $client = new Client($acc_sid, $auth_token);
        // $client->messages->create(
        //     // Where to send a text message (your cell phone?)
        //     '+639287591634',
        //     array(
        //         'from' => $twilio_number,
        //         'body' => "I am thrilled to share the exciting news that you have successfully completed the probation program."
        //     )
        // );


        $base_url = "l3wnqw.api.infobip.com";
        $api_key = "ba52cab20cf87a990dc9e830aa9a25e7-4e015f48-d3f7-4b01-8c6e-859a1844f58c";

        $msg = "I am thrilled to share the exciting news that you have successfully completed the probation program. Please visit our website for more information $url";

        $number = '+639287591634';

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

        // Successfully updated status and inserted into completed_client
        success("Successfully completed client!", "completed_list.php");
        exit();
    } else {
        // Failed to insert into completed_client
        echo "Error inserting into completed_client: " . mysqli_error($dbc);
        exit();
    }
} else {
    // Failed to update status
    echo "Error updating status: " . mysqli_error($dbc);
    exit();
}
