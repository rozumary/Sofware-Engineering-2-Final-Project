<?php
include __DIR__ . '/functions.php';

show_header();
display_navbar();
display_sidebar();

set_config_inc();
// require_once 'includes/config.inc.php';


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



$client_query = "SELECT COUNT(*) as client_count FROM clients"; // Count the number of clients
$client_result = $dbc->query($client_query);

// Fetch the result
$client_row = $client_result->fetch_assoc();
$client_count = $client_row['client_count'];


// Count the number of clients with status "Pending"
$pending_count_query = "SELECT COUNT(*) as pending_count FROM clients WHERE status = 'Pending'";
$pending_count_result = $dbc->query($pending_count_query);
$pending_row = $pending_count_result->fetch_assoc();
$pending_count = $pending_row['pending_count'];

// Count the number of clients with status "Granted And completion"
$granted_count_query = "SELECT COUNT(*) as granted_count FROM clients WHERE status = 'Grant' OR status = 'Completed' OR status = 'Revoked'";
$granted_count_result = $dbc->query($granted_count_query);
$granted_row = $granted_count_result->fetch_assoc();
$granted_count = $granted_row['granted_count'];

// Count the number of clients with status "Denied"
$denied_count_query = "SELECT COUNT(*) as denied_count FROM clients WHERE status = 'Denied'";
$denied_count_result = $dbc->query($denied_count_query);
$denied_row = $denied_count_result->fetch_assoc();
$denied_count = $denied_row['denied_count'];

//Count the number of clients with status "Completed"
$completed_count_query = "SELECT COUNT(*) as completed_count FROM clients WHERE status = 'Completed'";
$completed_count_result = $dbc->query($completed_count_query);
$completed_row = $completed_count_result->fetch_assoc();
$completed_count = $completed_row['completed_count'];

// Count the number of clients with status "Revoked"
$revoked_count_query = "SELECT COUNT(*) as revoked_count FROM clients WHERE status = 'Revoked'";
$revoked_count_result = $dbc->query($revoked_count_query);
$revoked_row = $revoked_count_result->fetch_assoc();
$revoked_count = $revoked_row['revoked_count'];

// Count for Ongoing
$grant_query = "SELECT COUNT(*) as grant_count FROM clients WHERE status = 'Grant'";
$grant_result = $dbc->query($grant_query);
$grant_row = $grant_result->fetch_assoc();
$grant_count = $grant_row['grant_count'];

?>



