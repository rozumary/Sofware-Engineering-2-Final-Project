<?php

// Check if password is strong


function isPasswordStrong($password)
{
    $min_length       = 10; //* Minimun length
    $has_lowecase     = preg_match('/[a-z]/', $password); //* Check for lowercase letters
    $has_uppercase    = preg_match('/[A-Z]/', $password); //* Check for uppercase letters
    $has_digit        = preg_match('/\d/', $password); //* Check for digits
    $has_special_char = preg_match('/[^a-zA-Z\d]/', $password); //* Check for special characters

    //* Check if all criteria are met
    return strlen($password) >= $min_length &&
        $has_lowecase &&
        $has_uppercase &&
        $has_digit &&
        $has_special_char;
}


function validateNumber($phoneNumber)
{
    // Remove non-numeric characters from the phone number
    $cleanedNumber = preg_replace('/\D/', '', $phoneNumber);

    // Check if the cleaned number is exactly 12 digits
    if (strlen($cleanedNumber) === 12) {
        // Format the number to '+639287591634'
        return '+63' . substr($cleanedNumber, 1);
    } else {
        // Invalid phone number
        return false;
    }
    return false; // Invalid phone number
    // }

    // return $phoneNumber;
}


//* function for validating contact number
function validatePhoneNumber($phoneNumber)
{
    // Remove non-numeric characters from the phone number
    $cleanedNumber = preg_replace('/\D/', '', $phoneNumber);

    // Philippine mobile number regex pattern
    $pattern = '/^(09|\+639)\d{9}$/';
    $formattedPhoneNumber = substr($phoneNumber, 0, 4) . '-' . substr($phoneNumber, 4, 3) . '-' . substr($phoneNumber, 6, 4);

    // Check if the cleaned number matches the pattern and contains exactly 11 digits
    if (preg_match($pattern, $cleanedNumber, $formattedPhoneNumber) && strlen($cleanedNumber) === 11) {
        return true; // Valid Philippine phone number
    } else {
        return false; // Invalid phone number
    }
}

// Function to get client requirements status
function getClientRequirementsStatus($clientId)
{
    global $dbc;

    $query = "SELECT COUNT(id) AS fileCount FROM client_requirements WHERE client_id = $clientId AND status = 'valid'";
    $result = mysqli_query($dbc, $query);

    if (!$result) {
        // Handle the database error here
        echo "Error in query: " . mysqli_error($dbc);
        return 0;
    }

    $row = mysqli_fetch_assoc($result);
    $fileCount = $row['fileCount'];

    // echo "Client ID: $clientId, Valid File Count: $fileCount";

    return $fileCount;
}

function get_file_count($clientId)
{

    global $dbc;

    $q = "SELECT COUNT(id) AS file_count FROM client_requirements WHERE client_id = $clientId";
    $r = mysqli_query($dbc, $q);

    if (!$r) {
        die(error('Invalid'));
        return 0;
    }

    $row = mysqli_fetch_assoc($r);
    $file_count = $row['file_count'];

    return $file_count;
}


