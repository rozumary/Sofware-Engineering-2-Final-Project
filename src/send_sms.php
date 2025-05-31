<?php

include __DIR__ . '/functions.php';
require __DIR__ . '/vendor/autoload.php';

use Twilio\Rest\Client;

set_config_inc();

show_header();
display_navbar();
display_sidebar();


require(MYSQL);

$userLevel = $_SESSION['user_level'];

    // Default country code
    $defaultCountryCode = '+63';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate phone number and message
    $number = isset($_POST['number']) ? $_POST['number'] : false;
    $msg = isset($_POST['message']) ? $_POST['message'] : false;

    // Check if both phone number and message are valid
    if ($number && $msg) {

        if (strpos($number, '+63') !== 0) {
            $number = '+63' . ltrim($number, '+'); // Add '+63' if not already present
        }

        $account_id = "AC4a5f53fb793e4141e19456b0307e2bbf";
        $auth_token = "1622ae2043bca9214a9ccee11f44e47b";

        $client = new Client($account_id, $auth_token);

        $twilio_number = "+18635785922";

        $client->messages->create(
            $number,
            [
                "from" => $twilio_number,
                "body" => $msg
            ]
        );

        // echo "Message sent.";
        success("Message Successfully Sent", 'sms_form.php');
    } else {
        // echo "Invalid phone number or message.";
        errorMsg("Invalid phone number or message", 'sms_form.php');
    }
} else {
    // echo "Invalid request method.";
    // error('Invalid request method');
}
?>

<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Dashboard</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href=<?php echo $userLevel == 1 ? 'admin_dashboard.php' : 'user_dashboard.php'; ?>>Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Send Message</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-16 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Send SMS</h5>
                                

                                <div class="container">
                                    <form action="send_sms.php" method="post">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="number" class="font-weight-bold text-dark">Number:</label><br>
                                                <input type="text" name="number" id="number" value="+63">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-10">
                                                <label for="message" class="font-weight-bold text-dark">Message:</label><br>
                                                <textarea name="message" id="message" cols="40" rows="5"></textarea>
                                            </div>
                                        </div><br>
                                        <button type="submit" class="btn btn-primary btn-fw">Send</button>
                                    </form>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->




    <?php show_footer(); ?>