<?php

include __DIR__ . '/functions.php';


show_header();
display_navbar();
display_sidebar();
set_config_inc();



require(MYSQL);

$userLevel = $_SESSION['user_level'];
$email = $_SESSION['email'];
$user_id = $_SESSION['user_id'];

$target_url = $userLevel == 1 ? 'admin_dashboard.php' : 'user_dashboard.php';

$q = "SELECT client FROM users WHERE user_id='$user_id'";
$r = mysqli_query($dbc, $q);
$row = mysqli_fetch_array($r);
$check_client = $row['client'];

if ((isset($_GET['id'])) && (is_numeric($_GET['id'])) && $_GET['id'] == $check_client || $userLevel == 1) {
    $id = $_GET['id'];
} else {
    errorMsg("This page has been accessed in error", "$target_url");
    // echo '<p class="text-danger">This page has been accessed in error.</p>';
    exit();
}

handleFileUpload('file_birth_cert', 'birth_certificate', $id, $email);
handleFileUpload('file_valid_id', 'valid_id', $id, $email);
handleFileUpload('file_talambuhay', 'talambuhay', $id, $email);
handleFileUpload('file_barangay_clearance', 'barangay_clearance', $id, $email);
handleFileUpload('file_case_info', 'case_info', $id, $email);
handleFileUpload('file_case_judgement', 'case_judgement', $id, $email);
handleFileUpload('file_petition_for_probation', 'petition_for_probation', $id, $email);
handleFileUpload('file_conduct_ps1', 'order_to_conduct_ps1', $id, $email);
handleFileUpload('file_case_dissmissed', 'case_dissmissed', $id, $email);
handleFileUpload('file_police_clearance', 'police_clearance', $id, $email);
handleFileUpload('file_mtc_mtcc_clearance', 'mtc_mtcc_clearance', $id, $email);
handleFileUpload('file_nbi_clearance', 'nbi_clearance', $id, $email);
handleFileUpload('file_drug_test_result', 'drug_test_result', $id, $email);


$file_count_query = "SELECT COUNT(*) AS file_count FROM client_requirements WHERE client_id = $id";
$file_count_result = mysqli_query($dbc, $file_count_query);

if (!$file_count_result) {
    error('Error in query');
    return 0;
}

$row = mysqli_fetch_array($file_count_result);
$file_count = $row['file_count'];



// Check if the submit button is pressed
if (isset($_POST['submit'])) {
    // Update the client's status to 'pending'
    $updateStatusQuery = "UPDATE clients SET status = 'pending' WHERE id = ?";
    $updateStatusStmt = $dbc->prepare($updateStatusQuery);
    $updateStatusStmt->bind_param("i", $id);
    $updateStatusStmt->execute();
    $updateStatusStmt->close();

    $email1 = 'montesarose@gmail.com';
    $email2 = 'montesarose@gmail.com';
    $subject =  'Confirmation';
    $message = 'Submitted All Files';

    createNotification($dbc, $id, $email1, $subject, $message);
    createNotification($dbc, $id, $email2, $subject, $message);

    success("Successfully submitted the requirements", "view_details.php?id={$id}");
}


?>

