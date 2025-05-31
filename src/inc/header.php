<?php
include __DIR__ . '/../inc/title.php';

ob_start();

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// if (!isset($_SESSION['user_id'])) {

// 	$url = BASE_URL . 'index.php'; // Define the URL.
// 	ob_end_clean(); // Delete the buffer.
// 	header("Location: $url");
// 	exit(); // Quit the script.

// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard<?php if (isset($title)) {
                        echo "&mdash;{$title}";
                    } ?></title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="./template/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="./template/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="./template/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="./template/assets/vendors/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="./template/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="./template/assets/css/style.css">

    <!-- End layout styles -->
    <link rel="shortcut icon" href="./template/assets/images/favicon.ico" />

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    
    <!-- <script src="https://unpkg.com/notificationapi-js-client-sdk@4.1.0/dist/notificationapi-js-client-sdk.js"></script>
    <link href="https://unpkg.com/notificationapi-js-client-sdk@4.1.0/dist/styles.css" rel="stylesheet" /> -->


</head>