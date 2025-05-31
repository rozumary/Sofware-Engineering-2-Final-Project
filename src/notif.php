<?php 

require_once __DIR__ . '/vendor/autoload.php';

//Once the NotificationAPI SDK is installed you can use the following code to send your first notification:
use NotificationAPI\NotificationAPI;

$notificationapi = new NotificationAPI(
    '45lpstrfqrk4jut97a09t7ak77', # clientId
    '1q4b1lknasjr3jl0sinuvvlqaduuk5qv7qra0ovi8cpgks7qfrug' # clientSecret
);

$notificationapi->send([
    "notificationId" => "order_tracking",
    "user" => [
    "id" => "seduxer.edgar@yahoo.com",
    "email" => "seduxer.edgar@yahoo.com",
    "number" => "+639287591634" # Replace with your phone number
],
    "mergeTags" => [
    "item" => "2024-17-01",
    "address" => "Laguna Parole and Probation Office",
    "orderId" => "8:00am-9:00am"
]
]);