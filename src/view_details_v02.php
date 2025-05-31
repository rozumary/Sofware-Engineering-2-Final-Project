<?php

include __DIR__ . '/functions.php';
include __DIR__ . '/helpers/upload_image.php';

show_header();
display_navbar();
display_sidebar();
set_config_inc();

require(MYSQL);

$userLevel = $_SESSION['user_level'];
$userEmail = $_SESSION['email'];

// Ensure that the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
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


        // Check the status in the clients table to determine if the user has already done for requirements
        $clientQuery = "SELECT * FROM clients WHERE id = $id";
        $clientResult = mysqli_query($dbc, $clientQuery);

        $hasAppliedForProbation = false;
        if ($clientResult && mysqli_num_rows($clientResult) > 0) {
            $clientRow = mysqli_fetch_assoc($clientResult);
            if ($clientRow['status'] == 'approved') {
                $hasAppliedForProbation = true;
            }
        }


        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
            // Ensure that $case_number and $user_email are available
            $case_number = $row['case_number']; // Assuming $row is accessible here
            $user_email = $_SESSION['email'];
        
            $uploadResult = uploadImage($dbc, 'file_birth_cert', $case_number, $user_email, ['jpg', 'jpeg', 'png', 'gif']);
        
            if (isset($uploadResult['success'])) {
                echo "<p class='text-success'>" . $uploadResult['success'] . "</p>";
            } else {
                echo "<p class='text-danger'>" . $uploadResult['error'] . "</p>";
            }
        }

    } else {
        echo "No details found for the selected ID.";
    }
} else {
    echo "Invalid request. Please provide a valid ID.";
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
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Details for <?= $fn ?></h5>
                                <hr />

                                <div class="container">
                                    <div class="row justify-content-start">
                                        <div class="col">
                                            <h4>Personal Information</h4>
                                            <ul class="list-arrow">
                                                <li class="lead">First Name: <?php echo ucfirst($fn) ?></li>
                                                <li class="lead">M.I.: <?php echo ucfirst($mn) ?></li>
                                                <li class="lead">Last Name: <?php echo ucfirst($ln) ?></li>
                                                <li class="lead">Suffix: <?php echo ucfirst($suffix) ?></li>
                                                <li class="lead">Alias: <?php echo ucfirst($alias) ?></li>
                                            </ul>
                                        </div>
                                        <div class="col">
                                            <h4>Address</h4>
                                            <ul class="list-arrow">
                                                <li class="lead">Street: <?php echo ucfirst($street) ?></li>
                                                <li class="lead">Barangay: <?php echo ucfirst($barangay) ?></li>
                                                <li class="lead">Municipality: <?php echo ucfirst($municipality) ?></li>
                                            </ul>
                                        </div>
                                        <div class="col">
                                            <h4>Additional Info</h4>
                                            <ul class="list-arrow">
                                                <li class="lead">Gender: <?php echo ucfirst($gender) ?></li>
                                                <li class="lead">Date of Birth: <?php echo ucfirst($dob) ?></li>
                                                <li class="lead">Mobile No: <?php echo ucfirst($mobile) ?></li>
                                                <li class="lead">Email: <?php echo ucfirst($email) ?></li>
                                                <li class="lead">Case Number: <?php echo ucfirst($case_number) ?></li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Probation Application Status</h5>
                                        <hr />

                                        <?php if ($hasAppliedForProbation) : ?>
                                            <p>The user has applied for probation and the application is approved.</p>
                                        <?php else : ?>
                                            <div class="alert alert-warning d-flex align-items-center" role="warning">
                                                <span class="mdi mdi-information-outline"></span>
                                                This client has not yet done for the requirements, Please provide all the the requirements needed.
                                            </div>
                                            <!-- show the form: -->
                                            <div class="table-responsive">
                                                <table class="table table-borderless">
                                                    <thead>
                                                        <tr>
                                                            <th class="col-md-6">Requirements</th>
                                                            <th class="col-md-3">Status</th>
                                                            <th class="col-md-3">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <!-- Birth Certificate Form -->
                                                        <tr>
                                                            <td>
                                                                <form action="view_details_v02.php" method="post" enctype="multipart/form-data">
                                                                    <label for="file_birth_cert">Birth Certificate:</label>
                                                                    <div class="input-group">
                                                                        <input type="file" id="file_birth_cert" name="file_birth_cert" class="form-control" required>
                                                                        <button type="submit" class="btn btn-primary" name="submit">Upload</button>
                                                                    </div>
                                                                </form>
                                                            </td>
                                                            <td><!-- Status Placeholder (customize as needed) -->For Verification</td>
                                                            <td>
                                                                <div class='dropdown'>
                                                                    <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action </button>
                                                                    <div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuButton1'>
                                                                        <h6 class='dropdown-header'>Options</h6>
                                                                        <a class='dropdown-item' href='view_details.php?id=<?= $row['id'] ?>'>View Image</a>
                                                                        <a class='dropdown-item' href='#' onclick='verifyAllert(<?= $row['id'] ?>)'>Grant</a>
                                                                        <div class='dropdown-divider'></div>
                                                                        <a class='dropdown-item' href='#' onclick='rejectAllert(<?= $row['id'] ?>)'>Denied</a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        <!-- Valid ID Form -->
                                                        <!-- Repeat the following table row structure for each file upload section -->
                                                        <tr>
                                                            <td>
                                                                <form action="my_application_v04.php" method="post" enctype="multipart/form-data">
                                                                    <label for="file_valid_id">Valid ID:</label>
                                                                    <div class="input-group">
                                                                        <input type="file" id="file_valid_id" name="file_valid_id" class="form-control" required>
                                                                        <button type="submit" class="btn btn-primary">Upload</button>
                                                                    </div>
                                                                </form>
                                                            </td>
                                                            <td><!-- Status Placeholder (customize as needed) --></td>
                                                            <td>
                                                                <div class='dropdown'>
                                                                    <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action </button>
                                                                    <div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuButton1'>
                                                                        <h6 class='dropdown-header'>Options</h6>
                                                                        <a class='dropdown-item' href='view_details.php?id=<?= $row['id'] ?>'>View Image</a>
                                                                        <a class='dropdown-item' href='#' onclick='verifyAllert(<?= $row['id'] ?>)'>Grant</a>
                                                                        <div class='dropdown-divider'></div>
                                                                        <a class='dropdown-item' href='#' onclick='rejectAllert(<?= $row['id'] ?>)'>Denied</a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        <!-- Talambuhay Form -->
                                                        <!-- Add more table rows for additional file upload sections -->

                                                    </tbody>
                                                </table>
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
    </div>
    <!-- content-wrapper ends -->




    <?php show_footer(); ?>