function handleFileUpload($fileField, $requirementName, $id, $email)
{
    global $dbc;

    if (isset($_FILES[$fileField])) {
        $fileName = $_FILES[$fileField]['name'];
        $fileTempName = $_FILES[$fileField]['tmp_name'];
        $fileSize = $_FILES[$fileField]['size'];
        $fileError = $_FILES[$fileField]['error'];
        $fileType = $_FILES[$fileField]['type'];

        if ($fileError === 0) {
            if ($fileSize <= 20 * 1024 * 1024) { // 1024000 = 1 MB // 20 * 1024 * 1024 = 20MB
                $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif');
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                if (in_array($fileExt, $allowedFileTypes)) {
                    $uploadDir = '../uploads/';
                    $newFileName = $id . '_' . $requirementName . '.' . $fileExt;
                    $destination = $uploadDir . $newFileName;

                    $checkQuery = "SELECT id FROM client_requirements WHERE client_id = ? AND file_name = ?";
                    $checkStmt = $dbc->prepare($checkQuery);
                    $checkStmt->bind_param("is", $id, $newFileName);
                    $checkStmt->execute();
                    $checkStmt->store_result();

                    if ($checkStmt->num_rows > 0) {
                        error('File already exists');
                        // echo "<p class='text-danger'>File already exists.</p>";
                    } else {
                        if (move_uploaded_file($fileTempName, $destination)) {
                            $status = 'pending';

                            $insertQuery = "INSERT INTO client_requirements (client_id, requirement_name, file_name, file_type, file_size, status, uploaded_by, upload_date) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
                            $stmt = $dbc->prepare($insertQuery);
                            $stmt->bind_param("issssss", $id, $requirementName, $newFileName, $fileType, $fileSize, $status, $email);
                            $stmt->execute();
                            $stmt->close();
                            
                            //Admin 1
                            $subject = 'New Uploaded File';
                            $message = "{$email}";
                            $email1 = 'montesarose@gmail.com';
                            createNotification($dbc, $id, $email1, $subject, $message);

                            $subject = 'New Uploaded File';
                            $message = "{$email}";
                            $email2 = 'montesarose@gmail.com';
                            createNotification($dbc, $id, $email2, $subject, $message);

                            succesMsg("File uploaded successfully");
                        } else {
                            error('Error uploading file.');
                        }
                    }

                    $checkStmt->close();
                } else {
                    error('Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.');
                }
            } else {
                error('File size exceeds the limit of 1 MB.');
            }
        } else {
            error('File is empty, Error uploading');
        }
    }
}


// Function to hide the name and display asterisks
function hideName($name)
{
    $length = strlen($name);
    $visibleChars = min(2, $length); // Set the number of characters to reveal (e.g., 2 characters)

    $hiddenPart = str_repeat('*', $length - $visibleChars);

    return substr_replace($name, $hiddenPart, $visibleChars);
}


function createNotification($dbc, $client_id, $email, $subject, $message)
{
    // Prepare and execute query
    $query = "INSERT INTO notifications (client_id, email, subject, message) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt, "isss", $client_id, $email, $subject, $message);
    mysqli_stmt_execute($stmt);

    // Close connection
    mysqli_stmt_close($stmt);
    // mysqli_close($dbc);

    //createNotification($dbc, 'user@example.com', 'Appointment', 'You have an upcoming appointment.')
}


function getUnreadNotifications($dbc, $email)
{
    //global $dbc;

    $query = "SELECT id, client_id, subject, message, created_at FROM notifications WHERE email = ? AND is_read = 0";
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $notifications = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_stmt_close($stmt);
    // mysqli_close($dbc);

    return $notifications;
}


function markNotificationAsRead($dbc, $notificationId)
{
    $query = "UPDATE notifications SET is_read = 1 WHERE id = ?";
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt, "i", $notificationId);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
}


function markAllNotificationsAsRead($dbc)
{
    $query = "UPDATE notifications SET is_read = 1";
    $result = mysqli_query($dbc, $query);

    if (!$result) {
        // Handle the error, log it, or return an error message
        echo "Error marking all notifications as read: " . mysqli_error($dbc);
    }
}


