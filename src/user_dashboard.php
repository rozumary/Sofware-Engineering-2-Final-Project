<?php

include __DIR__ . '/functions.php';

show_header();
set_config_inc();

display_navbar();
display_sidebar();

require(MYSQL);

$userLevel = $_SESSION['user_level'];
$e = $_SESSION['email'];
$user_id = $_SESSION['user_id'];



?>



<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Dashboard</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href=<?php echo $userLevel == 1 ? 'admin_dashboard.php' : 'user_dashboard.php'; ?>>Dashboard</a></li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">

                                <?php

                                $client_query = mysqli_query($dbc, "SELECT * FROM users WHERE user_id = $user_id AND client != 0");
                                if (mysqli_num_rows($client_query) > 0):
                                    $client_data = mysqli_fetch_assoc($client_query);
                                    $cd = $client_data['client'];

                                    $url = BASE_URL . 'view_details.php?id=' . $cd;
                                    header("Location: " . $url);
                                else:
                                    ?>

                                    <h5 class="card-title">Search for Petitioner</h5>
                                    <div class="container mt-5">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <form action="" method="GET">
                                                    <div class="form-group">
                                                        <label for="search_by" class="font-weight-bold text-dark">Search
                                                            By:</label>
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

                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="search_query"
                                                        class="font-weight-bold text-dark">Search:</label>
                                                    <input type="text" class="form-control" id="search_query"
                                                        name="search_query" placeholder="Search Here..." required>
                                                </div>

                                            </div>
                                        </div>
                                                                                        <div id="searchResults"></div>
                                        </form> <br><br>


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
                                            $search_result = mysqli_query($dbc, "SELECT * FROM clients WHERE caretaker_user_id = 0 AND (status = 'pending' OR status IS NULL) AND ($whereClause)");

                                            // Display search results in a table
                                            if (
                                                mysqli_num_rows($search_result) > 0
                                            ) {
                                                echo '<br /><br />';
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
                                                // Add more table headers as needed
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
                                                    // Add more table cells as needed
                                                    // <a class='dropdown-item text-dark' href='view_details.php?id={$row['id']}'>View Details</a>
                                                    // echo "<td>
                                                    // <div class='dropdown'>
                                                    //     <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action </button>
                                                    //     <div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuButton1'>
                                                    //         <h6 class='dropdown-header'>Options</h6>
                                                    //         <a class='dropdown-item text-dark' href='add_as_client.php?id={$row['id']}'>Add as Client</a>
                                                    //     </div>
                                                    // </td>";
                                    
                                                    //<input type=submit' class='btn btn-grad' name='submit' value='Submit'>
                                                    echo "<td>
                                                        <div'>
                                                                <a href='add_as_client.php?id={$row['id']}' class='btn btn-primary'>Add as Client</a>
                                                                <input type='hidden' name='id' value='" . $row['id'] . "'>
                                                            </td>";

                                                    echo '</tr>';
                                                }
                                                echo '</tbody>';
                                                echo '</table></div>';
                                            } else {
                                                // echo '<p class="text-dark">No results found.</p>';
                                            }
                                        }
                                        ?>



                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Note</h5>

                                            <blockquote class="blockquote blockquote-danger">
                                                <h6 class="text-danger font-weight-bold">If you cannot find the name of the
                                                    Petitioner you are looking for, here are the possible reasons:</h6>
                                                <ul class="text-danger list-arrow">
                                                    <li>Case not yet filed: The petition may not have been filed yet, or it
                                                        might be in the process of being filed and hasn't been entered into
                                                        the system. In such cases, the user would need to wait until the
                                                        case is officially filed and processed before it becomes searchable.
                                                    </li>
                                                    <li>Incomplete or inaccurate search criteria: You may not be providing
                                                        enough or accurate information to narrow down the search results.
                                                    </li>
                                                    <li>Case filed under a different name: The petitioner might have filed
                                                        the case under a different name, such as their married name,
                                                        nickname, or alias. If you are unaware of these alternative names,
                                                        you may not be able to find the petitioner's record using their
                                                        primary name alone.</li>
                                                    <li>Technical issues: Technical glitches or downtime on the search
                                                        platform could temporarily prevent the user from accessing or
                                                        retrieving petitioner information.</li>
                                                </ul>
                                            </blockquote>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        <?php endif; ?>

      <script>
    const searchInput = document.getElementById('search_query');
    const searchBy = document.getElementById('search_by');
    const resultsDiv = document.getElementById('searchResults');

 function fetchResults() {
    let query = searchInput.value.trim();
    const by = searchBy.value;

    // Only fetch if query is not empty OR is exactly '*'
    if (query === '') {
        resultsDiv.innerHTML = ''; // Clear any existing results
        return;
    }

    if (query === '*') {
        query = '__all__';  // Let PHP know to return all
    }

    fetch(`search_ajax1.php?search_by=${encodeURIComponent(by)}&search_query=${encodeURIComponent(query)}`)
        .then(response => response.text())
        .then(data => {
            resultsDiv.innerHTML = data;
        })
        .catch(error => {
            console.error('Fetch error:', error);
            resultsDiv.innerHTML = '<p class="text-danger">Error loading results.</p>';
        });
}


    // Debounce to limit AJAX requests while typing
    let debounceTimeout;
    searchInput.addEventListener('input', () => {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(fetchResults, 300);
    });

    searchBy.addEventListener('change', () => {
        fetchResults();  // Always trigger on dropdown change
    });

    // Optional: Fetch all results on page load
    // fetchResults();
</script>


        <?php
        show_footer(); ?>