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
                    <li class="breadcrumb-item active" aria-current="page">Search</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Search Account</h5>

                                <div class="container mt-5">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <form id="searchForm" onsubmit="return false;">
                                                <div class="form-group">
                                                    <label for="search_query" class="font-weight-bold text-dark">Search:</label>
                                                         <input type="text" class="form-control" id="search_query" name="search_query" required>
                                                </div>
                                                </form>
                                        </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="search_by" class="font-weight-bold text-dark">Search By:</label>
                                                <select class="form-select" id="search_by" name="search_by">
                                                    <option value="first_name">First Name</option>
                                                    <option value="last_name">Last Name</option>
                                                    <option value="middle_name">Middle Name</option>
                                                    <option value="alias">Alias</option>
                                                    <option value="case_number">Case Number</option>
                                                    <!-- Add more options as needed -->
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    </form> <br><br>

                                    <div id="search_results"></div>


                                    <?php

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
                                                // Add more cases for additional search options
                                            default:
                                                // Default to searching by first name
                                                $whereClause = "first_name LIKE '%$search_query%'";
                                                break;
                                        }

                                        // Final query
                                        $search_result = mysqli_query($dbc, "SELECT * FROM clients WHERE $whereClause");

                                        // Display search results in a table
                                        if (
                                            mysqli_num_rows($search_result) > 0
                                        ) {
                                            echo '<br /><br /><h5 class"text-primary">Search Results:</h5>';
                                            echo '<div class="table-responsive-md">';
                                            echo '<table class="table table-hover table-bordered table-md">';
                                            echo '<thead class="table-dark">';
                                            echo '<tr>';
                                            echo '<th scope="col">First Name</th>';
                                            echo '<th scope="col">Middle Name</th>';
                                            echo '<th scope="col">Last Name</th>';
                                            echo '<th scope="col">Suffix</th>';
                                            echo '<th scope="col">Alias</th>';
                                            echo '<th scope="col">Case Number</th>';
                                            echo '<th scope="col">Status</th>';
                                            echo '<th scope="col">Action</th>';
                                            // Add more table headers as needed
                                            echo '</tr>';
                                            echo '</thead>';
                                            echo '<tbody class="table-group-divider">';
                                            while ($row = mysqli_fetch_assoc($search_result)) {
                                                if ($userLevel == 0) :
                                                echo '<tr>';
                                                echo '<td>' . hideName(ucfirst($row['first_name']))   . '</td>';
                                                echo '<td>' . hideName(ucfirst($row['middle_name']))  . '</td>';
                                                echo '<td>' . hideName(ucfirst($row['last_name']))    . '</td>';
                                                echo '<td>' . hideName(ucfirst($row['suffix']))       . '</td>';
                                                echo '<td>' . ucfirst($row['alias'])        . '</td>';
                                                echo '<td class="font-weight-bold">' . hideName(ucfirst($row['case_number']))        . '</td>';
                                                else:
                                                    echo '<tr>';
                                                    echo '<td>' . ucfirst($row['first_name'])   . '</td>';
                                                    echo '<td>' . ucfirst($row['middle_name'])  . '</td>';
                                                    echo '<td>' . ucfirst($row['last_name'])    . '</td>';
                                                    echo '<td>' . ucfirst($row['suffix'])       . '</td>';
                                                    echo '<td>' . ucfirst($row['alias'])        . '</td>';
                                                    echo '<td class="font-weight-bold">' . ucfirst($row['case_number'])        . '</td>';
                                                endif;
                                                if ($row['status'] == 'grant') {
                                                    echo '<td><label class="badge badge-success">' . $row['status'] . '</label></td>';
                                                } elseif ($row['status'] == 'pending') {
                                                    echo '<td><label class="badge badge-warning">' . $row['status'] . '</label></td>';
                                                } elseif ($row['status'] == 'denied') {
                                                    echo '<td><label class="badge badge-danger">' . $row['status'] . '</label></td>';
                                                } else {
                                                    // echo '<td><label class="badge badge-warning>' . $row['status'] . '</label></td>';
                                                    echo '<td></td>';
                                                }
                                                // Add more table cells as needed
                                                echo "<td>
                                                    <div class='dropdown'>
                                                        <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action </button>
                                                        <div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuButton1'>
                                                            <h6 class='dropdown-header'>Options</h6>
                                                            <a class='dropdown-item text-dark' href='view_details.php?id={$row['id']}'>View Details</a>
                                                        </div>
                                                    </td>";
                                                echo '</tr>';
                                            }
                                            echo '</tbody>';
                                            echo '</table></div>';
                                        } else {
                                            echo '<div></div><blockquote class="blockquote blockquote-primary"><p class="text-dark">No results found.</p></blockquote>';
                                            // echo '<p class="text-dark">No results found.</p>';
                                        }
                                    }
                                    ?>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->



        <?php show_footer(); ?>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function(){
    $('#search_query').on('input', function(){
        var query = $(this).val();
        var searchBy = $('#search_by').val();
        if(query.length > 0) {
            $.ajax({
                url: 'search_ajax.php',
                type: 'GET',
                data: { search_query: query, search_by: searchBy },
                success: function(data){
                    $('#search_results').html(data);
                }
            });
        } else {
            $('#search_results').html('');
        }
    });
});
</script>


