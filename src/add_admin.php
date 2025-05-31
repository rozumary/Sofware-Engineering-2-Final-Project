<?php

include __DIR__ . '/functions.php';
set_config_inc();

show_header();
display_navbar();
display_sidebar();

require(MYSQL);


$userLevel = $_SESSION['user_level'];
$role = $_SESSION['role'];

if ($userLevel !== 1 && $role !== 'superadmin') :
    errorMsg("Access denied", "users_list.php");
endif;

// Initialize an array to store validation errors
$errors = [];

// Trim all the incoming data:
$expected_fields = ['first_name', 'middle_name', 'last_name', 'suffix', 'email', 'mobile_number', 'password'];
$trimmed = [];
foreach ($expected_fields as $field) {
    if (isset($_POST[$field])) {
        $trimmed[$field] = trim($_POST[$field]);
    }
}


// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    // Validate First Name
    if (empty($_POST['first_name'])) {
        $errors[] = 'Please enter your First Name.';
    } else {
        $first_name = trim($_POST['first_name']);
    }

    $middle_name = trim($_POST['middle_name']);

    // Validate Last Name
    if (empty($_POST['last_name'])) {
        $errors[] = 'Please enter your Last Name.';
    } else {
        $last_name = trim($_POST['last_name']);
    }

    $suffix = $_POST['suffix'];


    // Validate Email Address
    if (empty($_POST['email'])) {
        $errors[] = 'Please enter your Email Address.';
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid Email Address.';
    } else {
        // $email = trim($_POST['email']);
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    }

    // Validate Mobile Number
    if (empty($_POST['mobile_number'])) {
        $errors[] = 'Please enter your Mobile Number.';
    } elseif (!preg_match('/^(09|\+639)\d{9}$/', $_POST['mobile_number'])) {
        $errors[] = 'Invalid Mobile Number. Please use the format: 09xxxxxxxxx or +639xxxxxxxxx.';
    } else {
        $mobile_number = trim($_POST['mobile_number']);
    }

    if (strlen(trim($_POST['password1']) >= 10 && isPasswordStrong(trim($_POST['password1'])))) {
        if (trim($_POST['password1']) == trim($_POST['password2'])) {
            $p = password_hash(trim($_POST['password1']), PASSWORD_DEFAULT);
        } else {
            $errors[] = 'Your password did not match the confirmed password!';
        }
    } else {
        $errors[] = 'Please enter a valid password, Password should be at least 10 characters long and include uppercase, lowercase, digits, and special characters';
    }



    // If there are no errors, you can proceed with the registration
    if (empty($errors)) {
        try {

            // Check if the email is already registered
            $check_query = "SELECT COUNT(*) FROM users WHERE email = :email";
            $check_stmt = $pdo->prepare($check_query);
            $check_stmt->bindParam(':email', $email);
            $check_stmt->execute();
            $email_exists = $check_stmt->fetchColumn();

            if ($email_exists) {
                $errors[] = 'Email address is already registered. Please use a different email.';
            } else {

                // $default_status = NULL;
                // // $status_value = $status ?? $default_status;
                // $status_value = $default_status;

                $user_level = '1';
                $user_level_value = $user_level;

                $roles = 'admin';
                $roles_value = $roles;

                $active = NULL;
                $active_value = $active;

                $verified = '1';
                $verified_value = $verified;

                // Prepare the SQL query
                $insert_query = "INSERT INTO users (first_name, middle_name, last_name, suffix, email, mobile_number, pass, user_level, role, active, verified, registration_date)
                VALUES (:first_name, :middle_name, :last_name, :suffix, :email, :mobile_number, :pass, :user_level, :role, :active, :verified, NOW())";

                $insert_stmt = $pdo->prepare($insert_query);

                // Bind parameters to the prepared statement
                $insert_stmt->bindParam(':first_name', $first_name);
                $insert_stmt->bindParam(':middle_name', $middle_name);
                $insert_stmt->bindParam(':last_name', $last_name);
                $insert_stmt->bindParam(':suffix', $suffix);
                $insert_stmt->bindParam(':email', $email);
                $insert_stmt->bindParam(':mobile_number', $mobile_number);
                $insert_stmt->bindParam(':pass', $p);
                $insert_stmt->bindParam(':user_level', $user_level_value);
                $insert_stmt->bindParam(':role', $roles_value);
                $insert_stmt->bindParam(':role', $roles_value);
                $insert_stmt->bindParam(':active', $active_value);
                $insert_stmt->bindParam(':verified', $verified_value);



                // Execute the prepared statement
                $insert_stmt->execute();

                // Redirect to a success page or perform any other actions after successful registration
                // header("Location: registration_success.php");
                success("admin added successfully", "users_list.php");
                // echo '<div class="alert alert-success">';
                // echo "<h3>Petitioner Successfully Added</h3>";
                // echo '</div> <br /><br /><br />';
                // include 'inc/footer.php';
                exit();
            }
        } catch (PDOException $e) {
            // Handle database errors
            $errors[] = 'An error occurred while adding. Please try again.'
                . $e->getMessage();
        }
    }
}

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
                                // Display errors, if any
                                if (!empty($errors)) {
                                    echo '<div class="alert alert-danger">';
                                    foreach ($errors as $error) {
                                        echo '<p>' . $error . '</p>';
                                    }
                                    echo '</div>';
                                }
                                ?>

                                <h5 class="card-title">Add Admin Officer</h5>

                                <div class="container">
                                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

                                        <div class="mb-3">
                                            <h5 class="card-subtitle mb-2 text-muted">Personal Information</h5>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-4">
                                                <label for="first_name" class="form-label text-dark">First Name</label>
                                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First name" autocomplete="given-name" value="<?php if (isset($_POST['first_name'])) echo htmlspecialchars($_POST['first_name'], ENT_QUOTES); ?>">
                                            </div>

                                            <div class="col-md-4">
                                                <label for="middle_name" class="form-label text-dark">M.I.</label>
                                                <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Enter Middle name" value="<?php if (isset($_POST['middle_name'])) echo htmlspecialchars($_POST['middle_name'], ENT_QUOTES); ?>">
                                            </div>

                                            <div class="col-md-4">
                                                <label for="last_name" class="form-label text-dark">Last Name</label>
                                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last name" autocomplete="family-name" value="<?php if (isset($_POST['last_name'])) echo htmlspecialchars($_POST['last_name'], ENT_QUOTES); ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-4">
                                                <label for="suffix" class="form-label text-dark">Suffix</label>
                                                <select class="form-select" id="suffix" name="suffix">
                                                    <option value="">Select</option>
                                                    <option value="Jr." <?php if (isset($trimmed['suffix']) && $trimmed['suffix'] == 'Jr.') echo 'selected="selected"'; ?>>Jr.</option>
                                                    <option value="Sr." <?php if (isset($trimmed['suffix']) && $trimmed['suffix'] == 'Sr.') echo 'selected="selected"'; ?>>Sr.</option>
                                                    <option value="II" <?php if (isset($trimmed['suffix']) && $trimmed['suffix'] == 'II.') echo 'selected="selected"'; ?>>II</option>
                                                    <option value="III" <?php if (isset($trimmed['suffix']) && $trimmed['suffix'] == 'III.') echo 'selected="selected"'; ?>>III</option>
                                                    <option value="IV" <?php if (isset($trimmed['suffix']) && $trimmed['suffix'] == 'IV.') echo 'selected="selected"'; ?>>IV</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="email" class="form-label text-dark">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" autocomplete="email" value="<?php if (isset($_POST['email'])) echo htmlspecialchars($_POST['email'], ENT_QUOTES); ?>">
                                            </div>

                                            <div class="col-md-4">
                                                <label for="mobile_number" class="form-label text-dark">Mobile Number</label>
                                                <input type="text" class="form-control" id="mobile_number" name="mobile_number" placeholder="Enter Mobile No." autocomplete="mobile" value="<?php if (isset($_POST['mobile_number'])) echo htmlspecialchars($_POST['mobile_number'], ENT_QUOTES); ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-4">
                                                <label for=password1" class="form-label text-dark">Password</label>
                                                <input type="password" class="form-control" id="password1" name="password1" placeholder="Enter Password" value="<?php if (isset($_POST['password1'])) echo htmlspecialchars($_POST['password1'], ENT_QUOTES); ?>">
                                            </div>

                                            <div class="col-md-4">
                                                <label for=password2" class="form-label text-dark">Confirm Password</label>
                                                <input type="password" class="form-control" id="password2" name="password2" placeholder="Confirm Password" value="<?php if (isset($_POST['password2'])) echo htmlspecialchars($_POST['password2'], ENT_QUOTES); ?>">
                                            </div>

                                        </div>

                                        <div class="d-grid gap-2 col-8 mx-auto">
                                            <button type="submit" class="btn btn-primary">Add Admin</button>
                                        </div>
                                    </form>
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