<?php

use Twilio\Rest\Client;

include __DIR__ . '/functions.php';
require __DIR__ . '/vendor/autoload.php';
set_config_inc();

show_header();
// display_navbar();
// display_sidebar();
set_send_email();


require_once('db-connect.php');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "<script> alert('Error: No data to save.'); location.href = 'calendar.php'; </script>";
    $conn->close();
    exit;
}

extract($_POST);

// Find the client based on the provided case number
$clientQuery = $conn->query("SELECT id FROM `clients` WHERE case_number = '$case_number' AND status = 'grant'");
$client = $clientQuery->fetch_assoc();

if (!$client) {
    echo "<script> 
            alert('Client not found for the provided case number/Client should be a probationer before scheduling/or the client is revoked or completed the probation.'); 
            window.history.back(); // Go back to the previous page
        </script>";
        // errorMsg("Client not found!", "{$_SERVER['HTTP_REFERER']}");
    $_POST['title'] = htmlspecialchars($title);
    $_POST['case_number'] = htmlspecialchars($case_number);
    $_POST['description'] = htmlspecialchars($description);
    $_POST['start_datetime'] = htmlspecialchars($start_datetime);
    $_POST['end_datetime'] = htmlspecialchars($end_datetime);


    exit;
} else {
    $client_id = $client['id'];

    $allday = isset($allday);

    // Validate start datetime
    $currentDateTime = new DateTime();
    $startDateTimeObj = new DateTime($start_datetime);

    if (
        $startDateTimeObj <= $currentDateTime ||
        !isTimeInRange($startDateTimeObj) ||
        !isWeekday($startDateTimeObj) ||
        isHoliday($startDateTimeObj)
    ) {
        echo "<script> 
            alert('Invalid start datetime. Please choose a future date and time between Monday to Friday, 8 am and 5 pm, excluding holidays.'); 
            window.history.back(); // Go back to the previous page
        </script>";
        $conn->close();
        exit;
    }

    // Check if the case number is unique within the current month
    $count = isCaseNumberUnique($conn, $case_number, $id);
    if ($count !== 0) {
        echo "<script> 
        alert('Client already have scheduled/attended this month. Please choose a different Month, or maybe you mispelled the case number.'); 
        window.history.back(); // Go back to the previous page
    </script>";
        $conn->close();
        exit;
    }

    // Check if the start and end dates are the same
    if (date('Y-m-d', strtotime($start_datetime)) !== date('Y-m-d', strtotime($end_datetime))) {
        echo "<script> 
            alert('Start and end dates must be the same.'); 
            window.history.back(); // Go back to the previous page
        </script>";
        $conn->close();
        exit;
    }

    // Check if the start and end times are exactly 1 hour apart
    $startDateTime = strtotime($start_datetime);
    $endDateTime = strtotime($end_datetime);

    if ($endDateTime - $startDateTime !== 3600) { // 3600 seconds = 1 hour
        echo "<script> 
            alert('Start and end times must be exactly 1 hour apart.'); 
            window.history.back(); // Go back to the previous page
        </script>";
        $conn->close();
        exit;
    }

    // if (empty($id)) {
    //     $sql = "INSERT INTO `schedule_list` (`title`,`case_number`,`description`,`start_datetime`,`end_datetime`) 
    //             VALUES ('$title','$case_number','$description','$start_datetime','$end_datetime')";
    // } else {
    //     $sql = "UPDATE `schedule_list` 
    //             SET `title` = '{$title}', `case_number` = '{$case_number}', `description` = '{$description}', 
    //                 `start_datetime` = '{$start_datetime}', `end_datetime` = '{$end_datetime}' 
    //             WHERE `id` = '{$id}'";
    // }

    // $save = $conn->query($sql);

    if (empty($id)) {
        $sql = $conn->prepare("INSERT INTO `schedule_list` (`title`,`case_number`,`description`,`start_datetime`,`end_datetime`) 
            VALUES (?, ?, ?, ?, ?)");

        $sql->bind_param("sssss", $title, $case_number, $description, $start_datetime, $end_datetime);
    } else {
        $sql = $conn->prepare("UPDATE `schedule_list` 
            SET `title` = ?, `case_number` = ?, `description` = ?, 
                `start_datetime` = ?, `end_datetime` = ? 
            WHERE `id` = ?");

        $sql->bind_param("sssssi", $title, $case_number, $description, $start_datetime, $end_datetime, $id);
    }

    //Fetch the data from clients table to send email notification
    $email_query = "SELECT email AS e FROM clients WHERE id = $client_id";
    $email_result = $conn->query($email_query);
    $email_row = $email_result->fetch_assoc();
    $email_notif = $email_row['e'];

    //Fetch the data from client_requirements and email based on the user who uploaded the files.
    $e_query = "SELECT uploaded_by AS ub FROM client_requirements WHERE client_id = $client_id";
    $e_result = $conn->query($e_query);
    $e_row = $e_result->fetch_assoc();
    $e_notif = $e_row['ub'];

    $save = $sql->execute();

    if ($save) {

        $url = BASE_URL . 'index.php';

        $subject = 'Appointment Schedule';
        $body = "You have a Scheduled Meeting! on $start_datetime - $end_datetime, For more information. Please<br />
        <a href='$url'>Click here:</a>To visit our website.";


        send_email($e_notif, $subject, $body);

        // Send Sms Message
        $acc_sid = ACC_SID;
        $auth_token = AUTH_TOKEN;

        $twilio_number = "+18635785922";

        $client = new Client($acc_sid, $auth_token);
        $client->messages->create(
            // Where to send a text message (your cell phone?)
            '+639287591634',
            array(
                'from' => $twilio_number,
                'body' => "You have a scheduled appointment on $start_datetime - $end_datetime!"
            )
        );


        // Create notification for users
        $subject = 'Appointment';
        $message = 'You have Scheduled Appointent.';
        createNotification($conn, $client_id, $e_notif, $subject, $message);

        // Create notification for clients

        echo "<script> 
                alert('Schedule Successfully Saved.'); 
                location.href = 'calendar.php'; 
            </script>";
        exit;
    } else {
        echo "<pre>";
        echo "An Error occurred.<br>";
        echo "Error: " . $conn->error . "<br>";
        echo "SQL: " . $sql . "<br>";
        echo "</pre>";
        $_POST['title'] = htmlspecialchars($title);
        $_POST['case_number'] = htmlspecialchars($case_number);
        $_POST['description'] = htmlspecialchars($description);
        $_POST['start_datetime'] = htmlspecialchars($start_datetime);
        $_POST['end_datetime'] = htmlspecialchars($end_datetime);

        // Unset the values
        unset($_POST['title'], $_POST['case_number'], $_POST['description'], $_POST['start_datetime'], $_POST['end_datetime']);
    }
}

$conn->close();


// Function to check if a given time is in the range of 8 am to 5 pm
function isTimeInRange($datetime)
{
    $startOfDay = clone $datetime;
    $startOfDay->setTime(8, 0, 0);

    $endOfDay = clone $datetime;
    $endOfDay->setTime(17, 0, 0);

    return $datetime >= $startOfDay && $datetime <= $endOfDay;
}

// Function to check if a given datetime is a weekday (Monday to Friday)
function isWeekday($datetime)
{
    $dayOfWeek = $datetime->format('N'); // 'N' returns the ISO-8601 numeric representation of the day of the week (1 for Monday, 7 for Sunday)
    return $dayOfWeek >= 1 && $dayOfWeek <= 5;
}





// Function to check if a given datetime is a holiday
function isHoliday($datetime)
{
    // List of holidays (add more as needed)
    $holidays = [
        //Regular Holidays
        '2024-01-01', // New Year's Day
        '2024-12-25', // Christmas Day
        '2024-03-28', // Maundy Thursday
        '2024-03-29', // Good Friday
        '2024-04-09', // Araw ng Kagitingan
        '2024-05-01', // Labor Day
        '2024-06-12', // Independence Day
        '2024-08-26', // National Heroes Day
        '2024-11-30', // Bonifacio Day
        '2024-23-30', // Rizal Day
        // Add more holidays as needed
    ];

    // Format datetime to match the format of the holiday list
    $formattedDatetime = $datetime->format('Y-m-d');

    // Check if the formatted datetime is in the list of holidays
    return in_array($formattedDatetime, $holidays);
}


// Function to check if there's already a schedule with the same case number in the current month
function isCaseNumberUnique($conn, $case_number, $id = null)
{
    global $count;
    $currentMonth = date('m');
    $currentYear = date('Y');

    // If editing an existing record, exclude the current record from the check
    $query = "SELECT COUNT(*) as count FROM `schedule_list` WHERE case_number = ? AND MONTH(start_datetime) = ? AND YEAR(start_datetime) = ?";

    if (!is_null($id)) {
        $query .= " AND id != ?";
    }

    $stmt = $conn->prepare($query);

    if (!is_null($id)) {
        $stmt->bind_param("siii", $case_number, $currentMonth, $currentYear, $id);
    } else {
        $stmt->bind_param("sii", $case_number, $currentMonth, $currentYear);
    }

    $stmt->execute();
    $stmt->store_result(); // Store the result set in memory
    $stmt->bind_result($count); // Bind the result to a variable
    $stmt->fetch(); // Fetch the result

    $stmt->close();

    return $count;
}