//* Function to generate PDF "PETITIONERS"
function generatePDF($dbc)
{
    // Create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Administrator');
    $pdf->SetTitle('Petitioners List');
    $pdf->SetSubject('Petitioners List');
    $pdf->SetKeywords('Petitioners, List, PDF');

    // Set Font
    $pdf->SetFont('helvetica', '', 12);

    // Add a page
    $pdf->AddPage();

    // Header with logo
    $header = '<table style="width: 100%">
                    <tr>
                        <th style="text-align:right;">' . date('F. d, Y H:i:s') . '</th>
                    </tr><br />
                    <tr>
                        <th style="text-align:center;"><img src="./assets/img/llpo.jpg" alt="Logo" style="width: 60px; height=auto; float: left;"><h3>Laguna Parole and Probation Office</h3></th>
                    </tr>
                    <tr>
                        <th>
                            <div>
                                
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th><h4>"List of Petitioners"</h4></th>
                    </tr>
                </table>';

    $pdf->writeHTML($header, true, false, false, false, '');


    // Fetch data from database and format it
    $query = "SELECT * FROM clients WHERE status IN ('pending') OR status IS NULL ORDER BY registration_date ASC";
    $result = mysqli_query($dbc, $query);

    // Start data table
    $html = '<table border="1" style="width:100%; border-collapse: collapse; text-align: center;">
                <thead style="background-color: #f2f2f2;">
                    <tr>
                        <th style="padding: 8px;">Petitioner ID</th>
                        <th style="padding: 8px;">Name</th>
                        <th style="padding: 8px;">Alias</th>
                        <th style="padding: 8px;">Municipality</th>
                        <th style="padding: 8px;">Date Added</th>
                        <th style="padding: 8px;">Status</th>
                    </tr>
                </thead>
                <tbody>';

    // Loop through results and add rows to table
    while ($row = mysqli_fetch_assoc($result)) {
        $html .= '<tr>';
        $html .= '<td style="padding: 8px;">' . $row['id'] . '</td>';
        $html .= '<td style="padding: 8px;">' . ucfirst($row['first_name']) . ' ' . ucfirst($row['middle_name']) . ' ' . ucfirst($row['last_name']) . ' ' . ucfirst($row['suffix']) . '</td>';
        $html .= '<td style="padding: 8px;">' . ucfirst($row['alias']) . '</td>';
        $html .= '<td style="padding: 8px;">' . $row['municipality'] . '</td>';
        $html .= '<td style="padding: 8px;">' . date('M. d, Y', strtotime($row['registration_date'])) . '</td>';
        $html .= '<td style="padding: 8px;">' . ($row['status'] == 'pending' ? '<label style="background-color: #ffcc00; padding: 5px;">' . $row['status'] . '</label>' : '<label style="background-color: #ffcc00; padding: 5px;">pending</label>') . '</td>';
        $html .= '</tr>';
    }
    // End data table
    $html .= '</tbody></table>';

    // Output content
    $pdf->writeHTML($html, true, false, true, false, '');

    
    // Close and output PDF
    $pdf->Output('petitioners_list.pdf', 'D');
}

//* Function to generate PDF "PROBATIONERS"
function generatePDFProbationer($dbc)
{
    // Create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Administrator');
    $pdf->SetTitle('Probationers List');
    $pdf->SetSubject('Probationsers List');
    $pdf->SetKeywords('Probationers, List, PDF');

    // Set Font
    $pdf->SetFont('helvetica', '', 12);

    // Add a page
    $pdf->AddPage();

    // Header with logo
    $header = '<table style="width: 100%">
                    <tr>
                        <th style="text-align:right;">Date Generated: ' . date('F. d, Y H:i:s') . '</th>
                    </tr><br />
                    <tr>
                        <th style="text-align:center;"><img src="./assets/img/llpo.jpg" alt="Logo" style="width: 60px; height=auto; float: left;"><h3>Laguna Parole and Probation Office</h3></th>
                    </tr>
                    <tr>
                        <th>
                            <div>
                                
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th><h4>"List of Probationers"</h4></th>
                    </tr>
                </table>';

    $pdf->writeHTML($header, true, false, false, false, '');

    // Fetch data from database and format it
    // $query = "SELECT * FROM clients WHERE status 'grant' ORDER BY registration_date ASC";
    $query = "SELECT c.*,gc.date_granted, gc.probation_duration FROM clients c JOIN grant_clients gc ON c.id = gc.client_id WHERE c.status = 'grant'";
    $result = mysqli_query($dbc, $query);

    // Start data table
    $html = '<table border="1" style="width:100%; border-collapse: collapse; text-align: center;">
                <thead style="background-color: #f2f2f2;">
                    <tr>
                        <th style="padding: 8px;">Probationers ID</th>
                        <th style="padding: 8px;">Name</th>
                        <th style="padding: 8px;">Alias</th>
                        <th style="padding: 8px;">Status</th>
                        <th style="padding: 8px;">Date Granted</th>
                        <th style="padding: 8px;">Duration</th>
                    </tr>
                </thead>
                <tbody>';

    // Loop through results and add rows to table
    while ($row = mysqli_fetch_assoc($result)) {

        // Calculate probation end date based on date granted and selected duration
        $dateGranted = strtotime($row['date_granted']);
        $probationDurationMonths = $row['probation_duration'];
        $probationEndDate = strtotime("+$probationDurationMonths months", $dateGranted);
        $probationEndDateFormatted = date('M. d, Y', $probationEndDate);

        $html .= '<tr>';
        $html .= '<td style="padding: 8px;">' . $row['id'] . '</td>';
        $html .= '<td style="padding: 8px;">' . ucfirst($row['first_name']) . ' ' . ucfirst($row['middle_name']) . ' ' . ucfirst($row['last_name']) . ' ' . ucfirst($row['suffix']) . '</td>';
        $html .= '<td style="padding: 8px;">' . ucfirst($row['alias']) . '</td>';
        $html .= '<td style="padding: 8px;">' . ($row['status'] == 'grant' ? '<label style="background-color: #007BFF; padding: 5px;">' . $row['status'] . '</label>' : '<label style="background-color: #007BFF; padding: 5px;">grant</label>') . '</td>';
        $html .= '<td style="padding: 8px;">' . date('M. d, Y', strtotime($row['date_granted'])) . '</td>';
        $html .= '<td style="padding: 8px;">' . $probationEndDateFormatted . '</td>';
        $html .= '</tr>';
    }
    // End data table
    $html .= '</tbody></table>';

    // Output content
    $pdf->writeHTML($html, true, false, true, false, '');

    // Close and output PDF
    $pdf->Output('probationers_list.pdf', 'D');
}

