<?php

include __DIR__ . '/functions.php';

show_header();
display_navbar();
display_sidebar();
set_config_inc();


$userLevel = $_SESSION['user_level'];

//* Check for a valid user ID, through GET or POST:
if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) { // From view_users.php
    $id = $_GET['id'];
} elseif ((isset($_POST['id'])) && (is_numeric($_POST['id']))) { // Form submission.
    $id = $_POST['id'];
} else { // No valid ID, kill the script.
    // echo '<p class="text-danger">This page has been accessed in error.</p>';
    // include 'inc/footer.php';
    // $url = BASE_URL . '';
    // header("Location: $url");
    // exit();
    oopsMsg('This page has been accessed in error.');
}


require(MYSQL);


// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $errors = [];

    // Check for a first name:
    if (empty($_POST['first_name'])) {
        $errors[] = 'You forgot to enter your first name.';
    } else {
        $fn = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
    }

    //Check for Middle Name:
    if (empty($_POST['middle_name'])) {
        $errors[] = 'You forgot to enter your middle name.';
    } else {
        $mn = mysqli_real_escape_string($dbc, trim($_POST['middle_name']));
    }

    // Check for a last name:
    if (empty($_POST['last_name'])) {
        $errors[] = 'You forgot to enter your last name.';
    } else {
        $ln = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
    }

    $suffix = mysqli_real_escape_string($dbc, trim($_POST['suffix']));

    // Check for an email address:
    if (empty($_POST['email'])) {
        $errors[] = 'You forgot to enter your email address.';
    } else {
        $e = mysqli_real_escape_string($dbc, trim($_POST['email']));
    }

    // Check for an mobile phone number:
    if (empty($_POST['mobile_number'])) {
        $errors[] = 'Please enter your Mobile Number.';
    } elseif (!preg_match('/^(09|\+639)\d{9}$/', $_POST['mobile_number'])) {
        $errors[] = 'Invalid Mobile Number. Please use the format: 09xxxxxxxxx or +639xxxxxxxxx.';
    } else {
        $mobile_number = mysqli_real_escape_string($dbc, trim($_POST['mobile_number']));
    }


    if (empty($errors)) { // If everything's OK.

        //  Test for unique email address:
        $q = "SELECT user_id FROM users WHERE email='$e' AND user_id != $id";
        $r = @mysqli_query($dbc, $q);
        if (mysqli_num_rows($r) == 0) {

            // Make the query:
            $q = "UPDATE users SET first_name='$fn', middle_name='$mn', last_name='$ln', suffix='$suffix', email='$e', mobile_number='$mobile_number' WHERE user_id=$id LIMIT 1";
            $r = @mysqli_query($dbc, $q);
            if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

                // Print a message:
                //echo '<p class="text-success">The user has been edited.</p>';
                success("The user has been edited.", "profile.php");
            } else { // If it did not run OK.
                //echo '<p class="text-danger">The user could not be edited due to a system error. We apologize for any inconvenience.</p>'; // Public message.
                //echo '<p>' . mysqli_error($dbc) . '<br>Query: ' . $q . '</p>'; // Debugging message.
                errorMsg("The user could not be edited due to a system error. We apologize for any inconvenience.", "profile.php");
                exit();
            }
        } else { // Already registered.
            // echo '<p class="text-danger">The email address has already been registered.</p>';
            error('The email address has already been registered.');
        }
    } else { // Report the errors.

        echo '<p class="text-danger">The following error(s) occurred:<br>';
        foreach ($errors as $msg) { // Print each error.
            echo " - $msg<br>\n";
        }
        echo '</p><p>Please try again.</p>';
    } // End of if (empty($errors)) IF.

} // End of submit conditional.




?>

<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Edit Profile</h3>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href=<?php echo $userLevel == 1 ? 'admin_dashboard.php' : 'user_dashboard.php'; ?>>Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Edit Personal information</h5>

                                <hr />
                                <div class="container">
                                    <div class="row">

                                        <?php
                                        // Always show the form...
                                        // Retrieve the user's information:
                                        $q = "SELECT first_name, middle_name, last_name, suffix, email, mobile_number FROM users WHERE user_id=$id";
                                        $r = @mysqli_query($dbc, $q);

                                        if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.

                                            // Get the user's information:
                                            $row = mysqli_fetch_array($r, MYSQLI_NUM);

                                            // Create the form:
                                            echo '<div class="col-md-3"><form action="edit_profile.php" method="post">
                                                        <div class="mb-3">
                                                            <label for="first_name" class="form-label">First Name:</label>
                                                            <input type="text" class="form-control" id="first_name" name="first_name" maxlength="15" value="' . $row[0] . '">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-3">
                                                        <div class="mb-3">
                                                            <label for="middle_name" class="form-label">Middle Name:</label>
                                                            <input type="text" class="form-control" id="middle_name" name="middle_name" maxlength="15" value="' . $row[1] . '">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="mb-3">
                                                            <label for="last_name" class="form-label">Last Name:</label>
                                                            <input type="text" class="form-control" id="last_name" name="last_name" maxlength="15" value="' . $row[2] . '">
                                                        </div>
                                                    </div>
                                                
                                                    <div class="col-md-3">
                                                        <div class="mb-3">
                                                            <label for="suffix" class="form-label">Suffix:</label>
                                                            <select class="form-select" id="suffix" name="suffix">
                                                                <option value="" ' . ($row[3] == '' ? 'selected' : '') . '>Select</option>
                                                                <option value="Jr." ' . ($row[3] == 'Jr.' ? 'selected' : '') . '>Jr.</option>
                                                                <option value="Sr." ' . ($row[3] == 'Sr.' ? 'selected' : '') . '>Sr.</option>
                                                                <option value="II" ' . ($row[3] == 'II' ? 'selected' : '') . '>II</option>
                                                                <option value="III" ' . ($row[3] == 'III' ? 'selected' : '') . '>III</option>
                                                                <option value="IV" ' . ($row[3] == 'IV' ? 'selected' : '') . '>IV</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="email" class="form-label">Email Address:</label>
                                                            <input type="email" class="form-control" id="email" name="email" maxlength="60" value="' . $row[4] . '" readonly>
                                                            <small class="text-info">This field can\'t be edited.</small>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="mobile_number" class="form-label">Mobile Number:</label>
                                                            <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="' . $row[5] . '">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <input type="submit" class="btn btn-grad" name="submit" value="Submit">
                                                    </div>
                                                    <input type="hidden" name="id" value="' . $id . '">
                                                    
                                                </form>
                                                </div>';
                                        } else { // Not a valid user ID.
                                            echo '<strong><p class="text-danger">This page has been accessed in error.</p></strong>';
                                        }

                                        mysqli_close($dbc);


                                        ?>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->




        <?php show_footer(); ?>