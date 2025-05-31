<?php

include __DIR__ . '/functions.php';

show_header();
display_navbar();
display_sidebar();
set_config_inc();

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
                    <li class="breadcrumb-item">Account Management</li>
                    <li class="breadcrumb-item active" aria-current="page">Probationers List</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">List Of Probationers</h5>


                                <div class="table-responsive-lg table-responsive-md table-responsive-sm">
                                    <table class="table table-hover table-bordered">
                                        <thead class="table-dark">
                                            <tr>
                                                <th scope="col" class="text-nowrap">Probationer ID</th>
                                                <th scope="col" class="text-nowrap">Name</th>
                                                <th scope="col" class="text-nowrap">Alias</th>
                                                <th scope="col" class="text-nowrap">Municipality</th>
                                                <th scope="col" class="text-nowrap">Case No.</th>
                                                <th scope="col" class="text-nowrap">Status</th>
                                                <th scope="col" class="text-nowrap">Action</th>
                                                <!-- Add more columns as needed -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Fetch data from clients where status is 'grant'
                                            $query = "SELECT * FROM clients WHERE status = 'grant'";
                                            $result = mysqli_query($dbc, $query);

                                            while ($row = mysqli_fetch_assoc($result)) :
                                            ?>
                                                <tr>
                                                    <td><?= $row['id'] ?></td>
                                                    <td><?= ucfirst($row['first_name']) . ' ' . ucfirst($row['middle_name']) . ' ' . ucfirst($row['last_name']) . ' ' . ucfirst($row['suffix']) ?></td>
                                                    <td><?= ucfirst($row['alias']) ?></td>
                                                    <td><?= ucfirst($row['municipality']) ?></td>
                                                    <td><?= ucfirst($row['case_number']) ?></td>
                                                    <td><label class="badge badge-success"><?= ($row['status']) ?></label></td>
                                                    <td>
                                                        <div class='dropdown'>
                                                            <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action </button>
                                                            <div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuButton1'>
                                                                <h6 class='dropdown-header'>Options</h6>
                                                                <a class='dropdown-item text-dark' href='view_details.php?id=<?= $row['id'] ?>'>View Details</a>
                                                                <div class='dropdown-divider'></div>
                                                                <a class='dropdown-item text-success' href='grant.php?id=<?= $row['id'] ?>'>Termination of probation</a>
                                                                <div class='dropdown-divider'></div>
                                                                <a class='dropdown-item text-danger' href='#'>Revoke</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <!-- Add more columns as needed -->
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
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