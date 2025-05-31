<?php
include __DIR__ . '/functions.php';

show_header();
display_navbar();
display_sidebar();
set_config_inc();

require(MYSQL);

$userLevel = $_SESSION['user_level'];

// Number of records to show per page:
$display = 5;

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

// Handle search query
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($dbc, $_GET['search']);
    $query = "SELECT *, DATE_FORMAT(registration_date, '%M %d, %Y') AS dr, id FROM clients 
            WHERE (status IN ('pending') OR status IS NULL) AND 
                    (first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR alias LIKE '%$search%') 
            ORDER BY $order_by LIMIT $start, $display";
    $result = mysqli_query($dbc, $query);
} else {
    $result = mysqli_query($dbc, "SELECT *, DATE_FORMAT(registration_date, '%M %d, %Y') AS dr, id FROM clients 
            WHERE status IN ('pending') OR status IS NULL 
            ORDER BY $order_by LIMIT $start, $display ");
}

?>

<!-- ... (rest of the code) ... -->

<?php if (isset($result) && $result) : ?>
    <!-- Display search results or main list here -->
    <div class="table-responsive-md">
        <table class="table table-hover table-bordered">
            <thead class="table-dark">
                <tr>
                    <!-- ... (headers code) ... -->
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <!-- ... (data code) ... -->
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Pagination for search results or main list -->
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <!-- ... (pagination code) ... -->
            </ul>
        </nav>
    </div>
<?php endif; ?>

<!-- ... (rest of the code) ... -->