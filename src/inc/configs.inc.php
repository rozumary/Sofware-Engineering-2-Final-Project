<?php
/* This script:
3 * - define constants and settings
4 * - dictates how errors are handled
5 * - defines useful functions
6 */

// Document who created this site, when, why, etc.


// ********************************** //
// ************ SETTINGS ************ //

// Flag variable for site status:
define('LIVE', FALSE);

// Admin contact address:
define('EMAIL', 'InsertRealAddressHere');

// Site URL (base for all redirections):
define('BASE_URL', 'http://localhost/probation_project_v07/');

// Location of the MySQL connection script:
// define('MYSQL', 'C:/xampp/htdocs/php_dynamic_websites/chap18/mysqli_connect.php');
define('MYSQL', 'mysqli_connect.php');
$pdo = new PDO('mysql:host=localhost;dbname=probation', 'root', '');

//define('DB', '/path/to/db_connect.php');

// Adjust the time zone for PHP.
date_default_timezone_set('Asia/Hong_kong');

// ************ SETTINGS ************ //
// ********************************** //


// ****************************************** //
// ************ ERROR MANAGEMENT ************ //

// Create the error handler:
function my_error_handler($e_number, $e_message, $e_file, $e_line, $e_vars) {
    // Build the error message:
    $message = "An error occured in script '$e_file' on line $e_line: $e_message\n";

    // Add the date and time:
    $message .= "Date/Time: " . date('n-j-Y H:i:S') . "\n";

    // Define a default value for the $LIVE variable:
    $LIVE = false;

    if (!$LIVE) { // Developement (print the error)

      // Show the error message:
    echo '<div class="error">' . nl2br(htmlspecialchars($message));

      // Add the variables and a backtrace:
    echo '<pre>' . print_r($e_vars, 1) . "\n";
    debug_print_backtrace();
    echo '</pre></div>';

    } else { // Don't show the error

      // Send an email to the admin:
    $body = $message . "\n" . print_r($e_vars, 1);
    mail(EMAIL, 'Site Error!', $body, 'From: email@example.com');

      // Only print an error message if the error isn't a notice:
    if ($e_number != E_NOTICE) {
        echo '<div class="error">A system error occured. We apologize for the inconvenience.</div><br/>';
    }
} // End of !LIVE IF.

} // End of my_error_handler();

// ************ ERROR MANAGEMENT ************ //
// ****************************************** //