//* Function to generate PDF "Denied Petitioners"
function generatePDFDenied($dbc)
{
    // Create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Administrator');
    $pdf->SetTitle('Denied List');
    $pdf->SetSubject('Denied List');
    $pdf->SetKeywords('Denied, List, PDF');

    // Set Font
    $pdf->SetFont('helvetica', '', 12);

    // Add a page
    $pdf->AddPage();

    // Header with logo
    $header = '<table style="width: 100%">
                    <tr>
                        <th style="text-align:right;">Date Generated: ' . date('F. d, Y H:i:s') . '</th>
                    </tr><br />
                    <tr>
                        <th style="text-align:center;"><img src="./assets/img/llpo.jpg" alt="Logo" style="width: 60px; height=auto; float: left;"><h3>Laguna Parole and Probation Office</h3></th>
                    </tr>
                    <tr>
                        <th>
                            <div>
                                
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th><h4>"List of Denied Petitioners"</h4></th>
                    </tr>
                </table>';

    $pdf->writeHTML($header, true, false, false, false, '');

    // Fetch data from database and format it
    $query = "SELECT c.*, DATE_FORMAT(dc.date_denied, '%b. %d, %Y') AS dd FROM clients c JOIN denied_clients dc ON c.id = dc.client_id WHERE c.status = 'denied'";
    $result = mysqli_query($dbc, $query);

    // Start data table
    $html = '<table border="1" style="width:100%; border-collapse: collapse; text-align: center;">
                <thead style="background-color: #f2f2f2;">
                    <tr>
                        <th style="padding: 8px;">Petitoner ID</th>
                        <th style="padding: 8px;">Name</th>
                        <th style="padding: 8px;">Alias</th>
                        <th style="padding: 8px;">Municipality</th>
                        <th style="padding: 8px;">Status</th>
                        <th style="padding: 8px;">Date Denied</th>
                    </tr>
                </thead>
                <tbody>';

    // Loop through results and add rows to table
    while ($row = mysqli_fetch_assoc($result)) {


        $html .= '<tr>';
        $html .= '<td style="padding: 8px;">' . $row['id'] . '</td>';
        $html .= '<td style="padding: 8px;">' . ucfirst($row['first_name']) . ' ' . ucfirst($row['middle_name']) . ' ' . ucfirst($row['last_name']) . ' ' . ucfirst($row['suffix']) . '</td>';
        $html .= '<td style="padding: 8px;">' . ucfirst($row['alias']) . '</td>';
        $html .= '<td style="padding: 8px;">' . ucfirst($row['municipality']) . '</td>';
        $html .= '<td style="padding: 8px;">' . ($row['status'] == 'denied' ? '<label style="background-color: #17a2b8; padding: 5px;">' . $row['status'] . '</label>' : '<label style="background-color: #9CE37D; padding: 5px;">grant</label>') . '</td>';
        $html .= '<td style="padding: 8px;">' . date('M. d, Y', strtotime($row['dd'])) . '</td>';
        $html .= '</tr>';
    }
    // End data table
    $html .= '</tbody></table>';

    // Output content
    $pdf->writeHTML($html, true, false, true, false, '');

    // Close and output PDF
    $pdf->Output('denied_list.pdf', 'D');
}

