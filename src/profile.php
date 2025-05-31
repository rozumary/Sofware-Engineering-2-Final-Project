<?php
include __DIR__ . '/functions.php';
set_config_inc(); // Include database connection

show_header();
display_navbar();
display_sidebar();

require(MYSQL);

$userId = $_SESSION['user_id'];
$userLevel = $_SESSION['user_level'];

// Get user information from the database
$sql = "SELECT * FROM users WHERE user_id = $userId";
$result = $dbc->query($sql);

if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
} else {
    echo "No user found";
}

?>

<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Profile </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $userLevel == 1 ? 'admin_dashboard.php' : 'user_dashboard.php'; ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Personal Information</h5>

                                <ul>
                                    <li class="text-dark"><strong>Name:</strong> <?= ucwords($userData['first_name'] . ' ' . $userData['middle_name'] . ' ' . $userData['last_name'] . ' ' . $userData['suffix']) ?></li>
                                    <li class="text-dark"><strong>Email:</strong> <?= $userData['email'] ?></li>
                                    <li class="text-dark"><strong>Mobile:</strong> <?= $userData['mobile_number'] ?></li>
                                    <!-- Add more user information as needed -->
                                </ul>
                                <div class="d-grid gap-2 d-md-block col-md-2">
                                    <a href="edit_profile_v02.php?id=<?= $userId ?>" class="btn btn-primary">Edit Profile</a>
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