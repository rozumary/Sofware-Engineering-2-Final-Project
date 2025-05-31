<?php
include __DIR__ . '/functions.php';

show_header();
display_navbar();
display_sidebar();

set_config_inc();


require(MYSQL);

$q = "SELECT * FROM users";
$r = $dbc->query($q);

$query = "SELECT * FROM users WHERE verified = 1";
$result = mysqli_query($dbc, $query);

$inactive = "SELECT * FROM users WHERE verified = 0";
$inactive_result = mysqli_query($dbc, $inactive);

$num_user = mysqli_num_rows($r); // number of users
$num_user_verified = mysqli_num_rows($result); // number of users verified
$num_user_inactive = mysqli_num_rows($inactive_result); // number of users inactive


?>



<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="d-xl-flex justify-content-between align-items-start">
            <h2 class="text-dark font-weight-bold mb-2"> Overview dashboard </h2>
            <div class="d-sm-flex justify-content-xl-between align-items-center mb-2">
                <div class="btn-group bg-white p-3" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-link text-gray py-0 border-right">Today</button>
                    <button type="button" class="btn btn-link text-gray py-0 border-right">7 Days</button>
                    <button type="button" class="btn btn-link text-dark py-0 border-right">1 Month</button>
                    <button type="button" class="btn btn-link text-gray py-0">1 Year</button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="d-sm-flex justify-content-between align-items-center transaparent-tab-border {">
                    <ul class="nav nav-tabs tab-transparent" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#users" role="tab" aria-selected="true">Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="application-tab" data-bs-toggle="tab" href="#application" role="tab" aria-selected="false">Probation Applications</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="performance-tab" data-bs-toggle="tab" href="#" role="tab" aria-selected="false">Performance</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="conversion-tab" data-bs-toggle="tab" href="#" role="tab" aria-selected="false">Conversion</a>
                        </li>
                    </ul>
                    <div class="d-md-block d-none">
                        <a href="#" class="text-light p-1"><i class="mdi mdi-view-dashboard"></i></a>
                        <a href="#" class="text-light p-1"><i class="mdi mdi-dots-vertical"></i></a>
                    </div>
                </div>
            


                <div class="tab-content tab-transparent-content">
                    <div class="tab-pane fade" id="application" role="tabpanel" aria-labelledby="application-tab">
                        <!-- <div class="tab-pane fade show active" id="business-1" role="tabpanel" aria-labelledby="business-tab"> -->
                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="mb-2 text-dark font-weight-normal">PROBATION SAMPPLE</h5>
                                        <h2 class="mb-4 text-dark font-weight-bold"><?= $num_user ?></h2>
                                        <div class="dashboard-progress dashboard-progress-1 d-flex align-items-center justify-content-center item-parent"><i class="mdi mdi-account-multiple-outline icon-md absolute-center text-dark"></i></div>
                                        <p class="mt-4 mb-0">Total</p>
                                        <h3 class="mb-0 font-weight-bold mt-2 text-dark"><?= $num_user ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="mb-2 text-dark font-weight-normal">Registered Users</h5>
                                        <h2 class="mb-4 text-dark font-weight-bold"><?= $num_user ?></h2>
                                        <div class="dashboard-progress dashboard-progress-2 d-flex align-items-center justify-content-center item-parent"><i class="mdi mdi-account-check icon-md absolute-center text-dark"></i></div>
                                        <p class="mt-4 mb-0">Verified</p>
                                        <h3 class="mb-0 font-weight-bold mt-2 text-dark"><?= $num_user_verified ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3  col-lg-6 col-sm-6 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="mb-2 text-dark font-weight-normal">Registered Users</h5>
                                        <h2 class="mb-4 text-dark font-weight-bold"><?= $num_user ?></h2>
                                        <div class="dashboard-progress dashboard-progress-3 d-flex align-items-center justify-content-center item-parent"><i class="mdi mdi-account-minus icon-md absolute-center text-dark"></i></div>
                                        <p class="mt-4 mb-0">Inactive</p>
                                        <h3 class="mb-0 font-weight-bold mt-2 text-dark"><?= $num_user_inactive ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="mb-2 text-dark font-weight-normal">Registered Users</h5>
                                        <h2 class="mb-4 text-dark font-weight-bold"><?= $num_user ?></h2>
                                        <div class="dashboard-progress dashboard-progress-4 d-flex align-items-center justify-content-center item-parent"><i class="mdi mdi-account-box icon-md absolute-center text-dark"></i></div>
                                        <p class="mt-4 mb-0">New Users</p>
                                        <h3 class="mb-0 font-weight-bold mt-2 text-dark">25%</h3>
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


    <?php include './inc/footer.php'; ?>