//* Function to generate PDF Probationers "Completed from the program"
function generatePDFCompleted($dbc)
{
    // Create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Administrator');
    $pdf->SetTitle('Completed List');
    $pdf->SetSubject('Completed List');
    $pdf->SetKeywords('Completed, List, PDF');

    // Set Font
    $pdf->SetFont('helvetica', '', 12);

    // Add a page
    $pdf->AddPage();

    // Header with logo
    $header = '<table style="width: 100%">
                    <tr>
                        <th style="text-align:right;">Date Generated: ' . date('F. d, Y H:i:s') . '</th>
                    </tr><br />
                    <tr>
                        <th style="text-align:center;"><img src="./assets/img/llpo.jpg" alt="Logo" style="width: 60px; height=auto; float: left;"><h3>Laguna Parole and Probation Office</h3></th>
                    </tr>
                    <tr>
                        <th>
                            <div>
                                
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th><h4>"List of Probationers Completed the Program"</h4></th>
                    </tr>
                </table>';

    $pdf->writeHTML($header, true, false, false, false, '');

    // Fetch data from database and format it
    $query = "SELECT c.*, DATE_FORMAT(dc.date_completed, '%b. %d, %Y') AS dc FROM clients c JOIN completed_client dc ON c.id = dc.client_id WHERE c.status = 'completed'";
    $result = mysqli_query($dbc, $query);

    // Start data table
    $html = '<table border="1" style="width:100%; border-collapse: collapse; text-align: center;">
                <thead style="background-color: #f2f2f2;">
                    <tr>
                        <th style="padding: 8px;">Petitoner ID</th>
                        <th style="padding: 8px;">Name</th>
                        <th style="padding: 8px;">Alias</th>
                        <th style="padding: 8px;">Municipality</th>
                        <th style="padding: 8px;">Status</th>
                        <th style="padding: 8px;">Date Completed</th>
                    </tr>
                </thead>
                <tbody>';

    // Loop through results and add rows to table
    while ($row = mysqli_fetch_assoc($result)) {


        $html .= '<tr>';
        $html .= '<td style="padding: 8px;">' . $row['id'] . '</td>';
        $html .= '<td style="padding: 8px;">' . ucfirst($row['first_name']) . ' ' . ucfirst($row['middle_name']) . ' ' . ucfirst($row['last_name']) . ' ' . ucfirst($row['suffix']) . '</td>';
        $html .= '<td style="padding: 8px;">' . ucfirst($row['alias']) . '</td>';
        $html .= '<td style="padding: 8px;">' . ucfirst($row['municipality']) . '</td>';
        $html .= '<td style="padding: 8px;">' . ($row['status'] == 'completed' ? '<label style="background-color: #9CE37D; padding: 5px;">' . $row['status'] . '</label>' : '<label style="background-color: #9CE37D; padding: 5px;">grant</label>') . '</td>';
        $html .= '<td style="padding: 8px;">' . date('M. d, Y', strtotime($row['dc'])) . '</td>';
        $html .= '</tr>';
    }
    // End data table
    $html .= '</tbody></table>';

    // Output content
    $pdf->writeHTML($html, true, false, true, false, '');

    // Close and output PDF
    $pdf->Output('completed_list.pdf', 'D');
}

