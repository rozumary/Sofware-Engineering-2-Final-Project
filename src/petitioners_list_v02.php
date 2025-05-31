<?php

include __DIR__ . '/functions.php';
require __DIR__ . '/vendor/autoload.php';


show_header();
set_config_inc();

display_navbar();
display_sidebar();


require(MYSQL);

$userLevel = $_SESSION['user_level'];

// Number of records to show per page:
$display = 7;

// Determine how many pages there are...
if (isset($_GET['p']) && is_numeric($_GET['p'])) : // Already been determined.
    $pages = $_GET['p'];
else : // Need to determine.
    // Count the number of records:
    $q = "SELECT COUNT(id) FROM clients WHERE status = 'pending' OR status IS NULL";
    // $q = "SELECT COUNT(id) FROM clientS WHERE status = 'pending'";
    $r = @mysqli_query($dbc, $q);
    $row = @mysqli_fetch_array($r, MYSQLI_NUM);
    $records = $row[0];
    // Calculate the number of pages...
    if ($records > $display) : // More than 1 page.
        $pages = ceil($records / $display);
    else :
        $pages = 1;
    endif;
endif; // End of p IF.

// Determine where in the database to start returning results...
if (isset($_GET['s']) && is_numeric($_GET['s'])) :
    $start = $_GET['s'];
else :
    $start = 0;
endif;

// Determine the sort...
// Default is by registration date.
$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'rd';

// Determine the sorting order:
switch ($sort):
    case 'name':
        $order_by = 'first_name ASC';
        break;
    case 'alias':
        $order_by = 'alias ASC';
        break;
    case 'rd':
        $order_by = 'registration_date ASC';
        break;
    default:
        $order_by = 'registration_date ASC';
        $sort = 'rd';
        break;
endswitch;

$query = "SELECT *, DATE_FORMAT(registration_date, '%b. %d, %Y') AS dr, id FROM clients WHERE status IN ('pending') OR status IS NULL ORDER BY $order_by LIMIT $start, $display";
$result = mysqli_query($dbc, $query);



?>

