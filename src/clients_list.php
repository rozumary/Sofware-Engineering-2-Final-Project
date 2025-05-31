<?php

include __DIR__ . '/functions.php';

show_header();
set_config_inc();

display_navbar();
display_sidebar();

require(MYSQL);

$userLevel = $_SESSION['user_level'];
$email = $_SESSION['email'];
$role = $_SESSION['role'];


// Number of records to show per page:
$display = 7;

// Determine how many pages there are...
if (isset($_GET['p']) && is_numeric($_GET['p'])) : // Already been determined.
    $pages = $_GET['p'];
else : // Need to determine.
    // Count the number of records:
    $q = "SELECT COUNT(id) FROM clients";
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

$query = "SELECT *, DATE_FORMAT(registration_date, '%b. %d, %Y') AS dr, id FROM clients ORDER BY $order_by LIMIT $start, $display";
$result = mysqli_query($dbc, $query);

?>

<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Clients List</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href=<?php echo $userLevel == 1 ? 'admin_dashboard.php' : 'user_dashboard.php'; ?>>Dashboard</a></li>
                    <li class="breadcrumb-item">Account Management</li>
                    <li class="breadcrumb-item active" aria-current="page">Clients List</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">List of Clients</h5>
                                <blockquote class="blockquote blockquote-primary">
                                    <!-- <p class="lead text-dark">Color Coding Status: <span class="badge-danger">revoked</span>, <span class="badge-success">completed</span>, <span class="badge-warning">pending</span>, <span class="badge-info">denied</span>, <span class="badge-primary">grant</span></p> -->
                                    <!-- <p class="lead text-dark">Color Legend Status:</p>
                                    <p class="lead">
                                        <span class="lead badge-danger">Revoked</span>: This status indicates probationer has been revoked.
                                        <br>
                                        <span class="badge-success">Completed</span>: This status indicates probationer has completed the program.
                                        <br>
                                        <span class="badge-warning">Pending</span>: This status indicates petitioner is currently being processed.
                                        <br>
                                        <span class="badge-info">Denied</span>: This status indicates petitioner has been denied for probation program.
                                        <br>
                                        <span class="badge-primary">Grant</span>: This status indicates petitioner has been granted for probation program.
                                    </p> -->
                                    <p class="lead text-dark">Probation Status:</p>
                                    <span class="badge-danger">Revoked</span> Probation terminated.
                                    <span class="badge-success">Completed</span> Probation successfully finished.
                                    <span class="badge-warning">Pending</span> Application under review.
                                    <span class="badge-info">Denied</span> Probation request not approved.
                                    <span class="badge-primary">Grant</span> Probation request approved.
                                </blockquote>


                                <!-- Display search results here -->
                                <div id="searchResults"></div>
                                <div class="table-responsive-lg">
                                    <table class="table table-hover table-bordered">
                                        <thead class="table-dark">
                                            <tr>
                                                <th scope="col" class="text-center">Client No.</th>
                                                <th scope="col" class="text-center">Name<a href="clients_list.php?sort=name"><i class="mdi mdi-sort-alphabetical"></i></a></th>
                                                <th scope="col" class="text-center">Alias<a href="clients_list.php?sort=alias"><i class="mdi mdi-sort"></i></a></th>
                                                <!-- <th scope="col">Mobile Number</th> -->
                                                <th scope="col" class="text-center">Municipality</th>
                                                <th scope="col" class="text-center">Date Added<a href="clients_list.php?sort=rd"><i class="mdi mdi-sort"></i></a></th>
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
                                                    <?php elseif ($row['status'] == 'grant') : ?>
                                                        <td class="text-center"><label class="badge badge-primary"><?= $row['status'] ?></label></td>
                                                    <?php elseif ($row['status'] == 'denied') : ?>
                                                        <td class="text-center"><label class="badge badge-info"><?= $row['status'] ?></label></td>
                                                    <?php elseif ($row['status'] == 'completed') : ?>
                                                        <td class="text-center"><label class="badge badge-success"><?= $row['status'] ?></label></td>
                                                    <?php elseif ($row['status'] == 'revoked') : ?>
                                                        <td class="text-center"><label class="badge badge-danger"><?= $row['status'] ?></label></td>
                                                    <?php else : ?>
                                                        <td class="text-center"><label class='badge badge-warning'>pending</label></td>
                                                    <?php endif; ?>
                                                    <td>
                                                        <div class='dropdown'>
                                                            <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action </button>
                                                            <div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuButton1'>
                                                                <h6 class='dropdown-header'>Options</h6>
                                                                <a class='dropdown-item text-dark' href='view_details.php?id=<?= $row['id'] ?>'>View Details</a>

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
                                                <li class="page-item"><a class="page-link" href="clients_list.php?s=<?= ($start - $display) ?>&p=<?= $pages ?>&sort=<?= $sort ?>">Previous</a></li>
                                            <?php endif; ?>

                                            <!-- Make all the numbered pages: -->
                                            <?php for ($i = 1; $i <= $pages; $i++) : ?>
                                                <li class="page-item <?= ($i == $current_page) ? 'active" aria-current="page">' : '">' ?>
                                                    <a class=" page-link" href="clients_list.php?s=<?= (($display * ($i - 1))) ?>&p=<?= $pages ?>&sort=<?= $sort ?>"><?= $i ?></a>
                                                </li>
                                            <?php endfor; ?>

                                            <!-- If it's not the last page, make a Next button: -->
                                            <?php if ($current_page != $pages) : ?>
                                                <li class="page-item"><a class="page-link" href="clients_list.php?s=<?= ($start + $display) ?>&p=<?= $pages ?>&sort=<?= $sort ?>">Next</a></li>
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