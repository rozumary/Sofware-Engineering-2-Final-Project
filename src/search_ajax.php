<?php
session_start();  // Start the session

include __DIR__ . '/functions.php';
require 'mysqli_connect.php';

$userLevel = $_SESSION['user_level'] ?? null;  // Safely access user_level

if (isset($_GET['search_query']) && isset($_GET['search_by'])) {
    $search_query = mysqli_real_escape_string($dbc, $_GET['search_query']);
    $search_by = mysqli_real_escape_string($dbc, $_GET['search_by']);

    // Modify the query dynamically based on the chosen search option
    $whereClause = '';
    switch ($search_by) {
        case 'first_name':
            $whereClause = "first_name LIKE '%$search_query%'";
            break;
        case 'last_name':
            $whereClause = "last_name LIKE '%$search_query%'";
            break;
        case 'middle_name':
            $whereClause = "middle_name LIKE '%$search_query%'";
            break;
        case 'alias':
            $whereClause = "alias LIKE '%$search_query%'";
            break;
        case 'case_number':
            $whereClause = "case_number LIKE '%$search_query%'";
            break;
        default:
            $whereClause = "first_name LIKE '%$search_query%'";
            break;
    }

    // Final query
    $search_result = mysqli_query($dbc, "SELECT * FROM clients WHERE $whereClause");

    if (mysqli_num_rows($search_result) > 0) {
        echo '<table class="table table-striped">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>First Name</th>';
        echo '<th>Middle Name</th>';
        echo '<th>Last Name</th>';
        echo '<th>Suffix</th>';
        echo '<th>Alias</th>';
        echo '<th>Case Number</th>';
        echo '<th>Status</th>';
        echo '<th>Actions</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($row = mysqli_fetch_assoc($search_result)) {
            echo "<tr>";
            echo "<td>" . ucfirst($row['first_name']) . "</td>";
            echo "<td>" . ucfirst($row['middle_name']) . "</td>";
            echo "<td>" . ucfirst($row['last_name']) . "</td>";
            echo "<td>" . ucfirst($row['suffix']) . "</td>";
            echo "<td>" . ucfirst($row['alias']) . "</td>";
            echo "<td class='font-weight-bold'>" . ucfirst($row['case_number']) . "</td>";

            // Show status
            if ($row['status'] == 'grant') {
                echo "<td><label class='badge badge-success'>" . $row['status'] . "</label></td>";
            } elseif ($row['status'] == 'pending') {
                echo "<td><label class='badge badge-warning'>" . $row['status'] . "</label></td>";
            } elseif ($row['status'] == 'denied') {
                echo "<td><label class='badge badge-danger'>" . $row['status'] . "</label></td>";
            } else {
                echo "<td></td>";
            }

            echo "<td><div class='dropdown'>
                        <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Action</button>
                        <div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuButton1'>
                            <h6 class='dropdown-header'>Options</h6>
                            <a class='dropdown-item text-dark' href='view_details.php?id={$row['id']}'>View Details</a>
                        </div>
                    </div></td>";
            echo "</tr>";
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo "<tr><td colspan='8'>No results found.</td></tr>";
    }
}
?>
