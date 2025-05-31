<?php
include __DIR__ . '/functions.php';
require 'mysqli_connect.php'; // This should set $dbc

if (isset($_GET['search_query']) && isset($_GET['search_by'])) {
    $search_query = mysqli_real_escape_string($dbc, $_GET['search_query']);
    $search_by = mysqli_real_escape_string($dbc, $_GET['search_by']);

    if ($search_query === '__all__') {
        $whereClause = '1'; // No WHERE filter, return all
    } else {
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
    }

    $search_result = mysqli_query($dbc, "SELECT * FROM clients WHERE caretaker_user_id = 0 AND (status = 'pending' OR status IS NULL) AND ($whereClause)");

    if (mysqli_num_rows($search_result) > 0) {
        echo '<div class="table-responsive-md"><h5>Search Results:</h5>';
        echo '<table class="table table-hover table-bordered table-md">';
        echo '<thead class="table-dark">';
        echo '<tr>';
        echo '<th scope="col">First Name</th>';
        echo '<th scope="col">Middle Name</th>';
        echo '<th scope="col">Last Name</th>';
        echo '<th scope="col">Suffix</th>';
        echo '<th scope="col">Alias</th>';
        echo '<th scope="col">Case Number</th>';
        echo '<th scope="col" class="text-center">Action</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody class="table-group-divider">';

        while ($row = mysqli_fetch_assoc($search_result)) {
            echo '<tr>';
            echo '<td>' . hideName(ucfirst($row['first_name'])) . '</td>';
            echo '<td>' . hideName(ucfirst($row['middle_name'])) . '</td>';
            echo '<td>' . hideName(ucfirst($row['last_name'])) . '</td>';
            echo '<td>' . hideName(ucfirst($row['suffix'])) . '</td>';
            echo '<td>' . ucfirst($row['alias']) . '</td>';
            echo '<td class="font-weight-bold">' . hideName($row['case_number']) . '</td>';
            echo "<td><a href='add_as_client.php?id={$row['id']}' class='btn btn-primary'>Add as Client</a></td>";
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table></div>';
    } else {
        echo '<blockquote class="blockquote blockquote-primary"><p class="text-dark">No results found.</p></blockquote>';
    }
}
?>
