<?php

include __DIR__ . '/functions.php';

show_header();
display_navbar();
display_sidebar();
set_config_inc();

require(MYSQL);

$userLevel = $_SESSION['user_level'];
$user_id = $_SESSION['user_id'];

$target_url = $userLevel == 1 ? 'admin_dashboard.php' : 'user_dashboard.php';

$q = "SELECT client FROM users WHERE user_id='$user_id'";
$r = mysqli_query($dbc, $q);
$row = mysqli_fetch_assoc($r);
$clientID = $row['client'];



// Ensure that the 'id' parameter is set in the URL
if ((isset($_GET['id'])) && (is_numeric($_GET['id'])) && $_GET['id'] == $clientID || $userLevel == 1) {
    $id = mysqli_real_escape_string($dbc, $_GET['id']);
    $query = "SELECT * FROM clients WHERE id = $id";
    $result = mysqli_query($dbc, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row          = mysqli_fetch_assoc($result);
        $fn           = $row['first_name'];
        $mn           = $row['middle_name'];
        $ln           = $row['last_name'];
        $suffix       = $row['suffix'];
        $alias        = $row['alias'];
        $email        = $row['email'];
        $mobile       = $row['mobile_number'];
        $dob          = $row['dob'];
        $gender       = $row['gender'];
        $street       = $row['street'];
        $barangay     = $row['barangay'];
        $municipality = $row['municipality'];
        $case_number  = $row['case_number'];
        $status       = $row['status'];
        $date         = $row['registration_date'];


        //Check the status in the clients table to determine if the user has already done for requirements
        $clientQuery = "SELECT * FROM clients WHERE id = $id";
        $clientResult = mysqli_query($dbc, $clientQuery);

        $hasAppliedForProbation = false;
        if ($clientResult && mysqli_num_rows($clientResult) > 0) {
            $clientRow = mysqli_fetch_assoc($clientResult);
            if ($clientRow['status'] == 'approved') {
                $hasAppliedForProbation = true;
            }
        }
    } else {
        echo "No details found for the selected ID.";
        exit();
    }

    $requirementsQuery = "SELECT * FROM client_requirements WHERE client_id = $id";
    $requirementsResult = mysqli_query($dbc, $requirementsQuery);

    if (!$requirementsResult) {
        die('Error fetching client requirements: ' . mysqli_error($dbc));
    }
} else {
    // echo '<p class="text-danger">This page has been accessed in error.</p>';
    errorMsg("This page has been accessed in error", "$target_url");
    // echo '<p class="text-danger">This page has been accessed in error.</p>';
    exit();
}

// Fetch denial reason from denied_clients table
$denialQuery = "SELECT * FROM denied_clients WHERE client_id = $id ORDER BY date_denied DESC LIMIT 1";
$denialResult = mysqli_query($dbc, $denialQuery);

if ($denialResult && mysqli_num_rows($denialResult) > 0) {
    $denialRow = mysqli_fetch_assoc($denialResult);
    $denialReason = $denialRow['reason'];
    $d_date = $denialRow['date_denied'];
    $deniedBy = $denialRow['denied_by'];
} else {
    $denialReason = 'Reason not available.';
}

//Fetch data from grant_clients table
$grantQuery = "SELECT * FROM grant_clients WHERE client_id = $id";
$grantResult = mysqli_query($dbc, $grantQuery);

if ($grantResult && mysqli_num_rows($grantResult) > 0) {
    $grantRow = mysqli_fetch_assoc($grantResult);
    $g_date = $grantRow['date_granted'];  // ✅ This sets $g_date
}
//Fetch the data from completed_probationers table
$completedQuery = "SELECT * FROM completed_client WHERE client_id = $id";
$completedResult = mysqli_query($dbc, $completedQuery);

if ($completedResult && mysqli_num_rows($completedResult) > 0) {
    $completedRow = mysqli_fetch_assoc($completedResult);
    $c_date = $completedRow['date_completed'];
    $completed_by = $completedRow['completed_by'];
}

