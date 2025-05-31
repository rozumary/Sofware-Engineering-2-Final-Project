<?php

include __DIR__ . '/functions.php';


show_header();
display_navbar();
display_sidebar();
set_config_inc();

require(MYSQL);

$userLevel = $_SESSION['user_level'];
$email = $_SESSION['email'];

if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) {
    $id = $_GET['id'];
} else {
    echo '<p class="text-danger">This page has been accessed in error.</p>';
    exit();
}

handleFileUpload('file_birth_cert', 'birth_certificate', $id, $email);
handleFileUpload('file_valid_id', 'valid_id', $id, $email);

// Check if the submit button is pressed
if (isset($_POST['submit'])) {
    // Update the client's status to 'pending'
    $updateStatusQuery = "UPDATE clients SET status = 'pending' WHERE id = ?";
    $updateStatusStmt = $dbc->prepare($updateStatusQuery);
    $updateStatusStmt->bind_param("i", $id);
    $updateStatusStmt->execute();
    $updateStatusStmt->close();

    succesMsg("Client status updated to 'pending'");
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
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Petitioners Requirements</h5>
                                <hr />

                                <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="height: 20px">
                                    <div class=" progress-bar bg-success" style="width: 7.69%">7.9%</div>
                                </div>
                            <div class="table-responsive-md">
                                <table class="table table-borderless table-hover">
                                    <thead>
                                        <tr>
                                            <th class="col-md-2">
                                                <h6>Requirements Name</h6>
                                            </th>
                                            <th class="col-md-5">
                                                <h6>Uploaded file</h6>
                                            </th>
                                            <th class="col-md-2">
                                                <h6>Status</h6>
                                            </th>
                                            <th class="col-md-3">
                                                <h6>Actions</h6>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <!-- Birth Certificate Form -->
                                        <tr>
                                            <td>
                                                <details>
                                                    <summary>Birth Certificate/</summary>
                                                    <p>Marriage Certificate/Certificate sa <br> Binyag/School Records (clear scanned/image)</p>
                                                </details>
                                            </td>

                                            <td>
                                                <?php
                                                $requirement_name = 'birth_certificate';

                                                // Check if a file with the same requirement name exists
                                                $checkFileQuery = "SELECT file_name, status FROM client_requirements WHERE client_id = ? AND requirement_name = ?";
                                                $checkFileStmt = $dbc->prepare($checkFileQuery);
                                                $checkFileStmt->bind_param("is", $id, $requirement_name);
                                                $checkFileStmt->execute();
                                                $checkFileStmt->store_result();

                                                if ($checkFileStmt->num_rows > 0) {
                                                    // File exists, display the file name
                                                    $checkFileStmt->bind_result($fileName, $file_status);
                                                    $checkFileStmt->fetch();
                                                    echo "File: $fileName";
                                                } else {
                                                    // File does not exist, show the upload form
                                                ?>
                                                    <form action="upload_requirements_v03.php?id=<?= $id ?>" method="post" enctype="multipart/form-data">
                                                        <label for="file_birth_cert">Birth Certificate:</label>
                                                        <div class="input-group">
                                                            <input type="file" id="file_birth_cert" name="file_birth_cert" class="form-control">
                                                            <button type="submit" class="btn btn-primary btn-icon-text">
                                                                <i class="mdi mdi-upload btn-icon-prepend"></i> Upload
                                                            </button>
                                                        </div>
                                                    </form>
                                                <?php
                                                }

                                                $checkFileStmt->close();
                                                ?>

                                            </td>

                                            <?php if (isset($file_status) && $file_status == 'pending') : ?>
                                                <td><label class="badge badge-warning"><?= $file_status ?></label></td>
                                            <?php elseif (isset($file_status) && $file_status == 'valid') : ?>
                                                <td><label class="badge badge-success"><?= $file_status ?></label></td>
                                            <?php elseif (isset($file_status) && $file_status == 'invalid') : ?>
                                                <td><label class="badge badge-danger"><?= $file_status ?></label></td>
                                            <?php else : ?>
                                                <td><label class="badge badge-dark">No file</label></td>
                                            <?php endif; ?>

                                            <td>
                                                <div class='dropdown'>
                                                    <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action </button>
                                                    <div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuButton1'>
                                                        <h6 class='dropdown-header'>Options</h6>
                                                        <!-- <a class='dropdown-item' href='view_image.php?id=<?= $id ?>'>View Image</a> -->
                                                        <a class='dropdown-item text-dark' href='#' onclick='showImage("<?php echo $fileName; ?>", "birth_certificate")'>View Image</a>
                                                        <div class='dropdown-divider'></div>
                                                        <a class='dropdown-item text-dark' href='download_file.php?file=<?= $fileName ?>' target='_blank'>Download</a>
                                                        <div class='dropdown-divider'></div>
                                                        <!-- <a class='dropdown-item text-danger' href='delete_image.php?id=<?= $id ?>&requirement_name=<?= $requirement_name ?>'>Delete Image</a> -->
                                                        <a class='dropdown-item text-danger' href='javascript:;' onclick="Swal.fire({title: 'Are you sure?', text: 'This will permanently delete the birth certificate file. Do you want to proceed?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Yes, delete it!', cancelButtonText: 'No, cancel'}).then((result) => {if (result.isConfirmed) {window.location.href = 'delete_image.php?id=<?= $id ?>&requirement_name=<?= $requirement_name ?>';}})">Delete Image</a>
                                                    </div>
                                            </td>
                                        </tr>


                                        <!-- Valid ID Form -->
                                        <tr>
                                            <td>
                                                <details>
                                                    <summary>Valid ID/</summary>
                                                    <p>Marriage Certificate/Certificate sa <br> Binyag/School Records (clear scanned/image)</p>
                                                </details>
                                            </td>

                                            <td>
                                                <?php
                                                $requirement_name = 'valid_id';

                                                // Check if a file with the same requirement name exists
                                                $checkFileQuery = "SELECT file_name, status FROM client_requirements WHERE client_id = ? AND requirement_name = ?";
                                                $checkFileStmt = $dbc->prepare($checkFileQuery);
                                                $checkFileStmt->bind_param("is", $id, $requirement_name);
                                                $checkFileStmt->execute();
                                                $checkFileStmt->store_result();

                                                if ($checkFileStmt->num_rows > 0) {
                                                    // File exists, display the file name
                                                    $checkFileStmt->bind_result($fileName_valid_id, $valid_id_status);
                                                    $checkFileStmt->fetch();
                                                    echo "File: $fileName_valid_id";
                                                } else {
                                                    // File does not exist, show the upload form
                                                ?>
                                                    <form action="upload_requirements_v03.php?id=<?= $id ?>" method="post" enctype="multipart/form-data">
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
                                                <td><label class="badge badge-warning"><?= $valid_id_status ?></label></td>
                                            <?php elseif (isset($valid_id_status) && $valid_id_status == 'valid') : ?>
                                                <td><label class="badge badge-success"><?= $valid_id_status ?></label></td>
                                            <?php elseif (isset($valid_id_status) && $valid_id_status == 'invalid') : ?>
                                                <td><label class="badge badge-danger"><?= $valid_id_status ?></label></td>
                                            <?php else : ?>
                                                <td><label class="badge badge-dark">No file</label></td>
                                            <?php endif; ?>

                                            <td>
                                                <div class='dropdown'>
                                                    <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action </button>
                                                    <div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuButton1'>
                                                        <h6 class='dropdown-header'>Options</h6>
                                                        <!-- <a class='dropdown-item' href='view_image.php?id=<?= $id ?>'>View Image</a> -->
                                                        <a class='dropdown-item text-dark' href='#' onclick='showImage("<?php echo $fileName_valid_id; ?>", "valid_id")'>View Image</a>
                                                        <div class='dropdown-divider'></div>
                                                        <a class='dropdown-item text-dark' href='download_file_v02.php?file=<?= $fileName_valid_id ?>' target='_blank'>Download</a>
                                                        <div class='dropdown-divider'></div>
                                                        <!-- <a class='dropdown-item text-danger' href='delete_image.php?id=<?= $id ?>&requirement_name=<?= $requirement_name ?>'>Delete Image</a> -->
                                                        <a class='dropdown-item text-danger' href='javascript:;' onclick="Swal.fire({title: 'Are you sure?', text: 'This will permanently delete the birth certificate file. Do you want to proceed?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Yes, delete it!', cancelButtonText: 'No, cancel'}).then((result) => {if (result.isConfirmed) {window.location.href = 'delete_image.php?id=<?= $id ?>&requirement_name=<?= $requirement_name ?>';}})">Delete Image</a>
                                                    </div>
                                            </td>
                                        </tr>




                                    </tbody>
                                </table>

                                <?php
                                // Check if both birth certificate and valid ID files are uploaded
                                $birthCertUploaded = isset($file_status) && $file_status == 'pending';
                                $validIdUploaded = isset($valid_id_status) && $valid_id_status == 'pending';

                                // Check if both files are uploaded to enable the button
                                $enableButton = $birthCertUploaded && $validIdUploaded;
                                ?>

                                <?php if ($enableButton) : ?>
                                    <form method="post" action="upload_requirements_v03.php?id=<?= $id ?>">
                                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                                    </form>
                                <?php else : ?>
                                    <button class="btn btn-primary disabled" disabled>Submit</button>
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