//* Function to generate PDF Probationers "Revoked"
function generatePDFRevoked($dbc)
{
    // Create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Administrator');
    $pdf->SetTitle('Revoked List');
    $pdf->SetSubject('Revoked List');
    $pdf->SetKeywords('Revoked, List, PDF');

    // Set Font
    $pdf->SetFont('helvetica', '', 12);

    // Add a page
    $pdf->AddPage();

    // Header with logo
    $header = '<table style="width: 100%">
                    <tr>
                        <th style="text-align:right;">Date Generated: ' . date('F. d, Y H:i:s') . '</th>
                    </tr><br />
                    <tr>
                        <th style="text-align:center;"><img src="./assets/img/llpo.jpg" alt="Logo" style="width: 60px; height=auto; float: left;"><h3>Laguna Parole and Probation Office</h3></th>
                    </tr>
                    <tr>
                        <th>
                            <div>
                                
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th><h4>"List of Revoked Probationers"</h4></th>
                    </tr>
                </table>';

    $pdf->writeHTML($header, true, false, false, false, '');

    // Fetch data from database and format it
    // $query = "SELECT c.*, DATE_FORMAT(dc.date_completed, '%b. %d, %Y') AS dc FROM clients c JOIN completed_client dc ON c.id = dc.client_id WHERE c.status = 'completed'";
    $query = "SELECT c.*, DATE_FORMAT(rc.date_revoked, '%b. %d, %Y') AS dr FROM clients c JOIN revoked_clients rc ON c.id = rc.client_id WHERE c.status = 'revoked'";
    $result = mysqli_query($dbc, $query);

    // Start data table
    $html = '<table border="1" style="width:100%; border-collapse: collapse; text-align: center;">
                <thead style="background-color: #f2f2f2;">
                    <tr>
                        <th style="padding: 8px;">Petitoner ID</th>
                        <th style="padding: 8px;">Name</th>
                        <th style="padding: 8px;">Alias</th>
                        <th style="padding: 8px;">Municipality</th>
                        <th style="padding: 8px;">Status</th>
                        <th style="padding: 8px;">Date Revoked</th>
                    </tr>
                </thead>
                <tbody>';

    // Loop through results and add rows to table
    while ($row = mysqli_fetch_assoc($result)) {


        $html .= '<tr>';
        $html .= '<td style="padding: 8px;">' . $row['id'] . '</td>';
        $html .= '<td style="padding: 8px;">' . ucfirst($row['first_name']) . ' ' . ucfirst($row['middle_name']) . ' ' . ucfirst($row['last_name']) . ' ' . ucfirst($row['suffix']) . '</td>';
        $html .= '<td style="padding: 8px;">' . ucfirst($row['alias']) . '</td>';
        $html .= '<td style="padding: 8px;">' . ucfirst($row['municipality']) . '</td>';
        $html .= '<td style="padding: 8px;">' . ($row['status'] == 'revoked' ? '<label style="background-color: #DC3545; padding: 5px;">' . $row['status'] . '</label>' : '<label style="background-color: #DC3545; padding: 5px;">grant</label>') . '</td>';
        $html .= '<td style="padding: 8px;">' . date('M. d, Y', strtotime($row['dr'])) . '</td>';
        $html .= '</tr>';
    }
    // End data table
    $html .= '</tbody></table>';

    // Output content
    $pdf->writeHTML($html, true, false, true, false, '');

    // Close and output PDF
    $pdf->Output('completed_list.pdf', 'D');
}



function time_elapsed_string($datetime)
{
    $timestamp = strtotime($datetime);
    $current_time = time();
    $time_difference = $current_time - $timestamp;
    $seconds = $time_difference;
    $minutes = round($seconds / 60);           // value 60 is seconds
    $hours = round($seconds / 3600);           // value 3600 is 60 minutes * 60 sec
    $days = round($seconds / 86400);          // value 86400 is 24 hours * 60 minutes * 60 sec
    $weeks = round($seconds / 604800);         // value 604800 is 7 days * 24 hours * 60 minutes * 60 sec
    $months = round($seconds / 2629440);       // value 2629440 is ((365+365+365+365+366)/5/12) days * 24 hours * 60 minutes * 60 sec
    $years = round($seconds / 31553280);       // value 31553280 is ((365+365+365+365+366)/5) days * 24 hours * 60 minutes * 60 sec

    if ($seconds <= 60) {
        return "Just Now";
    } elseif ($minutes <= 60) {
        return ($minutes == 1) ? "1 minute ago" : "$minutes minutes ago";
    } elseif ($hours <= 24) {
        return ($hours == 1) ? "1 hour ago" : "$hours hours ago";
    } elseif ($days <= 7) {
        return ($days == 1) ? "yesterday" : "$days days ago";
    } elseif ($weeks <= 4.3) {  // 4.3 == 30/7
        return ($weeks == 1) ? "1 week ago" : "$weeks weeks ago";
    } elseif ($months <= 12) {
        return ($months == 1) ? "1 month ago" : "$months months ago";
    } else {
        return ($years == 1) ? "1 year ago" : "$years years ago";
    }
}


