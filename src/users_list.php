<?php

include 'functions.php';
require 'includes/config.inc.php'; // Include your database connection

include './inc/header.php';
include './inc/navbar.php';
include './inc/sidebar.php';


require(MYSQL);

$userLevel = $_SESSION['user_level'];
$email = $_SESSION['email'];
$role = $_SESSION['role'];

// Number of records to show per page:
$display = 7;

// Determine how many pages there are...
if (isset($_GET['p']) && is_numeric($_GET['p'])): // Already been determined.
    $pages = $_GET['p'];
else: // Need to determine.
    // Count the number of records:
    if ($userLevel == 1 && $role == 'admin'):
        $q = "SELECT COUNT(user_id) FROM users WHERE user_level = 0";
    else:
        $q = "SELECT COUNT(user_id) FROM users";
    endif;

    $r = @mysqli_query($dbc, $q);
    $row = @mysqli_fetch_array($r, MYSQLI_NUM);
    $records = $row[0];
    // Calculate the number of pages...
    if ($records > $display): // More than 1 page.
        $pages = ceil($records / $display);
    else:
        $pages = 1;
    endif;
endif; // End of p IF.

// Determine where in the database to start returning results...
if (isset($_GET['s']) && is_numeric($_GET['s'])):
    $start = $_GET['s'];
else:
    $start = 0;
endif;

// Determine the sort...
// Default is by registration date.
$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'dr';

// Determine the sorting order:
switch ($sort):
    case 'name':
        $order_by = 'first_name ASC';
        break;
    case 'dr':
        $order_by = 'registration_date ASC';
        break;
    default:
        $order_by = 'registration_date ASC';
        $sort = 'dr';
        break;
endswitch;

if ($userLevel == 1 && $role == 'admin'):
    $query = "SELECT *, DATE_FORMAT(registration_date, '%b. %d, %Y') AS dr FROM users WHERE user_level = 0 ORDER BY $order_by LIMIT $start, $display";
else:
    $query = "SELECT *, DATE_FORMAT(registration_date, '%b. %d, %Y') AS dr FROM users ORDER BY $order_by LIMIT $start, $display";
endif;
$result = mysqli_query($dbc, $query);

?>

<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Users List </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href=<?php echo $userLevel == 1 ? 'admin_dashboard.php' : 'user_dashboard.php'; ?>>Dashboard</a></li>
                    <li class="breadcrumb-item">Account Management</li>
                    <li class="breadcrumb-item active" aria-current="page">Users List</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Users Information</h5>

                                <?php if ($userLevel == 1 && $role == 'superadmin'): ?>
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <a href="add_admin.php" class="btn btn-warning btn-fw text-dark">
                                                <i class="mdi mdi-account-plus ms-1"></i>
                                                Add Admin
                                            </a>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="table-responsive-lg table-responsive-md table-responsive-sm">
                                    <table class="table table-hover table-bordered">
                                        <thead class="table-dark">
                                            <tr>
                                                <th scope="col" class="text-center"> User ID </th>
                                                <th scope="col" class="text-center"> Name<a
                                                        href="users_list.php?sort=name"><i
                                                            class="mdi mdi-sort-alphabetical"></i></a> </th>
                                                <th scope="col" class="text-center"> Email </th>
                                                <th scope="col" class="text-center"> Mobile Number </th>
                                                <!-- <th scope="col" class="text-nowrap">Verified</th> -->
                                                <?php if ($userLevel == 1 && $role == 'superadmin'): ?>
                                                    <th scope="col" class="text-center">Role</th>
                                                <?php endif; ?>
                                                <th scope="col" class="text-center">Registration Date<a
                                                        href="users_list.php?=sort=rd"><i class="mdi mdi-sort"></i></a>
                                                </th>
                                                <!-- <th scope="col" class="text-nowrap">Action</th> -->

                                            </tr>
                                        </thead>
                                        <tbody class="table-group-divider">
                                            <?php
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<tr>";
                                                echo "<td class='text-center'>{$row['user_id']}</td>";
                                                echo '<td>' . ucfirst($row['first_name']) . ' ' . ucfirst($row['middle_name']) . ' ' . ucfirst($row['last_name']) . ' ' . ucfirst($row['suffix']) . '</td>';
                                                echo "<td>{$row['email']}</td>";
                                                echo "<td class='text-center'>{$row['mobile_number']}</td>";
                                                // Display check mark if verified
                                                // echo "<td>";
                                                // if ($row['verified'] == 1) {
                                                //     echo '<span class="text-success">&#10003;</span>'; // Check mark
                                                // } else {
                                                //     echo '<span class="text-danger">&#10006;</span>'; // X mark
                                                // }
                                                // echo "</td>";
                                                // echo "<td>{$row['registration_date']}</td>";
                                                if ($userLevel == 1 && $role == 'superadmin'):
                                                    echo "<td class='text-center'><label class='badge badge-success'>{$row['role']}</label></td>";
                                                endif;

                                                echo "<td class='text-center'>{$row['dr']}</td>";
                                                //echo "<td><a href='verify_user.php?id={$row['user_id']}' class='btn btn-primary'>Verify</a></td>";
                                            
                                                // echo "<td>
                                                //     <div class='dropdown'>
                                                //         <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action </button>
                                                //         <div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuButton1'>
                                                //             <h6 class='dropdown-header'>Options</h6>
                                                //             <a class='dropdown-item text-dark' href='#'>Block User</a>
                                                //         </div>
                                            
                                                //     </td>";
                                            
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>

                                </div><br><br>

                                <!-- this is for pagination -->
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        <?php
                                        // Make the links to other pages, if necessary.
                                        if ($pages > 1):
                                            $current_page = ($start / $display) + 1;

                                            // If it's not the first page, make a Previous button:
                                            if ($current_page != 1):
                                                ?>
                                                <li class="page-item"><a class="page-link"
                                                        href="users_list.php?s=<?= ($start - $display) ?>&p=<?= $pages ?>&sort=<?= $sort ?>">Previous</a>
                                                </li>
                                            <?php endif; ?>

                                            <!-- Make all the numbered pages: -->
                                            <?php for ($i = 1; $i <= $pages; $i++): ?>
                                                <li class="page-item <?= ($i == $current_page) ? 'active" aria-current="page">' : '">' ?>
                                                            <a class=" page-link"
                                                    href="users_list.php?s=<?= (($display * ($i - 1))) ?>&p=<?= $pages ?>&sort=<?= $sort ?>">
                                                    <?= $i ?></a>
                                                </li>
                                            <?php endfor; ?>

                                            <!-- If it's not the last page, make a Next button: -->
                                            <?php if ($current_page != $pages): ?>
                                                <li class="page-item"><a class="page-link"
                                                        href="users_list.php?s=<?= ($start + $display) ?>&p=<?= $pages ?>&sort=<?= $sort ?>">Next</a>
                                                </li>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- content-wrapper ends -->

    <?php
    include './inc/footer.php';
    mysqli_close($dbc); // Close the database connection
    ?>