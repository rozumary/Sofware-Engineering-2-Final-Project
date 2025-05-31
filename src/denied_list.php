<?php

include __DIR__ . '/functions.php';

show_header();
display_navbar();
display_sidebar();
set_config_inc();

require(MYSQL);


$userLevel = $_SESSION['user_level'];

// Number of records to show per page:
$display = 7;

// Determine how many pages there are...
if (isset($_GET['p']) && is_numeric($_GET['p'])): // Already been determined.
    $pages = $_GET['p'];
else: // Need to determine.
    // Count the number of records:
    $q = "SELECT COUNT(id) FROM clients WHERE status = 'denied'";
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
$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'dd';

// Determine the sorting order:
switch ($sort):
    case 'name':
        $order_by = 'first_name ASC';
        break;
    case 'alias':
        $order_by = 'alias ASC';
        break;
    case 'dd':
        $order_by = 'date_denied ASC';
        break;
    case 'reason':
        $order_by = 'reason ASC';
        break;
    default:
        $order_by = 'date_denied ASC';
        $sort = 'dd';
        break;
endswitch;


?>

<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Denied List</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href=<?php echo $userLevel == 1 ? 'admin_dashboard.php' : 'user_dashboard.php'; ?>>Dashboard</a></li>
                    <li class="breadcrumb-item">Account Management</li>
                    <li class="breadcrumb-item active" aria-current="page">Denied List</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">List Of Denied Petitioners</h5>


                                <div class="row mb-4">
                                    <div class="col-md-2">
                                    </div>
                                    <div class="col-md-8">
                                        <!-- Empty column for spacing -->
                                    </div>
                                    <div class="col-md-2">
                                        <form action="export_pdf.php" method="post">
                                            <button type="submit" name="denied_pdf" class="btn btn-danger form-control">
                                                <i class="mdi mdi-file-pdf"></i>
                                                Export PDF
                                            </button>
                                        </form>
                                    </div>
                                </div>



                                <div class="table-responsive-lg table-responsive-md table-responsive-sm">
                                    <table class="table table-hover table-bordered">
                                        <thead class="table-dark">
                                            <tr>
                                                <th scope="col" class="text-nowrap text-center">Petitioner No.</th>
                                                <th scope="col" class="text-nowrap">Name<a
                                                        href="denied_list.php?sort=name"><i
                                                            class="mdi mdi-sort-alphabetical"></i></a></th>
                                                <th scope="col" class="text-nowrap">Alias<a
                                                        href="denied_list.php?sort=alias"><i
                                                            class="mdi mdi-sort"></i></a></th>
                                                <th scope="col" class="text-nowrap">Municipality</th>
                                                <!-- <th scope="col">Case No.</th> -->
                                                <th scope="col" class="text-nowrap">Status</th>
                                                <th scope="col" class="text-nowrap text-center reason-column">Reason
                                                    <a href="denied_list.php?sort=reason"><i
                                                            class="mdi mdi-sort"></i></a>
                                                </th>
                                                <th scope="col" class="text-nowrap">Date Denied<a
                                                        href="denied_list.php?=sort=dd"><i class="mdi mdi-sort"></i></a>
                                                </th>
                                                <th scope="col" class="text-nowrap text-center">Action</th>
                                                <!-- Add more columns as needed -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Fetch data from clients where status is 'grant'
                                            // $query = "SELECT * FROM clients WHERE status = 'denied'";
                                            $query = "SELECT c.*, dc.reason, DATE_FORMAT(dc.date_denied, '%b. %d, %Y') AS dd 
                                            FROM clients c 
                                            JOIN denied_clients dc ON c.id = dc.client_id 
                                            WHERE c.status = 'denied' 
                                            ORDER BY $order_by 
                                            LIMIT $start, $display";
                                            $result = mysqli_query($dbc, $query);


                                            while ($row = mysqli_fetch_assoc($result)):
                                                ?>
                                                <tr>
                                                    <td class="text-center"><?= $row['id'] ?></td>
                                                    <td><?= ucfirst($row['first_name']) . ' ' . ucfirst($row['middle_name']) . ' ' . ucfirst($row['last_name']) . ' ' . ucfirst($row['suffix']) ?>
                                                    </td>
                                                    <td><?= ucfirst($row['alias']) ?></td>
                                                    <td><?= ucfirst($row['municipality']) ?></td>
                                                    <td><label class="badge badge-info"><?= ($row['status']) ?></label></td>
                                                    <td><?= isset($row['reason']) && !empty($row['reason']) ? ucfirst($row['reason']) : 'No reason specified' ?>
                                                    </td>
                                                    <td class="text-center"><?= $row['dd'] ?></td>
                                                    <td>
                                                        <div class='dropdown'>
                                                            <button class='btn btn-primary dropdown-toggle' type='button'
                                                                id='dropdownMenuButton1' data-bs-toggle='dropdown'
                                                                aria-haspopup='true' aria-expanded='false'> Action </button>
                                                            <div class='dropdown-menu dropdown-menu-right'
                                                                aria-labelledby='dropdownMenuButton1'>
                                                                <h6 class='dropdown-header'>Options</h6>
                                                                <a class='dropdown-item text-dark'
                                                                    href='view_details.php?id=<?= $row['id'] ?>'>View
                                                                    Details</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>

                                        </tbody>
                                    </table>
                                </div><br />

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
                                                        href="denied_list.php?s=<?= ($start - $display) ?>&p=<?= $pages ?>&sort=<?= $sort ?>">Previous</a>
                                                </li>
                                            <?php endif; ?>

                                            <!-- Make all the numbered pages: -->
                                            <?php for ($i = 1; $i <= $pages; $i++): ?>
                                                <li class="page-item <?= ($i == $current_page) ? 'active" aria-current="page">' : '">' ?>
                                                    <a class=" page-link"
                                                    href="denied_list.php?s=<?= (($display * ($i - 1))) ?>&p=<?= $pages ?>&sort=<?= $sort ?>">
                                                    <?= $i ?></a>
                                                </li>
                                            <?php endfor; ?>

                                            <!-- If it's not the last page, make a Next button: -->
                                            <?php if ($current_page != $pages): ?>
                                                <li class="page-item"><a class="page-link"
                                                        href="denied_list.php?s=<?= ($start + $display) ?>&p=<?= $pages ?>&sort=<?= $sort ?>">Next</a>
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

    <?php show_footer(); ?>