//* includes and requires functions for public website layout.
//? require $_SERVER['DOCUMENT_ROOT'] . './includes/header.php'; this can also be used in includes
function display_header()
{
    $file_header =  __DIR__ . '/includes/header.php';
    if (file_exists($file_header) && is_readable($file_header)) {
        include $file_header;
    } else {
        throw new Exception("$file_header can't be found");
    }
}

function display_header_inner()
{
    $file_header =  __DIR__ . '/includes/header_inner.php';
    if (file_exists($file_header) && is_readable($file_header)) {
        include $file_header;
    } else {
        throw new Exception("$file_header can't be found");
    }
}

function display_hero()
{
    $file_menu = __DIR__ . '/includes/hero.php';
    if (file_exists($file_menu) && is_readable($file_menu)) {
        include $file_menu;
    } else {
        throw new Exception("$file_menu can't be found");
    }
}

function display_menu()
{
    $file_menu = __DIR__ . '/includes/menu.php';
    if (file_exists($file_menu) && is_readable($file_menu)) {
        include $file_menu;
    } else {
        throw new Exception("$file_menu can't be found");
    }
}

function display_footer()
{
    // include __DIR__ . '/includes/footer.php';
    $file_footer = __DIR__ . '/includes/footer.php';
    if (file_exists($file_footer) && is_readable($file_footer)) {
        include $file_footer;
    } else {
        throw new Exception("$file_footer can't be found");
    }
}

function set_config_inc()
{
    $file_config = __DIR__ . '/includes/config.inc.php';
    if (file_exists($file_config) && is_readable($file_config)) {
        include $file_config;
    } else {
        throw new Exception("$file_config can't be found");
    }
}

function set_send_email()
{
    $file_send_email = __DIR__ . '/send_email.php';
    if (file_exists($file_send_email) && is_readable($file_send_email)) {
        require $file_send_email;
    } else {
        throw new Exception("$file_send_email can't be found");
    }
}

//* includes for user and admin dashboard
function show_header()
{
    $file_header =  __DIR__ . '/inc/header.php';
    if (file_exists($file_header) && is_readable($file_header)) {
        include $file_header;
    } else {
        throw new Exception("$file_header can't be found");
    }
}

function display_navbar()
{
    $file_navbar =  __DIR__ . '/inc/navbar.php';
    if (file_exists($file_navbar) && is_readable($file_navbar)) {
        include $file_navbar;
    } else {
        throw new Exception("$file_navbar can't be found");
    }
}

function display_sidebar()
{
    $file_sidebar =  __DIR__ . '/inc/sidebar.php';
    if (file_exists($file_sidebar) && is_readable($file_sidebar)) {
        include $file_sidebar;
    } else {
        throw new Exception("$file_sidebar can't be found");
    }
}

function show_footer()
{
    $file_footer =  __DIR__ . '/inc/footer.php';
    if (file_exists($file_footer) && is_readable($file_footer)) {
        include $file_footer;
    } else {
        throw new Exception("$file_footer can't be found");
    }
}

// function new_footer() {
//         $file_footer =  __DIR__ . '/includes/footer.php';
//         if (file_exists($file_footer) && is_readable($file_footer)): include $file_footer;
// else: throw new Exception("$file_footer can't be found");
//     endif;
// }



//* SweetAlert functions using php
function loginSuccess($message, $redirectUrl)
{
?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "<?php echo $message; ?>",
            confirmButtonText: "Okay",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?php echo $redirectUrl; ?>";
            }
        });
    </script>
<?php
}

//Log in success
function signedinSuccess($url)
{
?>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 700,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        Toast.fire({
            icon: "success",
            title: "Signed in successfully"
        }).then((result) => {
            // Redirect to the desired URL after the toast is closed
            window.location.href = "<?php echo $url; ?>";
        });
    </script>
<?php
}


// Login Error
function loginErrorAlert($message)
{
?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Login Error',
            text: "<?php echo $message; ?>",
            confirmButtonText: 'Ok',
            allowOutsideClick: false
        });
    </script>
<?php
}

// Login Error
function loginError($message)
{
?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: "<?php echo $message; ?>",
            confirmButtonText: "Okay",
            allowOutsideClick: false
        });
    </script>
<?php
}