<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="d-xl-flex justify-content-between align-items-start">
            <h2 class="text-dark font-weight-bold mb-2"> Overview dashboard </h2>
            <div class="d-sm-flex justify-content-xl-between align-items-center mb-2">
                <!-- <div class="btn-group bg-white p-3" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-link text-gray py-0 border-right">Today</button>
                    <button type="button" class="btn btn-link text-gray py-0 border-right">7 Days</button>
                    <button type="button" class="btn btn-link text-dark py-0 border-right">1 Month</button>
                    <button type="button" class="btn btn-link text-gray py-0">1 Year</button>
                </div> -->
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
                            <a class="nav-link " id="application-tab" data-bs-toggle="tab" href="#petitioners" role="tab" aria-selected="false">Petitioners</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="performance-tab" data-bs-toggle="tab" href="#probationers" role="tab" aria-selected="false">Probationers</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" id="conversion-tab" data-bs-toggle="tab" href="#" role="tab" aria-selected="false">#</a>
                        </li> -->
                    </ul>
                    <!-- <div class="d-md-block d-none">
                        <a href="#" class="text-light p-1"><i class="mdi mdi-view-dashboard"></i></a>
                        <a href="#" class="text-light p-1"><i class="mdi mdi-dots-vertical"></i></a>
                    </div> -->
                </div>
                <div class="tab-content tab-transparent-content">
                    <div class="tab-pane fade show active" id="users" role="tabpanel" aria-labelledby="home-tab">
                        <!-- <div class="tab-pane fade show active" id="business-1" role="tabpanel" aria-labelledby="business-tab"> -->
                        <div class="row">
                            <div class="col-xl-4 col-lg-6 col-sm-6 grid-margin stretch-card">
                                <div class="card" style="background-color:rgb(194, 40, 40);">
                                    <div class="card-body text-center">
                                        <h5 class="mb-2 text-dark font-weight-normal">TOTAL</h5>
                                        <h2 class="mb-4 text-dark font-weight-bold"><?= $num_user ?></h2>
                                        <div class="dashboard-progress dashboard-progress-3 d-flex align-items-center justify-content-center item-parent"><i class="mdi mdi-account-multiple-outline icon-md absolute-center text-dark"></i></div>
                                        <br /><br /><br />
                                        <!-- <p class="mt-4 mb-0 text-dark">TOTAL</p>
                                        <h3 class="mb-0 font-weight-bold mt-2 text-dark"><?= $num_user ?></h3> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-sm-6 grid-margin stretch-card">
                                <div class="card" style="background-color:rgb(100, 97, 97);">
                                    <div class="card-body text-center">
                                        <h5 class="mb-2 text-dark font-weight-normal">VERIFIED</h5>
                                        <h2 class="mb-4 text-dark font-weight-bold"><?= $num_user_verified ?></h2>
                                        <div class="dashboard-progress dashboard-progress-2 d-flex align-items-center justify-content-center item-parent"><i class="mdi mdi-account-check icon-md absolute-center text-dark"></i></div>
                                        <!-- <p class="mt-4 mb-0 text-dark">VERIFIED</p>
                                        <h3 class="mb-0 font-weight-bold mt-2 text-dark"><?= $num_user_verified ?></h3> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4  col-lg-6 col-sm-6 grid-margin stretch-card">
                                <div class="card" style="background-color:rgb(77, 5, 0);">
                                    <div class="card-body text-center">
                                        <h5 class="mb-2 text-light font-weight-normal">INACTIVE</h5>
                                        <h2 class="mb-4 text-light font-weight-bold"><?= $num_user_inactive ?></h2>
                                        <div class="dashboard-progress dashboard-progress-4 d-flex align-items-center justify-content-center item-parent"><i class="mdi mdi-account-minus icon-md absolute-center text-light"></i></div>
                                        <!-- <p class="mt-4 mb-0 text-dark">INACTIVE</p>
                                        <h3 class="mb-0 font-weight-bold mt-2 text-dark"><?= $num_user_inactive ?></h3> -->
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="mb-2 text-dark font-weight-normal">Registered Users</h5>
                                        <h2 class="mb-4 text-dark font-weight-bold"><?= $num_user ?></h2>
                                        <div class="dashboard-progress dashboard-progress-4 d-flex align-items-center justify-content-center item-parent"><i class="mdi mdi-account-box icon-md absolute-center text-dark"></i></div>
                                        <p class="mt-4 mb-0">New Users</p>
                                        <h3 class="mb-0 font-weight-bold mt-2 text-dark">25%</h3>
                                    </div>
                                </div>
                            </div> -->
                        </div>

                        <div class="row">
                            <div class="col-sm-12  grid-margin stretch-card">
                                <div class="card">
                                    <div class="card" style="background-color:rgb(243, 224, 224);">
                                        <div class="d-xl-flex justify-content-between mb-2">
                                            <!-- <h4 class="card-title">Data analytics</h4> -->
                                            <div class="graph-custom-legend primary-dot" id="pageViewAnalyticLengend"></div>
                                            <div class="card-body"> <br />
                                                <!-- <h4 class="card-title">Pie chart</h4> -->
                                                <canvas id="myUsersBar" width="500" height="300"></canvas>
                                            </div>
                                        </div>
                                        <!-- <canvas id="page-view-analytic"></canvas> -->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade show" id="petitioners" role="tabpanel" aria-labelledby="application-tab">
                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                                 <div class="card" style="background-color:rgb(194, 40, 40);">
                                    <div class="card-body text-center">
                                        <h5 class="mb-2 text-dark font-weight-normal">TOTAL</h5>
                                        <h2 class="mb-4 text-dark font-weight-bold"><?= $client_count ?></h2>
                                        <div class="dashboard-progress dashboard-progress-3 d-flex align-items-center justify-content-center item-parent"><i class="mdi mdi-account-box icon-md absolute-center text-dark"></i></div>
                                        <br /><br /><br />
                                        <!-- <p class="mt-4 mb-0 text-dark">TOTAL</p>
                                        <h3 class="mb-0 font-weight-bold mt-2 text-dark"><?= $client_count ?></h3> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                                <div class="card" style="background-color:rgb(100, 97, 97);">
                                    <div class="card-body text-center">
                                        <h5 class="mb-2 text-dark font-weight-normal">PENDING</h5>
                                        <h2 class="mb-4 text-dark font-weight-bold"><?= $pending_count ?></h2>
                                        <div class="dashboard-progress dashboard-progress-2 d-flex align-items-center justify-content-center item-parent"><i class="mdi mdi-account-box icon-md absolute-center text-dark"></i></div>
                                        <!-- <p class="mt-4 mb-0 text-dark">PENDING</p>
                                        <h3 class="mb-0 font-weight-bold mt-2 text-dark"><?= $pending_count ?></h3> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                                <div class="card" style="background-color:rgb(77, 5, 0)">
                                    <div class="card-body text-center">
                                        <h5 class="mb-2 text-light font-weight-normal">GRANTED</h5>
                                        <h2 class="mb-4 text-light font-weight-bold"><?= $granted_count ?></h2>
                                        <div class="dashboard-progress dashboard-progress-4 d-flex align-items-center justify-content-center item-parent"><i class="mdi mdi-account-box icon-md absolute-center text-light"></i></div>
                                        <!-- <p class="mt-4 mb-0 text-dark">GRANTED</p>
                                        <h3 class="mb-0 font-weight-bold mt-2 text-dark"><?= $granted_count ?></h3> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                                <div class="card" style="background-color:rgb(228, 212, 212);">
                                    <div class="card-body text-center">
                                        <h5 class="mb-2 text-dark font-weight-normal">DENIED</h5>
                                        <h2 class="mb-4 text-dark font-weight-bold"><?= $denied_count ?></h2>
                                        <div class="dashboard-progress dashboard-progress-2 d-flex align-items-center justify-content-center item-parent"><i class="mdi mdi-account-box icon-md absolute-center text-dark"></i></div>
                                        <!-- <p class="mt-4 mb-0 text-dark">DENIED</p>
                                        <h3 class="mb-0 font-weight-bold mt-2 text-dark"><?= $denied_count ?></h3> -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12  grid-margin stretch-card">
                                <div class="card">
                                    <div class="card" style="background-color:rgb(228, 212, 212);">
                                        <div class="d-xl-flex justify-content-between mb-2">
                                            <!-- <h4 class="card-title">Data analytics</h4> -->
                                            <div class="graph-custom-legend primary-dot" id="pageViewAnalyticLengend"></div>
                                            <div class="card-body"><br />
                                                <!-- <h4 class="card-title">Bar Chart</h4> -->
                                                <canvas id="petitionersChart" width="500" height="300"></canvas>
                                            </div>
                                        </div>
                                        <!-- <canvas id="page-view-analytic"></canvas> -->

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane fade show" id="probationers" role="tabpanel" aria-labelledby="performance-tab">
                        <!-- <div class="tab-pane fade show active" id="business-1" role="tabpanel" aria-labelledby="business-tab"> -->
                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                                <div class="card" style="background-color:rgb(194, 40, 40);">
                                    <div class="card-body text-center">
                                        <h5 class="mb-2 text-dark font-weight-normal">TOTAL</h5>
                                        <h2 class="mb-4 text-dark font-weight-bold"><?= $granted_count ?></h2>
                                        <div class="dashboard-progress dashboard-progress-3 d-flex align-items-center justify-content-center item-parent"><i class="mdi mdi-account-multiple-outline icon-md absolute-center text-dark"></i></div>
                                        <br /><br /><br />
                                        <!-- <p class="mt-4 mb-0 text-dark">TOTAL</p>
                                        <h3 class="mb-0 font-weight-bold mt-2 text-dark"><?= $granted_count ?></h3> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                                <div class="card" style="background-color:rgb(100, 97, 97);">
                                    <div class="card-body text-center">
                                        <h5 class="mb-2 text-dark font-weight-normal">ONGOING</h5>
                                        <h2 class="mb-4 text-dark font-weight-bold"><?= $grant_count ?></h2>
                                        <div class="dashboard-progress dashboard-progress-2 d-flex align-items-center justify-content-center item-parent"><i class="mdi mdi-account-box icon-md absolute-center text-dark"></i></div>
                                        <!-- <p class="mt-4 mb-0 text-dark">Ongoing</p>
                                        <h3 class="mb-0 font-weight-bold mt-2 text-dark"><?= $grant_count ?></h3> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                                <div class="card" style="background-color:rgb(77, 5, 0)">
                                    <div class="card-body text-center">
                                        <h5 class="mb-2 text-light font-weight-normal">COMPLETED</h5>
                                        <h2 class="mb-4 text-light font-weight-bold"><?= $completed_count ?></h2>
                                        <div class="dashboard-progress dashboard-progress-4 d-flex align-items-center justify-content-center item-parent"><i class="mdi mdi-account-check icon-md absolute-center text-light"></i></div>
                                        <!-- <p class="mt-4 mb-0 text-dark">COMPLETED</p>
                                        <h3 class="mb-0 font-weight-bold mt-2 text-dark"><?= $completed_count ?></h3> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3  col-lg-6 col-sm-6 grid-margin stretch-card">
                                <div class="card" style="background-color:rgb(228, 212, 212);">
                                    <div class="card-body text-center">
                                        <h5 class="mb-2 text-dark font-weight-normal">REVOKED</h5>
                                        <h2 class="mb-4 text-dark font-weight-bold"><?= $revoked_count ?></h2>
                                        <div class="dashboard-progress dashboard-progress-2 d-flex align-items-center justify-content-center item-parent"><i class="mdi mdi-account-minus icon-md absolute-center text-dark"></i></div>
                                        <!-- <p class="mt-4 mb-0 text-dark">REVOKED</p>
                                        <h3 class="mb-0 font-weight-bold mt-2 text-dark"><?= $revoked_count ?></h3> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12  grid-margin stretch-card">
                                <div class="card">
                                    <div class="card" style="background-color:rgb(228, 212, 212);">
                                        <div class="d-xl-flex justify-content-between mb-2">
                                            <!-- <h4 class="card-title">Data analytics</h4> -->
                                            <div class="graph-custom-legend primary-dot" id="pageViewAnalyticLengend"></div>
                                            <div class="card-body"> <br />
                                                <!-- <h4 class="card-title">Doughnut Chart</h4> -->
                                                <div class="container-fluid">
                                                    <canvas id="probationersChart" width="500" height="300"></canvas>
                                                </div>
                                            </div>
                                        </div>

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