<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Upload Requirements</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href=<?php echo $userLevel == 1 ? 'admin_dashboard.php' : 'user_dashboard.php'; ?>>Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Upload Requirements</li>
                </ol>
            </nav>
        </div>



        <div class="row">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-15 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Petitioners Requirements</h5>
                                <!-- <blockquote class="blockquote blockquote-primary">
                                    <p class="font-weight-bold text-center text-primary">Please note that only files in the following formats are accepted: JPEG, JPG, and PNG. Each file must be under 20MB in size.</p>
                                </blockquote> -->

                                <blockquote class="blockquote blockquote-primary">
                                    <h6 class="lead text-center text-primary">Please note that only files in the following formats are accepted: JPEG, JPG, and PNG. Each file must be under 20MB in size.</h6>
                                </blockquote> <br />

                                <?php
                                switch ($file_count):
                                    case 1:
                                        $progress_valueNow = '7';
                                        $progress_width = '7%';
                                        $progress_count = '7%';
                                        break;
                                    case 2:
                                        $progress_valueNow = '15';
                                        $progress_width = '15%';
                                        $progress_count = '15%';
                                        break;
                                    case 3:
                                        $progress_valueNow = '23';
                                        $progress_width = '23%';
                                        $progress_count = '23%';
                                        break;
                                    case 4:
                                        $progress_valueNow = '30';
                                        $progress_width = '30%';
                                        $progress_count = '30%';
                                        break;
                                    case 5:
                                        $progress_valueNow = '38';
                                        $progress_width = '38%';
                                        $progress_count = '38%';
                                        break;
                                    case 6:
                                        $progress_valueNow = '46';
                                        $progress_width = '46%';
                                        $progress_count = '46%';
                                        break;
                                    case 7:
                                        $progress_valueNow = '53';
                                        $progress_width = '53%';
                                        $progress_count = '53%';
                                        break;
                                    case 8:
                                        $progress_valueNow = '61';
                                        $progress_width = '61%';
                                        $progress_count = '61%';
                                        break;
                                    case 9:
                                        $progress_valueNow = '69';
                                        $progress_width = '69%';
                                        $progress_count = '69%';
                                        break;
                                    case 10:
                                        $progress_valueNow = '76';
                                        $progress_width = '76%';
                                        $progress_count = '76%';
                                        break;
                                    case 11:
                                        $progress_valueNow = '84';
                                        $progress_width = '84%';
                                        $progress_count = '84%';
                                        break;
                                    case 12:
                                        $progress_valueNow = '92';
                                        $progress_width = '92%';
                                        $progress_count = '92%';
                                        break;
                                    case 13:
                                        $progress_valueNow = '100';
                                        $progress_width = '100%';
                                        $progress_count = '100%';
                                    default:
                                        $progress_valueNow = '0';
                                        $progress_width = '0%';
                                        $progress_count = '0%';
                                        break;
                                endswitch;
                                ?>
                                <div>
                                    <h6>File Progress: <?= $file_count ?> / 13</h6>
                                </div>
                                <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="<?= $progress_valueNow ?>" aria-valuemin="0" aria-valuemax="100" style="height: 25px; background-color: #f0f0f0; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: <?= $progress_width ?>; background-color: #28a745; color: #fff; border-radius: 5px;"><?= $progress_count ?></div>
                                </div> <br />


                                <div class="table-responsive-md">
                                    <table class="table table-borderless table-hover">
                                        <thead>
                                            <tr>
                                                <th class="col-md-3">
                                                    <h6>Requirements Name</h6>
                                                </th>
                                                <th class="col-md-6">
                                                    <h6>Uploaded file</h6>
                                                </th>
                                                <th class="col-md-2">
                                                    <h6>Date Uploaded</h6>
                                                </th>
                                                <th class="col-md-2">
                                                    <h6>Status</h6>
                                                </th>
                                                <th class="col-md-2 text-center">
                                                    <h6>Actions</h6>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <!-- Birth Certificate Form -->
                                            <tr>
                                                <td>
                                                    <details class="mark">
                                                        <summary>Birth Certificate/</summary>
                                                        <p>Marriage Certificate/Certificate sa <br> Binyag/School Records (clear scanned/image)</p>
                                                    </details>
                                                </td>

                                                <td>
                                                    <?php
                                                    $requirement_name = 'birth_certificate';

                                                    // Check if a file with the same requirement name exists
                                                    $checkFileQuery = "SELECT file_name, status, DATE_FORMAT(upload_date, '%M %d, %Y') FROM client_requirements WHERE client_id = ? AND requirement_name = ?";
                                                    $checkFileStmt = $dbc->prepare($checkFileQuery);
                                                    $checkFileStmt->bind_param("is", $id, $requirement_name);
                                                    $checkFileStmt->execute();
                                                    $checkFileStmt->store_result();

                                                    if ($checkFileStmt->num_rows > 0) {
                                                        // File exists, display the file name
                                                        $checkFileStmt->bind_result($fileName, $file_status, $b_cert_u_date);
                                                        $checkFileStmt->fetch();
                                                        echo "File: <a href='view_image.php?id=$id&requirement_name=$requirement_name&file_name=$fileName'>$fileName</a>";
                                                    } else {
                                                        // File does not exist, show the upload form
                                                    ?>
                                                        <form action="upload_requirements.php?id=<?= $id ?>" method="post" enctype="multipart/form-data">
                                                            <label for="file_birth_cert">Birth Certificate:</label>
                                                            <div class="input-group">
                                                                <input type="file" id="file_birth_cert" name="file_birth_cert" class="form-control">
                                                                <button type="submit" class="btn btn-primary btn-icon-text">
                                                                    <i class="mdi mdi-upload btn-icon-prepend"></i>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    <?php
                                                    }

                                                    $checkFileStmt->close();
                                                    ?>

                                                </td>



                                                <?php if (isset($file_status) && $file_status == 'pending') : ?>
                                                    <td><?= $b_cert_u_date ?></td>
                                                <?php elseif (isset($file_status) && $file_status == 'valid') : ?>
                                                    <td><?= $b_cert_u_date ?></td>
                                                <?php elseif (isset($valid_id_status) && $file_status == 'invalid') : ?>
                                                    <td><?= $b_cert_u_date ?></td>
                                                <?php else : ?>
                                                    <td><?php echo '' ?></td>
                                                <?php endif; ?>


                                                <?php if (isset($file_status) && $file_status == 'pending') : ?>
                                                    <td><label class="badge badge-warning"><?= $file_status ?></label></td>
                                                <?php elseif (isset($file_status) && $file_status == 'valid') : ?>
                                                    <td><label class="badge badge-success"><?= $file_status ?></label></td>
                                                <?php elseif (isset($file_status) && $file_status == 'invalid') : ?>
                                                    <td><label class="badge badge-danger"><?= $file_status ?></label></td>
                                                <?php else : ?>
                                                    <td><label class="badge badge-dark">no file</label></td>
                                                <?php endif; ?>

                                                <td>
                                                    <div class='dropdown'>
                                                        <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action </button>
                                                        <div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuButton1'>
                                                            <h6 class='dropdown-header'>Options</h6>
                                                            <!-- <a class='dropdown-item text-dark' href='#' onclick='showImage("<?php echo $fileName; ?>", "birth_certificate")'>View Image</a> -->
                                                            <div class='dropdown-divider'></div>
                                                            <a class='dropdown-item text-primary' href='download_file.php?file=<?= $fileName ?>' target='_blank'>Download</a>
                                                            <div class='dropdown-divider'></div>
                                                            <a class='dropdown-item text-danger' href='javascript:;' onclick="Swal.fire({title: 'Are you sure?', text: 'This will permanently delete the birth certificate <?= $fileName ?>; file. Do you want to proceed?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Yes, delete it!', cancelButtonText: 'No, cancel'}).then((result) => {if (result.isConfirmed) {window.location.href = 'delete_image.php?id=<?= $id ?>&requirement_name=<?= $requirement_name ?>';}})">Delete File</a </div>
                                                </td>
                                            </tr>

                                            <!-- Valid ID Form -->
                                            <tr>
                                                <td>
                                                    <details class="mark">
                                                        <summary>Valid IDs</summary>
                                                        <p>(Sample: Comelec, Passport, Driver's License, <br> atbp. clear scanned/image)</p>
                                                    </details>
                                                </td>
                                                <td>
                                                    <?php
                                                    $requirement_name = 'valid_id';

                                                    // Check if a file with the same requirement name exists
                                                    $checkFileQuery = "SELECT file_name, status, DATE_FORMAT(upload_date, '%M %d, %Y') FROM client_requirements WHERE client_id = ? AND requirement_name = ?";
                                                    $checkFileStmt = $dbc->prepare($checkFileQuery);
                                                    $checkFileStmt->bind_param("is", $id, $requirement_name);
                                                    $checkFileStmt->execute();
                                                    $checkFileStmt->store_result();

                                                    if ($checkFileStmt->num_rows > 0) {
                                                        // File exists, display the file name
                                                        $checkFileStmt->bind_result($fileName_valid_id, $valid_id_status, $v_id_u_date);
                                                        $checkFileStmt->fetch();
                                                        echo "File: <a href='view_image.php?id=$id&requirement_name=$requirement_name&file_name=$fileName_valid_id'>$fileName_valid_id</a>";
                                                    } else {
                                                        // File does not exist, show the upload form
                                                    ?>
                                                        <form id="form_valid_id" action="upload_requirements.php?id=<?= $id ?>" method="post" enctype="multipart/form-data">
                                                            <label for="file_valid_id">Valid ID:</label>
                                                            <div class="input-group">
                                                                <input type="file" id="file_valid_id" name="file_valid_id" class="form-control">
                                                                <button type="submit" class="btn btn-primary btn-icon-text">
                                                                    <i class="mdi mdi-upload btn-icon-prepend"></i>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    <?php
                                                    }

                                                    $checkFileStmt->close();
                                                    ?>
                                                </td>

                                                <?php if (isset($valid_id_status) && $valid_id_status == 'pending') : ?>
                                                    <td><?= $v_id_u_date ?></td>
                                                <?php elseif (isset($valid_id_status) && $valid_id_status == 'valid') : ?>
                                                    <td><?= $v_id_u_date ?></td>
                                                <?php elseif (isset($valid_id_status) && $valid_id_status == 'invalid') : ?>
                                                    <td><?= $v_id_u_date ?></td>
                                                <?php else : ?>
                                                    <td><?php echo '' ?></td>
                                                <?php endif; ?>


                                                <?php if (isset($valid_id_status) && $valid_id_status  == 'pending') : ?>
                                                    <td><label class="badge badge-warning"><?= $valid_id_status ?></label></td>
                                                <?php elseif (isset($valid_id_status) && $valid_id_status  == 'valid') : ?>
                                                    <td><label class="badge badge-success"><?= $valid_id_status ?></label></td>
                                                <?php elseif (isset($valid_id_status) && $valid_id_status  == 'invalid') : ?>
                                                    <td><label class="badge badge-danger"><?= $valid_id_status  ?></label></td>
                                                <?php else : ?>
                                                    <td><label class="badge badge-dark">no file</label></td>
                                                <?php endif; ?>

                                                <td>
                                                    <div class='dropdown'>
                                                        <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action </button>
                                                        <div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuButton1'>
                                                            <h6 class='dropdown-header'>Options</h6>
                                                            <!-- <a class='dropdown-item text-dark' href='#' onclick='showImage("<?php echo $fileName_valid_id; ?>", "valid_id")'>View Image</a> -->
                                                            <div class='dropdown-divider'></div>
                                                            <a class='dropdown-item text-primary' href='download_file.php?file=<?= $fileName_valid_id ?>' target='_blank'>Download</a>
                                                            <div class='dropdown-divider'></div>
                                                            <a class='dropdown-item text-danger' href='javascript:;' onclick="Swal.fire({title: 'Are you sure?', text: 'This will permanently delete the <?= $fileName_valid_id ?> file. Do you want to proceed?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Yes, delete it!', cancelButtonText: 'No, cancel'}).then((result) => {if (result.isConfirmed) {window.location.href = 'delete_image.php?id=<?= $id ?>&requirement_name=<?= $requirement_name ?>';}})">Delete File</a>
                                                        </div>
                                                </td>
                                            </tr>

                                            <!-- Talambuhay Form -->
                                            <tr>
                                                <td>
                                                    <details class="mark">
                                                        <summary>Talambuhay</summary>
                                                        <p>
                                                            salaysay/ikwento ang buhay sa pamamagitan <br> ng mga sumusunod na gabay: <br>
                                                            isulat sa Yellow Pad Paper <br>
                                                            (maayos at nababasa dapat ang sulat)<br>
                                                            - Paano nangyare ang kaso <br>
                                                            - Tunkol sa Pamilya <br>
                                                            - Ala-ala mo nung bata pa <br>
                                                            - Pag-aasawa <br>
                                                            - Pag-aaral <br>
                                                            - Pagtatrabaho <br>
                                                            - Kalusugan <br>
                                                            - Tatlong (3) dahilan kung bakit gusto mailagay sa probation <br>
                                                            - Tatlong (3) magagandang ugali/Tatlong <br>
                                                            (3) hindi magandang ugali
                                                        </p>
                                                    </details>
                                                </td>
                                                <td>
                                                    <?php
                                                    $requirement_name = 'talambuhay';

                                                    // Check if a file with the same requirement name exists
                                                    $checkFileQuery = "SELECT file_name, status, DATE_FORMAT(upload_date, '%M %d, %Y') FROM client_requirements WHERE client_id = ? AND requirement_name = ?";
                                                    $checkFileStmt = $dbc->prepare($checkFileQuery);
                                                    $checkFileStmt->bind_param("is", $id, $requirement_name);
                                                    $checkFileStmt->execute();
                                                    $checkFileStmt->store_result();

                                                    if ($checkFileStmt->num_rows > 0) {
                                                        // File exists, display the file name
                                                        $checkFileStmt->bind_result($fileName_talambuhay, $talambuhay_status, $talambuhay_u_date);
                                                        $checkFileStmt->fetch();
                                                        echo "File: <a href='view_image.php?id=$id&requirement_name=$requirement_name&file_name=$fileName_talambuhay'>$fileName_talambuhay</a>";
                                                    } else {
                                                        // File does not exist, show the upload form
                                                    ?>
                                                        <form action="upload_requirements.php?id=<?= $id ?>" method="post" enctype="multipart/form-data">
                                                            <label for="file_talambuhay">Talambuhay:</label>
                                                            <div class="input-group">
                                                                <input type="file" id="file_talambuhay" name="file_talambuhay" class="form-control">
                                                                <button type="submit" class="btn btn-primary btn-icon-text">
                                                                    <i class="mdi mdi-upload btn-icon-prepend"></i>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    <?php
                                                    }

                                                    $checkFileStmt->close();
                                                    ?>

                                                </td>

                                                <?php if (isset($talambuhay_status) && $talambuhay_status == 'pending') : ?>
                                                    <td><?= $talambuhay_u_date ?></td>
                                                <?php elseif (isset($talambuhay_status) && $talambuhay_status == 'valid') : ?>
                                                    <td><?= $talambuhay_u_date ?></td>
                                                <?php elseif (isset($talambuhay_status) && $talambuhay_status == 'invalid') : ?>
                                                    <td><?= $talambuhay_u_date ?></td>
                                                <?php else : ?>
                                                    <td><?php echo '' ?></td>
                                                <?php endif; ?>

                                                <?php if (isset($talambuhay_status) && $talambuhay_status  == 'pending') : ?>
                                                    <td><label class="badge badge-warning"><?= $talambuhay_status ?></label></td>
                                                <?php elseif (isset($talambuhay_status) && $talambuhay_status  == 'valid') : ?>
                                                    <td><label class="badge badge-success"><?= $talambuhay_status ?></label></td>
                                                <?php elseif (isset($talambuhay_status) && $talambuhay_status  == 'invalid') : ?>
                                                    <td><label class="badge badge-danger"><?= $talambuhay_status ?></label></td>
                                                <?php else : ?>
                                                    <td><label class="badge badge-dark">no file</label></td>
                                                <?php endif; ?>

                                                <td>
                                                    <div class='dropdown'>
                                                        <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action </button>
                                                        <div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuButton1'>
                                                            <h6 class='dropdown-header'>Options</h6>
                                                            <!-- <a class='dropdown-item text-dark' href='#' onclick='showImage("<?php echo $fileName_talambuhay; ?>", "talambuhay")'>View Image</a> -->
                                                            <div class='dropdown-divider'></div>
                                                            <a class='dropdown-item text-primary' href='download_file.php?file=<?= $fileName_talambuhay ?>' target='_blank'>Download</a>
                                                            <div class='dropdown-divider'></div>
                                                            <a class='dropdown-item text-danger' href='javascript:;' onclick="Swal.fire({title: 'Are you sure?', text: 'This will permanently delete the <?= $fileName_talambuhay ?> file. Do you want to proceed?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Yes, delete it!', cancelButtonText: 'No, cancel'}).then((result) => {if (result.isConfirmed) {window.location.href = 'delete_image.php?id=<?= $id ?>&requirement_name=<?= $requirement_name ?>';}})">Delete File</a>
                                                        </div>
                                                </td>
                                            </tr>

                                            <!-- Barangay Clearance Form -->
                                            <tr>
                                                <td><mark>Clearance</mark></td>
                                                <td>
                                                    <?php
                                                    $requirement_name = 'barangay_clearance';

                                                    // Check if a file with the same requirement name exists
                                                    $checkFileQuery = "SELECT file_name, status, DATE_FORMAT(upload_date, '%M %d, %Y') FROM client_requirements WHERE client_id = ? AND requirement_name = ?";
                                                    $checkFileStmt = $dbc->prepare($checkFileQuery);
                                                    $checkFileStmt->bind_param("is", $id, $requirement_name);
                                                    $checkFileStmt->execute();
                                                    $checkFileStmt->store_result();

                                                    if ($checkFileStmt->num_rows > 0) {
                                                        // File exists, display the file name
                                                        $checkFileStmt->bind_result($fileName_barangay, $barangay_status, $bc_u_date);
                                                        $checkFileStmt->fetch();
                                                        echo "File: <a href='view_image.php?id=$id&requirement_name=$requirement_name&file_name=$fileName_barangay'>$fileName_barangay</a>";
                                                    } else {
                                                        // File does not exist, show the upload form
                                                    ?>
                                                        <form action="upload_requirements.php?id=<?= $id ?>" method="post" enctype="multipart/form-data">
                                                            <label for="file_barangay_clearance">Barangay Clearance:</label>
                                                            <div class="input-group">
                                                                <input type="file" id="file_barangay_clearance" name="file_barangay_clearance" class="form-control">
                                                                <button type="submit" class="btn btn-primary btn-icon-text">
                                                                    <i class="mdi mdi-upload btn-icon-prepend"></i>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    <?php
                                                    }

                                                    $checkFileStmt->close();
                                                    ?>

                                                </td>


                                                <?php if (isset($barangay_status) && $barangay_status == 'pending') : ?>
                                                    <td><?= $bc_u_date ?></td>
                                                <?php elseif (isset($barangay_status) && $barangay_status == 'valid') : ?>
                                                    <td><?= $bc_u_date ?></td>
                                                <?php elseif (isset($barangay_status) && $barangay_status == 'invalid') : ?>
                                                    <td><?= $bc_u_date ?></td>
                                                <?php else : ?>
                                                    <td><?php echo '' ?></td>
                                                <?php endif; ?>


                                                <?php if (isset($barangay_status) && $barangay_status  == 'pending') : ?>
                                                    <td><label class="badge badge-warning"><?= $barangay_status ?></label></td>
                                                <?php elseif (isset($barangay_status) && $barangay_status  == 'valid') : ?>
                                                    <td><label class="badge badge-success"><?= $barangay_status ?></label></td>
                                                <?php elseif (isset($barangay_status) && $barangay_status  == 'invalid') : ?>
                                                    <td><label class="badge badge-danger"><?= $barangay_status ?></label></td>
                                                <?php else : ?>
                                                    <td><label class="badge badge-dark">no file</label></td>
                                                <?php endif; ?>

                                                <td>
                                                    <div class='dropdown'>
                                                        <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action </button>
                                                        <div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuButton1'>
                                                            <h6 class='dropdown-header'>Options</h6>
                                                            <!-- <a class='dropdown-item text-dark' href='#' onclick='showImage("<?php echo $fileName_barangay; ?>", "barangay_clearance")'>View Image</a> -->
                                                            <div class='dropdown-divider'></div>
                                                            <a class='dropdown-item text-primary' href='download_file.php?file=<?= $fileName_barangay ?>' target='_blank'>Download</a>
                                                            <div class='dropdown-divider'></div>
                                                            <a class='dropdown-item text-danger' href='javascript:;' onclick="Swal.fire({title: 'Are you sure?', text: 'This will permanently delete the <?= $fileName_barangay ?> file. Do you want to proceed?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Yes, delete it!', cancelButtonText: 'No, cancel'}).then((result) => {if (result.isConfirmed) {window.location.href = 'delete_image.php?id=<?= $id ?>&requirement_name=<?= $requirement_name ?>';}})">Delete File</a>
                                                        </div>
                                                </td>
                                            </tr>


                                            <!-- Case Information Form -->
                                            <tr>
                                                <td>
                                                    <details class="mark">
                                                        <summary>Case Information</summary>
                                                        <p>Information ng kaso (kopya ng habla ng kaso)</p>
                                                    </details>
                                                </td>
                                                <td>
                                                    <?php
                                                    $requirement_name = 'case_info';

                                                    // Check if a file with the same requirement name exists
                                                    $checkFileQuery = "SELECT file_name, status, DATE_FORMAT(upload_date, '%M %d, %Y') FROM client_requirements WHERE client_id = ? AND requirement_name = ?";
                                                    $checkFileStmt = $dbc->prepare($checkFileQuery);
                                                    $checkFileStmt->bind_param("is", $id, $requirement_name);
                                                    $checkFileStmt->execute();
                                                    $checkFileStmt->store_result();

                                                    if ($checkFileStmt->num_rows > 0) {
                                                        // File exists, display the file name
                                                        $checkFileStmt->bind_result($fileName_case_info, $case_info_status, $ci_u_date);
                                                        $checkFileStmt->fetch();
                                                        echo "File: <a href='view_image.php?id=$id&requirement_name=$requirement_name&file_name=$fileName_case_info'>$fileName_case_info</a>";
                                                    } else {
                                                        // File does not exist, show the upload form
                                                    ?>
                                                        <form action="upload_requirements.php?id=<?= $id ?>" method="post" enctype="multipart/form-data">
                                                            <label for="file_case_info">Case Information:</label>
                                                            <div class="input-group">
                                                                <input type="file" id="file_case_info" name="file_case_info" class="form-control">
                                                                <button type="submit" class="btn btn-primary btn-icon-text">
                                                                    <i class="mdi mdi-upload btn-icon-prepend"></i>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    <?php
                                                    }

                                                    $checkFileStmt->close();
                                                    ?>

                                                </td>


                                                <?php if (isset($case_info_status) && $case_info_status == 'pending') : ?>
                                                    <td><?= $ci_u_date ?></td>
                                                <?php elseif (isset($case_info_status) && $case_info_status == 'valid') : ?>
                                                    <td><?= $ci_u_date ?></td>
                                                <?php elseif (isset($case_info_status) && $case_info_status == 'invalid') : ?>
                                                    <td><?= $ci_u_date ?></td>
                                                <?php else : ?>
                                                    <td><?php echo '' ?></td>
                                                <?php endif; ?>


                                                <?php if (isset($case_info_status) && $case_info_status  == 'pending') : ?>
                                                    <td><label class="badge badge-warning"><?= $case_info_status ?></label></td>
                                                <?php elseif (isset($case_info_status) && $case_info_status  == 'valid') : ?>
                                                    <td><label class="badge badge-success"><?= $case_info_status ?></label></td>
                                                <?php elseif (isset($case_info_status) && $case_info_status == 'invalid') : ?>
                                                    <td><label class="badge badge-danger"><?= $case_info_status ?></label></td>
                                                <?php else : ?>
                                                    <td><label class="badge badge-dark">no file</label></td>
                                                <?php endif; ?>

                                                <td>
                                                    <div class='dropdown'>
                                                        <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action </button>
                                                        <div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuButton1'>
                                                            <h6 class='dropdown-header'>Options</h6>
                                                            <!-- <a class='dropdown-item text-dark' href='#' onclick='showImage("<?php echo $fileName_case_info; ?>", "case_info")'>View Image</a> -->
                                                            <div class='dropdown-divider'></div>
                                                            <a class='dropdown-item text-primary' href='download_file.php?file=<?= $fileName_case_info ?>' target='_blank'>Download</a>
                                                            <div class='dropdown-divider'></div>
                                                            <a class='dropdown-item text-danger' href='javascript:;' onclick="Swal.fire({title: 'Are you sure?', text: 'This will permanently delete the <?= $fileName_case_info ?> file. Do you want to proceed?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Yes, delete it!', cancelButtonText: 'No, cancel'}).then((result) => {if (result.isConfirmed) {window.location.href = 'delete_image.php?id=<?= $id ?>&requirement_name=<?= $requirement_name ?>';}})">Delete File</a>
                                                        </div>
                                                </td>
                                            </tr>


                                            <!-- Decision/Jugdement Form -->
                                            <tr>
                                                <td>
                                                    <details class="mark">
                                                        <summary>Decision/Judgement</summary>
                                                        <p>Decision/Judgement ng kaso (kopya ng hatol/sentensya)</p>
                                                        <p>Clear scanned/image</p>
                                                    </details>
                                                </td>
                                                <td>
                                                    <?php
                                                    $requirement_name = 'case_judgement';

                                                    // Check if a file with the same requirement name exists
                                                    $checkFileQuery = "SELECT file_name, status, DATE_FORMAT(upload_date, '%M %d, %Y') FROM client_requirements WHERE client_id = ? AND requirement_name = ?";
                                                    $checkFileStmt = $dbc->prepare($checkFileQuery);
                                                    $checkFileStmt->bind_param("is", $id, $requirement_name);
                                                    $checkFileStmt->execute();
                                                    $checkFileStmt->store_result();

                                                    if ($checkFileStmt->num_rows > 0) {
                                                        // File exists, display the file name
                                                        $checkFileStmt->bind_result($fileName_case_judgement, $case_judgement_status, $cj_u_date);
                                                        $checkFileStmt->fetch();
                                                        echo "File: <a href='view_image.php?id=$id&requirement_name=$requirement_name&file_name=$fileName_case_judgement'>$fileName_case_judgement</a>";
                                                    } else {
                                                        // File does not exist, show the upload form
                                                    ?>
                                                        <form action="upload_requirements.php?id=<?= $id ?>" method="post" enctype="multipart/form-data">
                                                            <label for="file_case_judgement">Case Decision/Judgement:</label>
                                                            <div class="input-group">
                                                                <input type="file" id="file_case_judgement" name="file_case_judgement" class="form-control">
                                                                <button type="submit" class="btn btn-primary btn-icon-text">
                                                                    <i class="mdi mdi-upload btn-icon-prepend"></i>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    <?php
                                                    }

                                                    $checkFileStmt->close();
                                                    ?>

                                                </td>


                                                <?php if (isset($case_judgement_status) && $case_judgement_status == 'pending') : ?>
                                                    <td><?= $cj_u_date ?></td>
                                                <?php elseif (isset($case_judgement_status) && $case_judgement_status == 'valid') : ?>
                                                    <td><?= $cj_u_date ?></td>
                                                <?php elseif (isset($case_judgement_status) && $case_judgement_status == 'invalid') : ?>
                                                    <td><?= $cj_u_date ?></td>
                                                <?php else : ?>
                                                    <td><?php echo '' ?></td>
                                                <?php endif; ?>


                                                <?php if (isset($case_judgement_status) && $case_judgement_status == 'pending') : ?>
                                                    <td><label class="badge badge-warning"><?= $case_judgement_status ?></label></td>
                                                <?php elseif (isset($case_judgement_status) && $case_judgement_status  == 'valid') : ?>
                                                    <td><label class="badge badge-success"><?= $case_judgement_status ?></label></td>
                                                <?php elseif (isset($case_judgement_status) && $case_judgement_status == 'invalid') : ?>
                                                    <td><label class="badge badge-danger"><?= $case_judgement_status ?></label></td>
                                                <?php else : ?>
                                                    <td><label class="badge badge-dark">no file</label></td>
                                                <?php endif; ?>

                                                <td>
                                                    <div class='dropdown'>
                                                        <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action </button>
                                                        <div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuButton1'>
                                                            <h6 class='dropdown-header'>Options</h6>
                                                            <!-- <a class='dropdown-item text-dark' href='#' onclick='showImage("<?php echo $fileName_case_judgement; ?>", "case_judgement")'>View Image</a> -->
                                                            <div class='dropdown-divider'></div>
                                                            <a class='dropdown-item text-primary' href='download_file.php?file=<?= $fileName_case_judgement ?>' target='_blank'>Download</a>
                                                            <div class='dropdown-divider'></div>
                                                            <a class='dropdown-item text-danger' href='javascript:;' onclick="Swal.fire({title: 'Are you sure?', text: 'This will permanently delete the <?= $fileName_case_judgement ?> file. Do you want to proceed?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Yes, delete it!', cancelButtonText: 'No, cancel'}).then((result) => {if (result.isConfirmed) {window.location.href = 'delete_image.php?id=<?= $id ?>&requirement_name=<?= $requirement_name ?>';}})">Delete File</a>
                                                        </div>
                                                </td>
                                            </tr>


                                            <!-- Petition for Probation -->
                                            <tr>
                                                <td>
                                                    <details class="mark">
                                                        <summary>Petition for Probation</summary>
                                                        <p>Petition for Probation (kopya ng petisyon na ginawa ng PAO)</p>
                                                    </details>
                                                </td>
                                                <td>
                                                    <?php
                                                    $requirement_name = 'petition_for_probation';

                                                    // Check if a file with the same requirement name exists
                                                    $checkFileQuery = "SELECT file_name, status, DATE_FORMAT(upload_date, '%M %d, %Y') FROM client_requirements WHERE client_id = ? AND requirement_name = ?";
                                                    $checkFileStmt = $dbc->prepare($checkFileQuery);
                                                    $checkFileStmt->bind_param("is", $id, $requirement_name);
                                                    $checkFileStmt->execute();
                                                    $checkFileStmt->store_result();

                                                    if ($checkFileStmt->num_rows > 0) {
                                                        // File exists, display the file name
                                                        $checkFileStmt->bind_result($fileName_petition, $case_petition_status, $petition_upload_date);
                                                        $checkFileStmt->fetch();
                                                        echo "File: <a href='view_image.php?id=$id&requirement_name=$requirement_name&file_name=$fileName_petition'>$fileName_petition</a>";
                                                    } else {
                                                        // File does not exist, show the upload form
                                                    ?>
                                                        <form action="upload_requirements.php?id=<?= $id ?>" method="post" enctype="multipart/form-data">
                                                            <label for="file_petition_for_probation">Petition for Probation:</label>
                                                            <div class="input-group">
                                                                <input type="file" id="file_petition_for_probation" name="file_petition_for_probation" class="form-control">
                                                                <button type="submit" class="btn btn-primary btn-icon-text">
                                                                    <i class="mdi mdi-upload btn-icon-prepend"></i>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    <?php
                                                    }

                                                    $checkFileStmt->close();
                                                    ?>

                                                </td>

                                                <?php if (isset($case_petition_status) && $case_petition_status == 'pending') : ?>
                                                    <td><?= $petition_upload_date ?></td>
                                                <?php elseif (isset($case_petition_status) && $case_petition_status == 'valid') : ?>
                                                    <td><?= $petition_upload_date ?></td>
                                                <?php elseif (isset($case_petition_status) && $case_petition_status == 'invalid') : ?>
                                                    <td><?= $petition_upload_date ?></td>
                                                <?php else : ?>
                                                    <td><?php echo '' ?></td>
                                                <?php endif; ?>

                                                <?php if (isset($case_petition_status) && $case_petition_status == 'pending') : ?>
                                                    <td><label class="badge badge-warning"><?= $case_petition_status ?></label></td>
                                                <?php elseif (isset($case_petition_status) && $case_petition_status  == 'valid') : ?>
                                                    <td><label class="badge badge-success"><?= $case_petition_status ?></label></td>
                                                <?php elseif (isset($case_petition_status) && $case_petition_status == 'invalid') : ?>
                                                    <td><label class="badge badge-danger"><?= $case_petition_status ?></label></td>
                                                <?php else : ?>
                                                    <td><label class="badge badge-dark">no file</label></td>
                                                <?php endif; ?>

                                                <td>
                                                    <div class='dropdown'>
                                                        <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action </button>
                                                        <div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuButton1'>
                                                            <h6 class='dropdown-header'>Options</h6>
                                                            <!-- <a class='dropdown-item text-dark' href='#' onclick='showImage("<?php echo $fileName_petition ?>", "petition_for_probation")'>View Image</a> -->
                                                            <div class='dropdown-divider'></div>
                                                            <a class='dropdown-item text-primary' href='download_file.php?file=<?= $fileName_petition ?>' target='_blank'>Download</a>
                                                            <div class='dropdown-divider'></div>
                                                            <a class='dropdown-item text-danger' href='javascript:;' onclick="Swal.fire({title: 'Are you sure?', text: 'This will permanently delete the <?= $fileName_petition ?> file. Do you want to proceed?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Yes, delete it!', cancelButtonText: 'No, cancel'}).then((result) => {if (result.isConfirmed) {window.location.href = 'delete_image.php?id=<?= $id ?>&requirement_name=<?= $requirement_name ?>';}})">Delete File</a>
                                                        </div>
                                                </td>
                                            </tr>


                                            <!-- Order to Conduct PS1 -->
                                            <tr>
                                                <td>
                                                    <details class="mark">
                                                        <summary>Order to Conduct PS1</summary>
                                                        <p>(kopya na naguutos na ikaw ay <br>
                                                            dapat imbestigahan ng probation)</p>
                                                        <p>Clear scanned/image</p>
                                                    </details>
                                                </td>
                                                <td>
                                                    <?php
                                                    $requirement_name = 'order_to_conduct_ps1';

                                                    // Check if a file with the same requirement name exists
                                                    $checkFileQuery = "SELECT file_name, status, DATE_FORMAT(upload_date, '%M %d, %Y') FROM client_requirements WHERE client_id = ? AND requirement_name = ?";
                                                    $checkFileStmt = $dbc->prepare($checkFileQuery);
                                                    $checkFileStmt->bind_param("is", $id, $requirement_name);
                                                    $checkFileStmt->execute();
                                                    $checkFileStmt->store_result();

                                                    if ($checkFileStmt->num_rows > 0) {
                                                        // File exists, display the file name
                                                        $checkFileStmt->bind_result($fileName_conduct_ps1, $case_ps1_status, $u_date);
                                                        $checkFileStmt->fetch();
                                                        echo "File: <a href='view_image.php?id=$id&requirement_name=$requirement_name&file_name=$fileName_conduct_ps1'>$fileName_conduct_ps1</a>";
                                                    } else {
                                                        // File does not exist, show the upload form
                                                    ?>
                                                        <form action="upload_requirements.php?id=<?= $id ?>" method="post" enctype="multipart/form-data">
                                                            <label for="file_conduct_ps1">Order to Conduct PS1:</label>
                                                            <div class="input-group">
                                                                <input type="file" id="file_conduct_ps1" name="file_conduct_ps1" class="form-control">
                                                                <button type="submit" class="btn btn-primary btn-icon-text">
                                                                    <i class="mdi mdi-upload btn-icon-prepend"></i>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    <?php
                                                    }

                                                    $checkFileStmt->close();
                                                    ?>


                                                </td>

                                                <?php if (isset($u_date)) : ?>
                                                    <td><?= $u_date ?></td>
                                                <?php else : ?>
                                                    <td><?php echo '' ?></td>
                                                <?php endif; ?>


                                                <?php if (isset($case_ps1_status) && $case_ps1_status == 'pending') : ?>
                                                    <td><label class="badge badge-warning"><?= $case_ps1_status ?></label></td>
                                                <?php elseif (isset($case_ps1_status) && $case_ps1_status  == 'valid') : ?>
                                                    <td><label class="badge badge-success"><?= $case_ps1_status ?></label></td>
                                                <?php elseif (isset($case_ps1_status) && $case_ps1_status == 'invalid') : ?>
                                                    <td><label class="badge badge-danger"><?= $case_ps1_status ?></label></td>
                                                <?php else : ?>
                                                    <td><label class="badge badge-dark">no file</label></td>
                                                <?php endif; ?>

                                                <td>
                                                    <div class='dropdown'>
                                                        <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action </button>
                                                        <div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuButton1'>
                                                            <h6 class='dropdown-header'>Options</h6>
                                                            <!-- <a class='dropdown-item text-dark' href='#' onclick='showImage("<?php echo $fileName_conduct_ps1 ?>", "petition_for_probation")'>View Image</a> -->
                                                            <div class='dropdown-divider'></div>
                                                            <a class='dropdown-item text-primary' href='download_file.php?file=<?= $fileName_conduct_ps1 ?>' target='_blank'>Download</a>
                                                            <div class='dropdown-divider'></div>
                                                            <a class='dropdown-item text-danger' href='javascript:;' onclick="Swal.fire({title: 'Are you sure?', text: 'This will permanently delete the <?= $fileName_conduct_ps1 ?> file. Do you want to proceed?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Yes, delete it!', cancelButtonText: 'No, cancel'}).then((result) => {if (result.isConfirmed) {window.location.href = 'delete_image.php?id=<?= $id ?>&requirement_name=<?= $requirement_name ?>';}})">Delete File</a>
                                                        </div>
                                                </td>
                                            </tr>


                                            <!-- Order of Dissmissed/acquitted cases -->
                                            <tr>
                                                <td>
                                                    <details class="mark">
                                                        <summary>Order of Dissmissed/acquitted</summary>
                                                        <p>(kopya ng nangyari sa mga dating kaso kung meron)</p>
                                                        <p>Clear scanned/image</p>
                                                    </details>
                                                </td>
                                                <td>
                                                    <?php
                                                    $requirement_name = 'case_dissmissed';

                                                    // Check if a file with the same requirement name exists
                                                    $checkFileQuery = "SELECT file_name, status, DATE_FORMAT(upload_date, '%M %d, %Y') FROM client_requirements WHERE client_id = ? AND requirement_name = ?";
                                                    $checkFileStmt = $dbc->prepare($checkFileQuery);
                                                    $checkFileStmt->bind_param("is", $id, $requirement_name);
                                                    $checkFileStmt->execute();
                                                    $checkFileStmt->store_result();

                                                    if ($checkFileStmt->num_rows > 0) {
                                                        // File exists, display the file name
                                                        $checkFileStmt->bind_result($fileName_case_dissmissed, $case_dissmissed_status, $cd_upload_date);
                                                        $checkFileStmt->fetch();
                                                        echo "File: <a href='view_image.php?id=$id&requirement_name=$requirement_name&file_name=$fileName_case_dissmissed'>$fileName_case_dissmissed</a>";
                                                    } else {
                                                        // File does not exist, show the upload form
                                                    ?>
                                                        <form action="upload_requirements.php?id=<?= $id ?>" method="post" enctype="multipart/form-data">
                                                            <label for="file_case_dissmissed">Order of Dissmissed/acquitted cases:</label>
                                                            <div class="input-group">
                                                                <input type="file" id="file_case_dissmissed" name="file_case_dissmissed" class="form-control">
                                                                <button type="submit" class="btn btn-primary btn-icon-text">
                                                                    <i class="mdi mdi-upload btn-icon-prepend"></i>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    <?php
                                                    }

                                                    $checkFileStmt->close();
                                                    ?>

                                                </td>

                                                <?php if (isset($cd_upload_date)) : ?>
                                                    <td><?= $cd_upload_date ?></td>
                                                <?php else : ?>
                                                    <td><?php echo '' ?></td>
                                                <?php endif; ?>

                                                <?php if (isset($case_dissmissed_status) && $case_dissmissed_status == 'pending') : ?>
                                                    <td><label class="badge badge-warning"><?= $case_dissmissed_status ?></label></td>
                                                <?php elseif (isset($case_dissmissed_status) && $case_dissmissed_status  == 'valid') : ?>
                                                    <td><label class="badge badge-success"><?= $case_dissmissed_status ?></label></td>
                                                <?php elseif (isset($case_dissmissed_status) && $case_dissmissed_status == 'invalid') : ?>
                                                    <td><label class="badge badge-danger"><?= $case_dissmissed_status ?></label></td>
                                                <?php else : ?>
                                                    <td><label class="badge badge-dark">no file</label></td>
                                                <?php endif; ?>

                                                <td>
                                                    <div class='dropdown'>
                                                        <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action </button>
                                                        <div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuButton1'>
                                                            <h6 class='dropdown-header'>Options</h6>
                                                            <!-- <a class='dropdown-item text-dark' href='#' onclick='showImage("<?php echo $fileName_case_dissmissed ?>", "case_dissmissed")'>View Image</a> -->
                                                            <div class='dropdown-divider'></div>
                                                            <a class='dropdown-item text-primary' href='download_file.php?file=<?= $fileName_case_dissmissed ?>' target='_blank'>Download</a>
                                                            <div class='dropdown-divider'></div>
                                                            <a class='dropdown-item text-danger' href='javascript:;' onclick="Swal.fire({title: 'Are you sure?', text: 'This will permanently delete the <?= $fileName_case_dissmissed ?> file. Do you want to proceed?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Yes, delete it!', cancelButtonText: 'No, cancel'}).then((result) => {if (result.isConfirmed) {window.location.href = 'delete_image.php?id=<?= $id ?>&requirement_name=<?= $requirement_name ?>';}})">Delete File</a>
                                                        </div>
                                                </td>
                                            </tr>


                                            <!-- Police Clearance -->
                                            <tr>
                                                <td>
                                                    <details class="mark">
                                                        <summary>Police Clearance</summary>
                                                        <p>kukunin sa inyong police station
                                                            kung saan nakatira</p>
                                                        <p>Clear scanned/image</p>
                                                    </details>
                                                </td>
                                                <td>
                                                    <?php
                                                    $requirement_name = 'police_clearance';

                                                    // Check if a file with the same requirement name exists
                                                    $checkFileQuery = "SELECT file_name, status, DATE_FORMAT(upload_date, '%M %d, %Y') FROM client_requirements WHERE client_id = ? AND requirement_name = ?";
                                                    $checkFileStmt = $dbc->prepare($checkFileQuery);
                                                    $checkFileStmt->bind_param("is", $id, $requirement_name);
                                                    $checkFileStmt->execute();
                                                    $checkFileStmt->store_result();

                                                    if ($checkFileStmt->num_rows > 0) {
                                                        // File exists, display the file name
                                                        $checkFileStmt->bind_result($fileName_police_clearance, $police_clearance_status, $pc_upload_date);
                                                        $checkFileStmt->fetch();
                                                        echo "File: <a href='view_image.php?id=$id&requirement_name=$requirement_name&file_name=$fileName_police_clearance'>$fileName_police_clearance</a>";
                                                    } else {
                                                        // File does not exist, show the upload form
                                                    ?>
                                                        <form action="upload_requirements.php?id=<?= $id ?>" method="post" enctype="multipart/form-data">
                                                            <label for="file_police_clearance">Police Clearance:</label>
                                                            <div class="input-group">
                                                                <input type="file" id="file_police_clearance" name="file_police_clearance" class="form-control">
                                                                <button type="submit" class="btn btn-primary btn-icon-text">
                                                                    <i class="mdi mdi-upload btn-icon-prepend"></i>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    <?php
                                                    }

                                                    $checkFileStmt->close();
                                                    ?>

                                                </td>

                                                <?php if (isset($pc_upload_date)) : ?>
                                                    <td><?= $pc_upload_date ?></td>
                                                <?php else : ?>
                                                    <td><?php echo '' ?></td>
                                                <?php endif; ?>

                                                <?php if (isset($police_clearance_status) && $police_clearance_status == 'pending') : ?>
                                                    <td><label class="badge badge-warning"><?= $police_clearance_status ?></label></td>
                                                <?php elseif (isset($police_clearance_status) && $police_clearance_status  == 'valid') : ?>
                                                    <td><label class="badge badge-success"><?= $police_clearance_status ?></label></td>
                                                <?php elseif (isset($police_clearance_status) && $police_clearance_status == 'invalid') : ?>
                                                    <td><label class="badge badge-danger"><?= $police_clearance_status ?></label></td>
                                                <?php else : ?>
                                                    <td><label class="badge badge-dark">no file</label></td>
                                                <?php endif; ?>

                                                <td>
                                                    <div class='dropdown'>
                                                        <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action </button>
                                                        <div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuButton1'>
                                                            <h6 class='dropdown-header'>Options</h6>
                                                            <!-- <a class='dropdown-item text-dark' href='#' onclick='showImage("<?php echo $fileName_police_clearance ?>", "police_clearance")'>View Image</a> -->
                                                            <div class='dropdown-divider'></div>
                                                            <a class='dropdown-item text-primary' href='download_file.php?file=<?= $fileName_police_clearance ?>' target='_blank'>Download</a>
                                                            <div class='dropdown-divider'></div>
                                                            <a class='dropdown-item text-danger' href='javascript:;' onclick="Swal.fire({title: 'Are you sure?', text: 'This will permanently delete the <?= $fileName_police_clearance ?> file. Do you want to proceed?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Yes, delete it!', cancelButtonText: 'No, cancel'}).then((result) => {if (result.isConfirmed) {window.location.href = 'delete_image.php?id=<?= $id ?>&requirement_name=<?= $requirement_name ?>';}})">Delete File</a>
                                                        </div>
                                                </td>
                                            </tr>


                                            <!-- RTC/MTC/MCTC CLEARANCE -->
                                            <tr>
                                                <td>
                                                    <details class="mark">
                                                        <summary>MTC/MCTC Clearance</summary>
                                                        <p>Municipal Orcuit Trial Court(MCTC) <br>
                                                            Clearance depende sa nakakasakop sa inyong lugar</p>
                                                        <p>Clear scanned/image</p>
                                                    </details>
                                                </td>
                                                <td>
                                                    <?php
                                                    $requirement_name = 'mtc_mtcc_clearance';

                                                    // Check if a file with the same requirement name exists
                                                    $checkFileQuery = "SELECT file_name, status, DATE_FORMAT(upload_date, '%M %d, %Y') FROM client_requirements WHERE client_id = ? AND requirement_name = ?";
                                                    $checkFileStmt = $dbc->prepare($checkFileQuery);
                                                    $checkFileStmt->bind_param("is", $id, $requirement_name);
                                                    $checkFileStmt->execute();
                                                    $checkFileStmt->store_result();

                                                    if ($checkFileStmt->num_rows > 0) {
                                                        // File exists, display the file name
                                                        $checkFileStmt->bind_result($fileName_mtc_mtcc_clearance, $mtc_mtcc_clearance_status, $mtc_mtcc_clearance_upload_date);
                                                        $checkFileStmt->fetch();
                                                        echo "File: <a href='view_image.php?id=$id&requirement_name=$requirement_name&file_name=$fileName_mtc_mtcc_clearance'>$fileName_mtc_mtcc_clearance</a>";
                                                    } else {
                                                        // File does not exist, show the upload form
                                                    ?>
                                                        <form action="upload_requirements.php?id=<?= $id ?>" method="post" enctype="multipart/form-data">
                                                            <label for="file_mtc_mtcc_clearance">MTC/MTCC Clearance:</label>
                                                            <div class="input-group">
                                                                <input type="file" id="file_mtc_mtcc_clearance" name="file_mtc_mtcc_clearance" class="form-control">
                                                                <button type="submit" class="btn btn-primary btn-icon-text">
                                                                    <i class="mdi mdi-upload btn-icon-prepend"></i>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    <?php
                                                    }

                                                    $checkFileStmt->close();
                                                    ?>

                                                </td>

                                                <?php if (isset($mtc_mtcc_clearance_upload_date)) : ?>
                                                    <td><?= $mtc_mtcc_clearance_upload_date ?></td>
                                                <?php else : ?>
                                                    <td><?php echo '' ?></td>
                                                <?php endif; ?>

                                                <?php if (isset($mtc_mtcc_clearance_status) && $mtc_mtcc_clearance_status == 'pending') : ?>
                                                    <td><label class="badge badge-warning"><?= $mtc_mtcc_clearance_status ?></label></td>
                                                <?php elseif (isset($mtc_mtcc_clearance_status) && $mtc_mtcc_clearance_status  == 'valid') : ?>
                                                    <td><label class="badge badge-success"><?= $mtc_mtcc_clearance_status ?></label></td>
                                                <?php elseif (isset($mtc_mtcc_clearance_status) && $mtc_mtcc_clearance_status == 'invalid') : ?>
                                                    <td><label class="badge badge-danger"><?= $mtc_mtcc_clearance_status ?></label></td>
                                                <?php else : ?>
                                                    <td><label class="badge badge-dark">no file</label></td>
                                                <?php endif; ?>

                                                <td>
                                                    <div class='dropdown'>
                                                        <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action </button>
                                                        <div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuButton1'>
                                                            <h6 class='dropdown-header'>Options</h6>
                                                            <!-- <a class='dropdown-item text-dark' href='#' onclick='showImage("<?php echo $fileName_mtc_mtcc_clearance ?>", "mtc_mtcc_clearance")'>View Image</a> -->
                                                            <div class='dropdown-divider'></div>
                                                            <a class='dropdown-item text-primary' href='download_file.php?file=<?= $fileName_mtc_mtcc_clearance ?>' target='_blank'>Download</a>
                                                            <div class='dropdown-divider'></div>
                                                            <a class='dropdown-item text-danger' href='javascript:;' onclick="Swal.fire({title: 'Are you sure?', text: 'This will permanently delete the <?= $fileName_mtc_mtcc_clearance ?> file. Do you want to proceed?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Yes, delete it!', cancelButtonText: 'No, cancel'}).then((result) => {if (result.isConfirmed) {window.location.href = 'delete_image.php?id=<?= $id ?>&requirement_name=<?= $requirement_name ?>';}})">Delete File</a>
                                                        </div>
                                                </td>
                                            </tr>


                                            <!-- NBI CLEARANCE -->
                                            <tr>
                                                <td>
                                                    <details class="mark">
                                                        <summary>NBI Clearance</summary>
                                                        <p>Nbi Clearance</p>
                                                        <p>Clear scanned/image</p>
                                                    </details>
                                                </td>
                                                <td>
                                                    <?php
                                                    $requirement_name = 'nbi_clearance';

                                                    // Check if a file with the same requirement name exists
                                                    $checkFileQuery = "SELECT file_name, status, DATE_FORMAT(upload_date, '%M %d, %Y') FROM client_requirements WHERE client_id = ? AND requirement_name = ?";
                                                    $checkFileStmt = $dbc->prepare($checkFileQuery);
                                                    $checkFileStmt->bind_param("is", $id, $requirement_name);
                                                    $checkFileStmt->execute();
                                                    $checkFileStmt->store_result();

                                                    if ($checkFileStmt->num_rows > 0) {
                                                        // File exists, display the file name
                                                        $checkFileStmt->bind_result($fileName_nbi_clearance, $nbi_clearance_status, $nbi_clearance_upload_date);
                                                        $checkFileStmt->fetch();
                                                        echo "File: <a href='view_image.php?id=$id&requirement_name=$requirement_name&file_name=$fileName_nbi_clearance'>$fileName_nbi_clearance</a>";
                                                    } else {
                                                        // File does not exist, show the upload form
                                                    ?>
                                                        <form action="upload_requirements.php?id=<?= $id ?>" method="post" enctype="multipart/form-data">
                                                            <label for="file_nbi_clearance">NBI Clearance:</label>
                                                            <div class="input-group">
                                                                <input type="file" id="file_nbi_clearance" name="file_nbi_clearance" class="form-control">
                                                                <button type="submit" class="btn btn-primary btn-icon-text">
                                                                    <i class="mdi mdi-upload btn-icon-prepend"></i>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    <?php
                                                    }

                                                    $checkFileStmt->close();
                                                    ?>

                                                </td>

                                                <?php if (isset($nbi_clearance_upload_date)) : ?>
                                                    <td><?= $nbi_clearance_upload_date ?></td>
                                                <?php else : ?>
                                                    <td><?php echo '' ?></td>
                                                <?php endif; ?>

                                                <?php if (isset($nbi_clearance_status) && $nbi_clearance_status == 'pending') : ?>
                                                    <td><label class="badge badge-warning"><?= $nbi_clearance_status ?></label></td>
                                                <?php elseif (isset($nbi_clearance_status) && $nbi_clearance_status  == 'valid') : ?>
                                                    <td><label class="badge badge-success"><?= $nbi_clearance_status ?></label></td>
                                                <?php elseif (isset($nbi_clearance_status) && $nbi_clearance_status == 'invalid') : ?>
                                                    <td><label class="badge badge-danger"><?= $nbi_clearance_status ?></label></td>
                                                <?php else : ?>
                                                    <td><label class="badge badge-dark">no file</label></td>
                                                <?php endif; ?>

                                                <td>
                                                    <div class='dropdown'>
                                                        <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action </button>
                                                        <div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuButton1'>
                                                            <h6 class='dropdown-header'>Options</h6>
                                                            <!-- <a class='dropdown-item text-dark' href='#' onclick='showImage("<?php echo $fileName_nbi_clearance ?>", "nbi_clearance")'>View Image</a> -->
                                                            <div class='dropdown-divider'></div>
                                                            <a class='dropdown-item text-primary' href='download_file.php?file=<?= $fileName_nbi_clearance ?>' target='_blank'>Download</a>
                                                            <div class='dropdown-divider'></div>
                                                            <a class='dropdown-item text-danger' href='javascript:;' onclick="Swal.fire({title: 'Are you sure?', text: 'This will permanently delete the <?= $fileName_nbi_clearance ?> file. Do you want to proceed?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Yes, delete it!', cancelButtonText: 'No, cancel'}).then((result) => {if (result.isConfirmed) {window.location.href = 'delete_image.php?id=<?= $id ?>&requirement_name=<?= $requirement_name ?>';}})">Delete File</a>
                                                        </div>
                                                </td>
                                            </tr>


                                            <!-- DRUG TEST RESULT -->
                                            <tr>
                                                <td>
                                                    <details class="mark">
                                                        <summary>Drug Test Result</summary>
                                                        <p>(URINE/IHI FROM ANY DOH ACCREDITED LABORATORY)</p>
                                                        <p>Clear scanned/image</p>
                                                    </details>
                                                </td>
                                                <td>
                                                    <?php
                                                    $requirement_name = 'drug_test_result';

                                                    // Check if a file with the same requirement name exists
                                                    $checkFileQuery = "SELECT file_name, status, DATE_FORMAT(upload_date, '%b. %d, %Y') FROM client_requirements WHERE client_id = ? AND requirement_name = ?";
                                                    $checkFileStmt = $dbc->prepare($checkFileQuery);
                                                    $checkFileStmt->bind_param("is", $id, $requirement_name);
                                                    $checkFileStmt->execute();
                                                    $checkFileStmt->store_result();

                                                    if ($checkFileStmt->num_rows > 0) {
                                                        // File exists, display the file name
                                                        $checkFileStmt->bind_result($fileName_drug_test_result, $drug_test_result_status, $drug_test_result_upload_date);
                                                        $checkFileStmt->fetch();
                                                        echo "File: <a href='view_image.php?id=$id&requirement_name=$requirement_name&file_name=$fileName_drug_test_result'>$fileName_drug_test_result</a>";
                                                    } else {
                                                        // File does not exist, show the upload form
                                                    ?>
                                                        <form action="upload_requirements.php?id=<?= $id ?>" method="post" enctype="multipart/form-data">
                                                            <label for="file_drug_test_result" class="form-label">Drug Test Result:</label>
                                                            <div class="input-group">
                                                                <input type="file" id="file_drug_test_result" name="file_drug_test_result" class="form-control">
                                                                <button type="submit" class="btn btn-primary btn-icon-text">
                                                                    <i class="mdi mdi-upload btn-icon-prepend"></i>
                                                                </button>
                                                            </div>
                                                        </form>


                                                    <?php
                                                    }

                                                    $checkFileStmt->close();
                                                    ?>

                                                </td>

                                                <?php if (isset($drug_test_result_upload_date)) : ?>
                                                    <td><?= $drug_test_result_upload_date ?></td>
                                                <?php else : ?>
                                                    <td><?php echo '' ?></td>
                                                <?php endif; ?>

                                                <?php if (isset($drug_test_result_status) && $drug_test_result_status == 'pending') : ?>
                                                    <td><label class="badge badge-warning"><?= $drug_test_result_status ?></label></td>
                                                <?php elseif (isset($drug_test_result_status) && $drug_test_result_status  == 'valid') : ?>
                                                    <td><label class="badge badge-success"><?= $drug_test_result_status ?></label></td>
                                                <?php elseif (isset($drug_test_result_status) && $drug_test_result_status == 'invalid') : ?>
                                                    <td><label class="badge badge-danger"><?= $drug_test_result_status ?></label></td>
                                                <?php else : ?>
                                                    <td><label class="badge badge-dark">no file</label></td>
                                                <?php endif; ?>

                                                <td>
                                                    <div class='dropdown'>
                                                        <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action </button>
                                                        <div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuButton1'>
                                                            <h6 class='dropdown-header'>Options</h6>
                                                            <!-- <a class='dropdown-item text-dark' href='#' onclick='showImage("<?php echo $fileName_drug_test_result ?>", "drug_test_result")'>View Image</a> -->
                                                            <div class='dropdown-divider'></div>
                                                            <a class='dropdown-item text-primary' href='download_file.php?file=<?= $fileName_drug_test_result ?>' target='_blank'>Download</a>
                                                            <div class='dropdown-divider'></div>
                                                            <a class='dropdown-item text-danger' href='javascript:;' onclick="Swal.fire({title: 'Are you sure?', text: 'This will permanently delete the <?= $fileName_drug_test_result ?> file. Do you want to proceed?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Yes, delete it!', cancelButtonText: 'No, cancel'}).then((result) => {if (result.isConfirmed) {window.location.href = 'delete_image.php?id=<?= $id ?>&requirement_name=<?= $requirement_name ?>';}})">Delete File</a>
                                                        </div>
                                                </td>
                                            </tr>


                                        </tbody>
                                    </table>
                                </div><br><br>

                                <?php
                                $birthCertUploaded         = isset($file_status)               && $file_status == 'pending'               || isset($file_status)               && $file_status == 'valid';
                                $validIdUploaded           = isset($valid_id_status)           && $valid_id_status == 'pending'           || isset($valid_id_status)           && $valid_id_status == 'valid';
                                $talambuhayUploaded        = isset($talambuhay_status)         && $talambuhay_status == 'pending'         || isset($talambuhay_status)         &&  $talambuhay_status == 'valid';
                                $barangayClearanceUploaded = isset($barangay_status)           && $barangay_status == 'pending'           || isset($barangay_status)           && $barangay_status == 'valid';
                                $caseInfoUploaded          = isset($case_info_status)          && $case_info_status == 'pending'          || isset($case_info_status)          && $case_info_status == 'valid';
                                $caseJudgementUploaded     = isset($case_judgement_status)     && $case_judgement_status == 'pending'     || isset($case_judgement_status)     && $case_judgement_status == 'valid';
                                $petitionUploaded          = isset($case_petition_status)      && $case_petition_status == 'pending'      || isset($case_petition_status)      && $case_petition_status == 'valid';
                                $PS1Uploaded               = isset($case_ps1_status)           && $case_ps1_status == 'pending'           || isset($case_ps1_status)           && $case_ps1_status == 'valid';
                                $caseDissmissedUploaded    = isset($case_dissmissed_status)    && $case_dissmissed_status == 'pending'    || isset($case_dissmissed_status)    && $case_dissmissed_status == 'valid';
                                $policeClearanceUploaded   = isset($police_clearance_status)   && $police_clearance_status == 'pending'   || isset($police_clearance_status)   && $police_clearance_status == 'valid';
                                $mtcClearanceUploaded      = isset($mtc_mtcc_clearance_status) && $mtc_mtcc_clearance_status == 'pending' || isset($mtc_mtcc_clearance_status) && $mtc_mtcc_clearance_status == 'valid';
                                $nbiClearanceUploaded      = isset($nbi_clearance_status)      && $nbi_clearance_status == 'pending'      || isset($nbi_clearance_status)      && $nbi_clearance_status == 'valid';
                                $drugTestResultUploaded    = isset($drug_test_result_status)   && $drug_test_result_status == 'pending'   || isset($drug_test_result_status)   && $drug_test_result_status == 'valid';


                                // Check if files are uploaded to enable the button
                                $enableButton = $birthCertUploaded && $validIdUploaded && $talambuhayUploaded && $barangayClearanceUploaded && $caseInfoUploaded && $caseJudgementUploaded &&
                                    $petitionUploaded && $PS1Uploaded && $caseDissmissedUploaded && $policeClearanceUploaded && $mtcClearanceUploaded && $nbiClearanceUploaded && $drugTestResultUploaded;

                                $policy_check = isset($_GET['policy_check']) && $_GET['policy_check'] == 'true';
                                ?>

                                <div class="row">
                                    </div>
                                    
                                    <div class="row">
                                        <?php if ($enableButton) : ?>
                                            <form method="post" action="upload_requirements.php?id=<?= $id ?>">
                                                <div class="col-12">
                                                    <div class="form-check" style="padding: 0 35px;">
                                                        <input class="form-check-input" type="checkbox" value="policy" id="flexCheckDefault" required name="privacy_policy">
                                                        <label class="form-check-label text-danger font-weight-bold" style="text-align: justify; margin-left: 3px;" for="flexCheckDefault">
                                                            "Mahalagang Paalala: Sa pag-upload ng iyong mga file sa website ng Laguna Parole and Probation Office para sa pagproseso ng iyong aplikasyon sa probation, pinapayagan mo ang mga administrador na gamitin ang impormasyong ito sa proseso ng imbestigasyon. Ang impormasyong iyong ibinahagi ay maaaring gamitin upang matiyak na kumpleto at tama ang iyong aplikasyon.
            
                                                            Pakitiyak na ang lahat ng mga dokumento at impormasyon na iyong ibinahagi ay totoo at hindi nilikha o binago upang magbigay ng maling impormasyon. Ang anumang pagkakamali o pagkukulang sa impormasyon ay maaaring magdulot ng hindi pag-apruba ng iyong aplikasyon.
            
                                                            Sa pagpapasa ng iyong mga file, sumasang-ayon ka rin na ang mga administrator ng website ay maaaring makipag-ugnay sa iba pang mga ahensya o indibidwal kaugnay sa iyong aplikasyon sa probation, kung kinakailangan ng proseso ng imbestigasyon.
            
                                                            Sa ganitong paraan, ang iyong kooperasyon sa pagbibigay ng tumpak na impormasyon at pagpayag sa paggamit nito ay makakatulong sa mabilis at maayos na pagproseso ng iyong aplikasyon para sa probation.
            
                                                            Salamat sa iyong pakikiisa at pang-unawa sa mga patakaran ng Laguna Parole and Probation Office."
                                                        </label>
                                                    </div>
                                                </div>
                                            <div class="d-grid gap-2 col-6 mx-auto">
                                                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                                            </div>
                                        </form>
                                    <?php else : ?>
                                        <div class="d-grid gap-2 col-6 mx-auto">
                                            <button class="btn btn-primary disabled" disabled>Submit</button>
                                        </div>
                                    <?php endif; ?>
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