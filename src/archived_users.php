<?php

include __DIR__ . '/functions.php';

show_header();
display_navbar();
display_sidebar();
set_config_inc();

require(MYSQL);

// Set number of users to display per page
$display = 7;

// Get current page number from GET or default to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$start = ($page - 1) * $display;

// Count total number of inactive users
$q = "SELECT COUNT(user_id) FROM users WHERE user_level = 0";
$r = mysqli_query($dbc, $q);
list($total_records) = mysqli_fetch_array($r, MYSQLI_NUM);
$total_pages = ceil($total_records / $display);

// Fetch inactive users with LIMIT for pagination
$q = "SELECT user_id, first_name, last_name, email, DATE_FORMAT(registration_date, '%M %d, %Y') AS reg_date 
      FROM users 
      WHERE user_level = 0 
      ORDER BY registration_date DESC 
      LIMIT $start, $display";
$r = mysqli_query($dbc, $q);

// Display user table
echo '<div class="container mt-4">';
echo '<h3>Archived Users</h3>';
echo '<table class="table table-bordered table-striped">';
echo '<thead><tr><th>Name</th><th>Email</th><th>Date Registered</th></tr></thead><tbody>';

while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) . '</td>';
    echo '<td>' . htmlspecialchars($row['email']) . '</td>';
    echo '<td>' . htmlspecialchars($row['reg_date']) . '</td>';
    echo '</tr>';
}
echo '</tbody></table>';

// Pagination links
if ($total_pages > 1) {
    echo '<nav><ul class="pagination">';
    for ($i = 1; $i <= $total_pages; $i++) {
        echo '<li class="page-item' . ($i === $page ? ' active' : '') . '">';
        echo '<a class="page-link" href="archived_users.php?page=' . $i . '">' . $i . '</a>';
        echo '</li>';
    }
    echo '</ul></nav>';
}

echo '</div>';
