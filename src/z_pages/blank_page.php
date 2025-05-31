<?php

include __DIR__ . '/functions.php';

show_header();
set_config_inc();
display_navbar();
display_sidebar();

require(MYSQL);

$userLevel = $_SESSION['user_level'];

?>

<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Dashboard</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href=<?php echo $userLevel == 1 ? 'admin_dashboard.php' : 'user_dashboard.php'; ?>>Dashboard</a></li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Search for Petitioner</h5>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->




    <?php show_footer(); ?>