//Logging out successful
function logoutSuccesAllert($message, $redirectUrl)
{
?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'You are now logged out',
            text: "<?php echo $message; ?>",
            confirmButtonText: "Okay",
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?php echo $redirectUrl; ?>";
            }
        });
    </script>
<?php
}

// registering information message
function registrationMessage()
{
    echo '<script>
        Swal.fire({
            title: "Registration Successful!",
            text: "You have successfully registered for an account. Please check your email to activate your account.",
            icon: "success",
            confirmButtonText: "Homepage",
            cancelButtonText: "Go to Login Page",
            showCancelButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Keep the user on the registration page.
                window.location.href = "index.php";
            } else {
                // Go to the login page.
                window.location.href = "login.php";
            }
        });
    </script>';
}

// registering user first step registration process
function regMessage()
{
    echo '<script>
        Swal.fire({
            title: "Account is for verification",
            text: "We will verify your account before you can use this site, once done we will send you email for further instructions.",
            icon: "success",
            confirmButtonText: "Homepage",
            cancelButtonText: "Go to Login Page",
            showCancelButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Keep the user on the registration page.
                window.location.href = "index.php";
            } else {
                // Go to the login page.
                window.location.href = "login.php";
            }
        });
    </script>';
}




// information message for user registration
function infoMessage($message)
{
?>
    <script>
        Swal.fire({
            icon: "info",
            // iconColor: "#C5C1A7",
            title: "Important Info",
            confirmButtonColor: '#44ccff',
            text: "<?php echo $message; ?>",
            html: `<div style="text-align: justify;"><?php echo $message; ?></div>`,
        });
    </script>
<?php
}

// user verification success in verify.php
function userVerifySuccess($message, $url)
{
?>
    <script>
        Swal.fire({
            position: "center",
            icon: "success",
            title: "<?php echo $message; ?>",
            showConfirmButton: false,
            timer: 1000
        }).then((result) => {
            // Redirect to the desired URL after the timer is closed
            window.location.href = "<?php echo $url; ?>";
        });
    </script>
<?php
}

function userRejectSuccess($message, $url)
{
?>
    <script>
        Swal.fire({
            position: "center",
            icon: "success",
            title: "<?php echo $message; ?>",
            showConfirmButton: false,
            timer: 1000
        }).then((result) => {
            // Redirect to the desired URL after the timer is closed
            window.location.href = "<?php echo $url; ?>";
        });
    </script>
<?php
}

//profile_picture invalid/error alert
function userProfilePictureError($message)
{
?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: "<?php echo $message; ?>",
            confirmButtonText: "Okay"
        });
    </script>
<?php
}


function userProfilePictureSuccess($message, $url)
{
?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "<?php echo $message; ?>",
            confirmButtonText: "Okay",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?php echo $url; ?>";
            }
        });
    </script>
<?php
}

//error message with oops message:
function oopsMsg($msg)
{
?>
    <script>
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Something went wrong!",
            footer: '<a href="#">Why do I have this issue?</a>'
        });
    </script>
<?php
}


//error message
function error($message)
{
?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: "<?php echo $message; ?>",
            confirmButtonText: "Okay",
            allowOutsideClick: false
        });
    </script>
<?php
}

//error message with url:
function errorMsg($message, $url)
{
?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...!',
            text: "<?php echo $message; ?>",
            confirmButtonText: "Okay",
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?php echo $url; ?>";
            }
        });
    </script>
<?php
}

//success message with url:
function success($message, $url)
{
?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "<?php echo $message; ?>",
            confirmButtonText: "Okay",
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?php echo $url; ?>";
            }
        });
    </script>
<?php
}

//success message without url:
function succesMsg($message)
{
?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "<?php echo $message; ?>",
            confirmButtonText: "Okay",
            allowOutsideClick: false
        });
    </script>
<?php
}

//success message for bottom end style:
function successButtomMessage($message)
{
?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            position: 'bottom-end',
            text: "<?php echo $message; ?>",
            confirmButtonText: "Okay"
        });
    </script>
<?php
}

function policyMessage($message)
{
?>
    <script>
        Swal.fire({
            icon: 'info',
            title: 'Privacy Policy',
            text: "<?php echo $message; ?>",
            confirmButtonText: "Okay",
            allowOutsideClick: false
        });
    </script>
<?php
}