//Fetch data from from revoked_clients table
$revokedQuery = "SELECT * FROM revoked_clients WHERE client_id = $id";
$revokedResult = mysqli_query($dbc, $revokedQuery);

if ($revokedResult && mysqli_num_rows($revokedResult) > 0) {
    $revokedRow = mysqli_fetch_assoc($revokedResult);
    $revoked_reason = $revokedRow['reason'];
    $r_date = $revokedRow['date_revoked'];
    $revoked_by = $revokedRow['revoked_by'];
}


// Fetch data from clients and schedule_list tables
$query = "
SELECT 
    clients.id AS client_id,
    clients.first_name,
    clients.middle_name,
    clients.last_name,
    clients.suffix,
    clients.alias,
    clients.email,
    clients.mobile_number,
    clients.dob,
    clients.gender,
    clients.street,
    clients.barangay,
    clients.municipality,
    clients.info_stat,
    clients.case_number AS client_case_number,
    clients.status AS client_status,
    clients.registration_date,
    schedule_list.id AS schedule_id,
    schedule_list.title,
    schedule_list.description,
    schedule_list.start_datetime,
    schedule_list.end_datetime
FROM clients
LEFT JOIN schedule_list ON clients.case_number = schedule_list.case_number
WHERE clients.id = $id;
";

// Execute the SQL query
$result = mysqli_query($dbc, $query);

// Check if the query was successful
if ($result && mysqli_num_rows($result) > 0) {
    // Fetch the result
    $row = mysqli_fetch_assoc($result);

    // Now use $row to access the data from both tables
    $clientFirstName = $row['first_name'];
    $clientLastName = $row['last_name'];
    $clientGender = $row['gender'];
    // ... other client columns ...

    $scheduleTitle = $row['title'];
    $scheduleDescription = $row['description'];
    $scheduleStartDatetime = $row['start_datetime'];
    $scheduleEndDatetime = $row['end_datetime'];
    // ... other schedule columns ...
} else {
    echo "Error fetching client and schedule data: " . mysqli_error($dbc);
    exit();
}

?>

