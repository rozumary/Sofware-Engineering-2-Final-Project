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
if (isset($_GET['p']) && is_numeric($_GET['p'])) : // Already been determined.
    $pages = $_GET['p'];
else : // Need to determine.
    // Count the number of records:
    // $q = "SELECT COUNT(id) FROM email_messages WHERE status = 'completed'";
    $q = "SELECT COUNT(id) FROM email_messages";
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
$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'dc';

// Determine the sorting order:
switch ($sort):
    case 'name':
        $order_by = 'name ASC';
        break;
    case 'email':
        $order_by = 'email ASC';
        break;
    case 'dr':
        $order_by = 'date_received ASC';
        break;
    default:
        $order_by = 'date_received ASC';
        $sort = 'dr';
        break;
endswitch;


?>

<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Email Messages</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href=<?php echo $userLevel == 1 ? 'admin_dashboard.php' : 'user_dashboard.php'; ?>>Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Email Messages</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Email Messages Received</h5>


                                <div class="table-responsive-lg table-responsive-md table-responsive-sm">
                                    <table class="table table-hover table-bordered">
                                        <thead class="table-dark">
                                            <tr>
                                                <th scope="col" class="text-nowrap text-center">Email ID</th>
                                                <th scope="col" class="text-nowrap text-center">Name<a href="email_msg.php?sort=name"><i class="mdi mdi-sort-alphabetical"></i></a></th>
                                                <th scope="col" class="text-nowrap text-center">Email<a href="email_msg.php?sort=email"><i class="mdi mdi-sort"></i></a></th>
                                                <th scope="col" class="text-nowrap text-center">Subject</th>
                                                <!-- <th scope="col">Case No.</th> -->
                                                <th scope="col" class="text-nowrap text-center">Message</th>
                                                <th scope="col" class="text-nowrap text-center">Date Received<a href="email_msg.php?=sort=dr"><i class="mdi mdi-sort"></i></a></th>
                                                <!-- <th scope="col" class="text-nowrap text-center">Action</th> -->
                                                <!-- Add more columns as needed -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Fetch data from clients where status is 'grant'
                                            //$query = "SELECT * FROM clients WHERE status = 'grant' ORDER BY $order_by LIMIT $start, $display";
                                            // $query = "SELECT e.*, DATE_FORMAT(ee.date_received, '%b. %d, %Y') AS dr FROM email_messages e JOIN completed_client cc ON c.id = cc.client_id WHERE c.status = 'completed' ORDER BY $order_by LIMIT $start, $display";
                                            // $query = "SELECT *, DATE_FORMAT(registration_date, '%M %d, %Y') AS dr, id FROM clients WHERE status IN ('pending') OR status IS NULL ORDER BY $order_by LIMIT $start, $display ";
                                            $query = "SELECT *, DATE_FORMAT(date_received, '%M %d, %Y-%h:%i:%s') AS dr, id FROM email_messages";
                                            $result = mysqli_query($dbc, $query);

                                            while ($row = mysqli_fetch_assoc($result)) :
                                            ?>
                                                <tr>
                                                    <td class="text-center"><?= $row['id'] ?></td>
                                                    <td><?= ucfirst($row['name']) ?></td>
                                                    <td><?= ucfirst($row['email']) ?></td>
                                                    <td><?= ucfirst($row['subject']) ?></td>
                                                    <td><?= ucfirst($row['message']) ?></td>
                                                    <td class="text-center"><?= $row['dr'] ?></td>
                                                    <!-- <td>
                                                        <div class='dropdown'>
                                                            <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action </button>
                                                            <div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuButton1'>
                                                                <h6 class='dropdown-header'>Options</h6>
                                                                <a class='dropdown-item text-dark' href='view_details.php?id=<?= $row['id'] ?>'>View Details</a>
                                                                
                                                            </div>
                                                        </div>
                                                    </td> -->
                                                    <!-- Add more columns as needed -->
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
                                        if ($pages > 1) :
                                            $current_page = ($start / $display) + 1;

                                            // If it's not the first page, make a Previous button:
                                            if ($current_page != 1) :
                                        ?>
                                                <li class="page-item"><a class="page-link" href="email_msg.php?s=<?= ($start - $display) ?>&p=<?= $pages ?>&sort=<?= $sort ?>">Previous</a></li>
                                            <?php endif; ?>

                                            <!-- Make all the numbered pages: -->
                                            <?php for ($i = 1; $i <= $pages; $i++) : ?>
                                                <li class="page-item <?= ($i == $current_page) ? 'active" aria-current="page">' : '">' ?>
                                                    <a class=" page-link" href="email_msg.php?s=<?= (($display * ($i - 1))) ?>&p=<?= $pages ?>&sort=<?= $sort ?>"><?= $i ?></a>
                                                </li>
                                            <?php endfor; ?>

                                            <!-- If it's not the last page, make a Next button: -->
                                            <?php if ($current_page != $pages) : ?>
                                                <li class="page-item"><a class="page-link" href="email_msg.php?s=<?= ($start + $display) ?>&p=<?= $pages ?>&sort=<?= $sort ?>">Next</a></li>
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