<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Petitioners List</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href=<?php echo $userLevel == 1 ? 'admin_dashboard.php' : 'user_dashboard.php'; ?>>Dashboard</a></li>
                    <li class="breadcrumb-item">Account Management</li>
                    <li class="breadcrumb-item active" aria-current="page">Petitioners List</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">List of Petitioners</h5>

                                <div class="row mb-4">
                                    <div class="col-md-2">
                                        <a href="add_petitioner.php" class="btn btn-fw form-control" style="background-color: #ffc107; color: #212529;">
                                            <i class="mdi mdi-account-plus ms-1"></i>
                                            Add Petitioner
                                        </a>
                                    </div>
                                    <div class="col-md-8">
                                        <!-- Empty column for spacing -->
                                    </div>
                                    <div class="col-md-2">
                                        <form action="export_pdf.php" method="post">
                                            <button type="submit" name="export_pdf" class="btn btn-danger form-control">
                                                <i class="mdi mdi-file-pdf"></i>
                                                Export PDF
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Display search results here -->
                                <div id="searchResults"></div>
                                <div class="table-responsive-lg">
                                    <table class="table table-hover table-bordered">
                                        <thead class="table-dark">
                                            <tr>
                                                <th scope="col" class="text-center">Petitioner ID</th>
                                                <th scope="col" class="text-center">Name<a href="petitioners_list_v02.php?sort=name"><i class="mdi mdi-sort-alphabetical"></i></a></th>
                                                <th scope="col" class="text-center">Alias<a href="petitioners_list_v02.php?sort=alias"><i class="mdi mdi-sort"></i></a></th>
                                                <!-- <th scope="col">Mobile Number</th> -->
                                                <th scope="col" class="text-center">Municipality</th>
                                                <th scope="col" class="text-center">Date Added<a href="petitioners_list_v02.php?sort=rd"><i class="mdi mdi-sort"></i></a></th>
                                                <th scope="col" class="text-center">Status</th>
                                                <th scope="col" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                                <tr>
                                                    <td class="text-center"><?= $row['id'] ?></td>
                                                    <td><?= ucfirst($row['first_name']) . ' ' . ucfirst($row['middle_name']) . ' ' . ucfirst($row['last_name']) . ' ' . ucfirst($row['suffix']) ?></td>
                                                    <td><?= ucfirst($row['alias']) ?></td>
                                                    <td><?= $row['municipality'] ?></td>
                                                    <td class="text-center"><?= $row['dr'] ?></td>
                                                    <?php if ($row['status'] == 'pending') : ?>
                                                        <td class="text-center"><label class='badge badge-warning'><?= $row['status'] ?></label></td>
                                                    <?php else : ?>
                                                        <td class="text-center"><label class='badge badge-warning'>pending</label></td>
                                                    <?php endif; ?>
                                                    <td>
                                                        <div class='dropdown'>
                                                            <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action </button>
                                                            <div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuButton1'>
                                                                <h6 class='dropdown-header'>Options</h6>
                                                                <a class='dropdown-item text-dark' href='view_details.php?id=<?= $row['id'] ?>'>View Details</a>
                                                                <div class='dropdown-divider'></div>
                                                                <a class="dropdown-item text-info" href="edit_petitioner.php?id=<?= $row['id'] ?>">Edit</a>
                                                                <div class="dropdown-divider"></div>
                                                                <?php
                                                                // Check client requirements status
                                                                $clientRequirementsStatus = getClientRequirementsStatus($row['id']);
                                                                if ($clientRequirementsStatus == 13) :
                                                                ?>
                                                                    <a class='dropdown-item text-success' href='grant.php?id=<?= $row['id'] ?>'>Grant</a>
                                                                <?php else : ?>
                                                                    <span class='dropdown-item text-danger'>
                                                                        Unverified
                                                                    </span>
                                                                <?php endif; ?>
                                                                <div class='dropdown-divider'></div>
                                                                <?php $file_check = get_file_count($row['id']);
                                                                if ($file_check > 0) : ?>
                                                                    <a class='dropdown-item text-danger' href='denied_clients.php?id=<?= $row['id'] ?>'>Denied</a>
                                                                <?php else : ?>
                                                                    <span class="dropdown-item text-danger">No upload files</span>
                                                                <?php endif; ?>
                                                            </div>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div><br>
                                <!-- this is for pagination -->
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        <?php
                                        // Make the links to other pages, if necessary.
                                        if ($pages > 1) :
                                            $current_page = ($start / $display) + 1;

                                            // If it's not the first page, make a Previous button:
                                            if ($current_page != 1) :
                                        ?>
                                                <li class="page-item"><a class="page-link" href="petitioners_list_v02.php?s=<?= ($start - $display) ?>&p=<?= $pages ?>&sort=<?= $sort ?>">Previous</a></li>
                                            <?php endif; ?>

                                            <!-- Make all the numbered pages: -->
                                            <?php for ($i = 1; $i <= $pages; $i++) : ?>
                                                <li class="page-item <?= ($i == $current_page) ? 'active" aria-current="page">' : '">' ?>
                                                    <a class=" page-link" href="petitioners_list_v02.php?s=<?= (($display * ($i - 1))) ?>&p=<?= $pages ?>&sort=<?= $sort ?>"><?= $i ?></a>
                                                </li>
                                            <?php endfor; ?>

                                            <!-- If it's not the last page, make a Next button: -->
                                            <?php if ($current_page != $pages) : ?>
                                                <li class="page-item"><a class="page-link" href="petitioners_list_v02.php?s=<?= ($start + $display) ?>&p=<?= $pages ?>&sort=<?= $sort ?>">Next</a></li>
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





        <?php show_footer(); ?>