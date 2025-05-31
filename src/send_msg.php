<?php

require __DIR__ . '/vendor/autoload.php';

use Twilio\Rest\Client;

$acc_sid = "AC4a5f53fb793e4141e19456b0307e2bbf";
$auth_token = "1622ae2043bca9214a9ccee11f44e47b";


$twilio_number = "+18635785922";

$client = new Client($acc_sid, $auth_token);
$client->messages->create(
    // Where to send a text message (your cell phone?)
    '+639812515648',
    array(
        'from' => $twilio_number,
        'body' => 'Testing!'
    )
);