<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">View Details</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href=<?php echo $userLevel == 1 ? 'admin_dashboard.php' : 'user_dashboard.php'; ?>>Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">View Details</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Details for <?= $fn ?></h5>

                                <?php if ($userLevel == 1) : ?>
                                    <div class="container">
                                        <h2>Client Informations</h2>
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#personal">Personal Info</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#address">Address</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#additional">Additional Info</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="personal">
                                                <div class="table-responsive-md">
                                                    <table class="table table-bordered table-hover">
                                                        <thead class="table-dark">
                                                            <tr>
                                                                <th scope="col">First Name</th>
                                                                <th scope="col">M.I.</th>
                                                                <th scope="col">Last Name</th>
                                                                <th scope="col">Suffix</th>
                                                                <th scope="col">Alias</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><?php echo ucfirst($fn) ?></td>
                                                                <td><?php echo ucfirst($mn) ?></td>
                                                                <td><?php echo ucfirst($ln) ?></td>
                                                                <td><?php echo ucfirst($suffix) ?></td>
                                                                <td><?php echo ucfirst($alias) ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="address">
                                                <ul>
                                                    <li class="text-dark">Street: <?php echo ucfirst($street) ?></li>
                                                    <li class="text-dark">Barangay: <?php echo ucfirst($barangay) ?></li>
                                                    <li class="text-dark">Municipality: <?php echo ucfirst($municipality) ?></li>
                                                </ul>
                                            </div>
                                            <div class="tab-pane fade" id="additional">
                                                <ul>
                                                    <li class="text-dark">Gender: <?php echo ucfirst($gender) ?></li>
                                                    <li class="text-dark">Date of Birth: <?php echo date('M. d Y', strtotime($dob)) ?></li>
                                                    <li class="text-dark">Mobile No.: <?php echo ucfirst($mobile) ?></li>
                                                    <li class="text-dark">Email: <?php echo ucfirst($email) ?></li>
                                                    <li class="text-dark">Case No.: <?php echo ucfirst($case_number) ?></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <div class="container">
                                        <div class="table-responsive-md">
                                            <table class="table table-bordered table-hover">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th scope="col">First Name</th>
                                                        <th scope="col">M.I.</th>
                                                        <th scope="col">Last Name</th>
                                                        <th scope="col">Suffix</th>
                                                        <th scope="col">Alias</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Date of Birth</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><?php echo ucfirst($fn) ?></td>
                                                        <td><?php echo ucfirst($mn) ?></td>
                                                        <td><?php echo ucfirst($ln) ?></td>
                                                        <td><?php echo ucfirst($suffix) ?></td>
                                                        <td><?php echo ucfirst($alias) ?></td>
                                                        <td>
                                                            
                                                 <?php
                                                $statusClass = '';
                                                switch (strtolower($status)) {
                                                case 'grant':
                                                case 'granted':
                                                case 'approved':
                                                    $statusClass = 'badge badge-success';
                                                   break;
                                                case 'pending':
                                                    $statusClass = 'badge badge-warning';
                                                   break;
                                                case 'denied':
                                                    $statusClass = 'badge badge-danger';
                                                   break;
                                                case 'completed':
                                                    $statusClass = 'badge badge-primary';
                                                   break;
                                                case 'revoked':
                                                    $statusClass = 'badge badge-dark';
                                                    break;
                                                default:
                                                $statusClass = 'badge badge-secondary';
                                                break;
                                                }
                                                ?>
                                                <span class="<?php echo $statusClass; ?>"><?php echo ucfirst($status); ?></span>
                                                </td>
                                                        <td><?php echo date('M. d Y', strtotime($dob)) ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Probation Application Status</h5>


                        <?php if ($status == 'grant') : ?>
                            <?php if ($userLevel == 0) : ?>
                                <div class="alert alert-success" role="alert">
                                    <span class="mdi mdi-check-circle-outline icon-md text-success"> Application Status: "Granted" </span>

                                    <p class="font-weight-bold">Congrats! your application has been approved.</p>

                                    <p> From application to acceptance, the client's journey towards redemption takes a significant step forward. Probation granted, paving the way for a brighter future.☀️</p>

                                    <p>Date Granted: <?= date('F d, Y', strtotime($g_date)) ?></p>
                                </div>
                            <?php else : ?>
                                <div class="alert alert-success" role="alert">
                                    <span class="mdi mdi-check-circle-outline icon-md text-success"> Application Status: "Granted" </span>

                                    <p class="font-weight-bold">Congrats! your application has been approved.</p>

                                    <p> From application to acceptance, the client's journey towards redemption takes a significant step forward. Probation granted, paving the way for a brighter future.☀️</p>

                                    <p>Date Granted: <?= $g_date ? date('F d, Y', strtotime($g_date)) : 'Not yet granted.' ?></p>

                                    <p>Granted by: <?= $grant_by ?></p>
                                </div>
                            <?php endif; ?>

                            <?php if ($scheduleTitle) : ?>
                                <div class="alert alert-primary" role="alert">
                                    <span class="mdi mdi-calendar-check icon-md text-primary">Schedule of Appointment:</span>
                                    <p class="font-weight-bold">As part of your probation conditions, you are required to report to this office monthly. Please understand that consistent attendance is essential for successful completion of your probation and avoiding further legal consequences.</p>
                                    <p class="font-weight-bold">Your monthly reporting to this office is a mandatory element of your probation. Complying with this requirement demonstrates your commitment to rehabilitation and helps us monitor your progress. Failure to attend could jeopardize your probationary status.</p>
                                    <p>Title: <?= $scheduleTitle ?></p>
                                    <p>Description: <?= $scheduleDescription ?></p>
                                    <!-- <p>Start Datetime: <?= date('F j, Y g:i A', strtotime($scheduleStartDatetime)) ?></p>
                                <p>End Datetime: <?= date('F j, Y g:i A', strtotime($scheduleEndDatetime)) ?></p> -->
                                    <!-- <p>Schedule Date: <?= date('F j, Y \T\I\M\E: g:ia', strtotime($scheduleStartDatetime)) ?> - <?= date('g:ia', strtotime($scheduleEndDatetime)) ?></p> -->

                                    <span class="mdi mdi-calendar-today icon-sm text-primary">Schedule:</span>
                                    <p><?= date('F j, Y', strtotime($scheduleStartDatetime)) ?></p>
                                    <span class="mdi mdi-clock icon-sm text-primary">Time:</span>
                                    <p><?= date('g:ia', strtotime($scheduleStartDatetime)) ?> - <?= date('g:ia', strtotime($scheduleEndDatetime)) ?></p>
                                </div>
                            <?php else : ?>
                                <div class="alert alert-primary" role="alert">
                                    <span class="mdi mdi-calendar-check icon-md text-primary">Schedule of Appointment:</span>
                                    <p class="font-weight-bold">No Schedule of Appointment Yet.</p>
                                </div>
                            <?php endif; ?>

                        <?php elseif ($status == 'pending') : ?>
                            <?php if ($userLevel == 0) : ?>
                                <div class="alert alert-primary" role="alert">
                                    <!-- All required documents have been uploaded! Our Probation Officer will now process your application, which involves verifying your information and conducting a thorough Post-Sentence Investigation (PSI). The PSI will gather information about your social background, family situation, potential employment opportunities, and any relevant factors to assess your suitability for probation. Depending on the case complexity, the PSI Report (PSIR) can take at least 60 days or longer. This report will be the Probation Officer's recommendation to the court Judge on whether to grant or deny your application for the probation program. You will also have the opportunity to attend a probation hearing and present any additional information before the judge makes a final decision. -->
                                    <p class="font-weight-bold">All required documents have been uploaded! Our Probation Officer will now process your application. This involves verifying your information and conducting a thorough Post-Sentence Investigation (PSI).</p>
                                    <p class="font-weight-bold">During the PSI, the Probation Officer will gather information about your social background, family situation, potential employment opportunities, and any relevant factors to assess your suitability for probation. The complexity of your case can impact the PSI timeframe, which may take at least 60 days, potentially longer or shorter.</p>
                                    <p class="font-weight-bold">The completed PSI report, known as the Post-Sentence Investigation Result (PSIR), will be submitted to the court Judge. The Judge will use the PSIR as a key recommendation when deciding whether to grant or deny your application for the probation program.</p>
                                </div>
                            <?php else : ?>
                                <div class="alert alert-primary d-flex align-items-center" role="alert">
                                    <span class="mdi mdi-file-multiple icon-md text-primary"> Requirements submitted, awaiting file validation for client. </span>
                                    <!-- <p class="font-weight-bold"> Awaiting file validation for client.</p> -->
                                </div>
                            <?php endif; ?>

                        <?php elseif ($status == 'denied') : ?>
                            <?php if ($userLevel == 0) : ?>
                                <div class="alert alert-danger" role="alert">
                                    <span class="mdi mdi-alert icon-md text-danger"> Application Status: "Denied" </span>

                                    <p class="font-weight-bold">We're sorry, but your application has not been approved.</p>

                                    <p>Reason: <?= $denialReason ?></p>

                                    <p>Date of Denial: <?= date('M. d, Y', strtotime($d_date)) ?></p>

                                    <p>If you have any questions or would like to discuss this further, please contact us.</p>
                                </div>
                            <?php else : ?>
                                <div class="alert alert-danger" role="alert">
                                    <span class="mdi mdi-alert icon-md text-danger"> Application Status: "Denied" </span>

                                    <p class="font-weight-bold">We're sorry, but your application has not been approved.</p>

                                    <p>Reason: <?= $denialReason ?></p>

                                    <p>Date of Denial: <?= date('M. d, Y', strtotime($d_date)) ?></p>

                                    <p>Denied By: <?= $deniedBy ?></p>

                                    <!-- <p>If you have any questions or would like to discuss this further, please contact us.</p> -->
                                </div>
                            <?php endif; ?>

                        <?php elseif ($status == 'completed') : ?>
                            <?php if ($userLevel == 0) : ?>
                                <div class="alert alert-success" role="alert">
                                    <span class="mdi mdi-checkbox-multiple-marked-circle icon-md text-success">Application Status: "Probation Program Completed!"</span>

                                    <p>Mabuhay, You climbed the path, faced the doubts, and emerged stronger. Today, we celebrate not just finishing, but starting anew. Carry the lessons like talismans, walk with integrity, and embrace the future with open arms. We believes in you! Sulong! 🇵🇭</p>

                                    <p>Date Completed: <?= date('M. d, Y', strtotime($c_date)) ?></p>
                                </div>
                            <?php else : ?>
                                <div class="alert alert-success" role="alert">
                                    <span class="mdi mdi-checkbox-multiple-marked-circle icon-md text-success">Probation Status: "Probation Program Completed!"</span>

                                    <p>Mabuhay, You climbed the path, faced the doubts, and emerged stronger. Today, we celebrate not just finishing, but starting anew. Carry the lessons like talismans, walk with integrity, and embrace the future with open arms. We believes in you! Sulong! 🇵🇭</p>

                                    <p>Date Completed: <?= date('M. d, Y', strtotime($c_date)) ?></p>

                                    <p>Completed by Officer: <?= $completed_by ?></p>
                                </div>
                            <?php endif; ?>

                        <?php elseif ($status == 'revoked') : ?>
                            <div class="alert alert-danger" role="alert">
                                <span class="mdi mdi-close-octagon icon-md text-danger">Probation Status: Your probation has been "Revoked"</span>

                                <blockquote class="blockquote blockquote-secondary">
                                    <p class="font-weight-bold">It is with a heavy heart that we inform you of the revocation of your probation. We understand that everyone faces challenges, and setbacks are a part of life. We encourage you to view this as an opportunity for growth and self-reflection.</p>
                                    <p class="font-weight-bold">Remember, mistakes don't define us, but how we rise from them does. If you need support or guidance, our doors are always open. Your journey to rehabilitation may have hit a roadblock, but it's not the end of your path to redemption.</p>
                                    <p class="font-weight-bold">Take this time to reassess, learn, and make positive changes. We believe in your resilience and strength. Should you wish to discuss this further, please don't hesitate to reach out.</p>
                                    <p class="font-weight-bold">Wishing you strength and courage.</p>
                                </blockquote>

                                <p>Revoked Reason: <?= $revoked_reason ?></p>

                                <p>Revoked Date: <?= date('M. d, Y', strtotime($r_date)) ?></p>
                            </div>

                        <?php else : ?>
                            <?php if ($userLevel == 0) : ?>
                                <div class="alert alert-warning" role="alert">
                                    <span class="mdi mdi-information-outline icon-md text-warning"> Attention! </span>

                                    <p class="font-weight-bold">Missing documents are holding up your application.</p>

                                    <p class="font-weight-bold">Please upload them immediately to avoid delays, Upload your files&nbsp;<a href="upload_requirements.php?id=<?= $id ?>" class="alert-link">here</a>!</p>
                                </div>
                            <?php else : ?>
                                <div class="alert alert-warning d-flex align-items-center" role="alert">
                                    <span class="mdi mdi-information-outline icon-md text-warning"> The client is still finalizing their requirements.</span>

                                </div>
                            <?php endif; ?>
                        <?php endif; ?>


                    </div>
                </div>
            </div>
        </div>


        <?php if ($userLevel == 1) : ?>
            <div class="row">
                <div class="col-lg-18 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Uploaded Requirements</h5>


                            <?php if ($requirementsResult && mysqli_num_rows($requirementsResult) > 0) : ?>
                                <div class="table-responsive-md">
                                    <table class="table table-hover table-bordered">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Client ID</th>
                                                <th> Name</th>
                                                <th>File Name</th>
                                                <!-- <th>File Type</th> -->
                                                <!-- <th>File Size</th> -->
                                                <th>Status</th>
                                                <!-- <th>Uploaded By</th> -->
                                                <th> Date Uploaded</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($requirementRow = mysqli_fetch_assoc($requirementsResult)) : ?>
                                                <tr>
                                                    <td><?= $requirementRow['id'] ?></td>
                                                    <td><?= $requirementRow['client_id'] ?></td>
                                                    <td><?= $requirementRow['requirement_name'] ?></td>
                                                    <!-- <td><?= $requirementRow['file_name'] ?></td> -->
                                                    <td>
                                                        <a href="view_image.php?id=<?= $requirementRow['id'] ?>&requirement_name=<?= $requirementRow['requirement_name'] ?>&file_name=<?= $requirementRow['file_name'] ?>">
                                                            <?= $requirementRow['file_name'] ?>
                                                        </a>
                                                    </td>
                                                    <!-- <td><?= $requirementRow['file_type'] ?></td> -->
                                                    <!-- <td><?= $requirementRow['file_size'] ?></td> -->


                                                    <?php if (isset($requirementRow['status']) && $requirementRow['status'] == 'pending') : ?>
                                                        <td><label class="badge badge-warning"><?= $requirementRow['status'] ?></label></td>
                                                    <?php elseif (isset($requirementRow['status']) && $requirementRow['status'] == 'valid') : ?>
                                                        <td><label class="badge badge-success"><?= $requirementRow['status'] ?></label></td>
                                                    <?php else : ?>
                                                        <td><label class="badge badge-danger"><?= $requirementRow['status'] ?></label></td>
                                                    <?php endif; ?>

                                                    <!-- <td><?= $requirementRow['uploaded_by'] ?></td> -->
                                                    <td><?= date('M. d, Y', strtotime($requirementRow['upload_date'])) ?></td>
                                                    <td>
                                                        <div class='dropdown'>
                                                            <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action </button>
                                                            <div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuButton1'>
                                                                <h6 class='dropdown-header'>Options</h6>
                                                                <!-- <a class='dropdown-item text-dark' href='view_image.php?id=<?= $id ?>&requirement_name=<?= $requirementRow['requirement_name'] ?>&file_name=<?= $requirementRow['file_name'] ?>'>View Image</a> -->
                                                                <div class='dropdown-divider'></div>
                                                                <a class='dropdown-item text-primary' href='download_file.php?file=<?= urldecode($requirementRow['file_name'])  ?>'>Download</a>
                                                                <?php if ($status != 'grant' && $status != 'completed') : ?>
                                                                    <div class='dropdown-divider'></div>
                                                                    <a class="dropdown-item text-success" href="validate_files.php?id=<?= $id ?>&requirement_name=<?= $requirementRow['requirement_name'] ?>">Valid</a>
                                                                    <div class='dropdown-divider'></div>
                                                                    <a class='dropdown-item text-danger' href='invalid_file_v02.php?id=<?= $id ?>&requirement_name=<?= $requirementRow['requirement_name'] ?>'>
                                                                        Invalidate File
                                                                    </a>
                                                                <?php endif; ?>
                                                            </div>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else : ?>
                                <div class="alert alert-info d-flex align-text-center" role="alert">
                                    <span class="mdi mdi-information icon-md"> No requirements uploaded yet. </span>

                                </div>
                            <?php endif; ?>




                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>





    <!-- content-wrapper ends -->




    <?php show_footer(); ?>