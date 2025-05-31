<?php

include __DIR__ . '/functions.php';
include './includes/config.inc.php';

show_header();
display_navbar();
display_sidebar();


$userLevel = $_SESSION['user_level'];

// Initialize an array to store validation errors
$errors = [];

// Trim all the incoming data:
$expected_fields = ['first_name', 'middle_name', 'last_name', 'suffix', 'alias', 'street', 'barangay', 'municipality', 'officers', 'email', 'mobile_number', 'dob', 'case_number', 'gender', 'info_stat'];
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

    // Validate for alias
    if (empty($_POST['alias'])) {
        $errors[] = 'Please enter your Alias';
    } else {
        $alias = trim($_POST['alias']);
    }

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

    // Validate Date of Birth
    if (empty($_POST['dob'])) {
        $errors[] = 'Please enter your Date of Birth.';
    } else {
        $dob = $_POST['dob'];
        $minAge = 18;
        $today = new DateTime();
        $birthdate = new DateTime($dob);
        $age = $birthdate->diff($today)->y;

        if ($age < $minAge) {
            $errors[] = 'You must be at least 18 years old to register.';
        }
    }

    // Validate Gender
    if (empty($_POST['gender'])) {
        $errors[] = 'Please select your Gender.';
    } else {
        $gender = $_POST['gender'];
    }

    //Validate case number
    if (empty($_POST['case_number'])) {
        $errors[] = 'Please enter a Case Number.';
    } else {
        $case_number = trim($_POST['case_number']);

        // Check if the case number is already registered
        $check_case_query = "SELECT COUNT(*) FROM clients WHERE case_number = :case_number";
        $check_case_stmt = $pdo->prepare($check_case_query);
        $check_case_stmt->bindParam(':case_number', $case_number);
        $check_case_stmt->execute();
        $case_number_exists = $check_case_stmt->fetchColumn();

        if ($case_number_exists) {
            $errors[] = 'Case number is already registered. Please use a different case number.';
        }
    }


    // Validate Street
    $street = trim($_POST['street']);

    // Validate Barangay
    if (empty($_POST['barangay'])) {
        $errors[] = 'Please enter your Barangay';
    } else {
        $barangay = trim($_POST['barangay']);
    }

    // Validate Municipality
    $municipality = $_POST['municipality'];

    // Validate Information Status
    if (empty($_POST['info_stat'])) {
        $errors[] = 'Please choose your Information Status.';
    } else {
        $info_stat = $_POST['info_stat'];
    }

    // Validate Officers
    if (empty($_POST['officers'])) {
        $errors[] = 'Please select a Parole Officer.';
    } else {
        $officers = trim($_POST['officers']);
    }

    // If there are no errors, you can proceed
    if (empty($errors)) {
        try {

            // Check if the email is already registered
            $check_query = "SELECT COUNT(*) FROM clients WHERE email = :email";
            $check_stmt = $pdo->prepare($check_query);
            $check_stmt->bindParam(':email', $email);
            $check_stmt->execute();
            $email_exists = $check_stmt->fetchColumn();

            if ($email_exists) {
                $errors[] = 'Email address is already registered. Please use a different email.';
            } else {

                $default_status = NULL;
                // $default_status = NULL;
                // $status_value = $status ?? $default_status;
                $status_value = $default_status;

                // Prepare the SQL query
                $insert_query = "INSERT INTO clients (first_name, middle_name, last_name, suffix, alias, email, mobile_number, dob, gender, street, barangay, municipality, officers, info_stat, case_number, status, registration_date)
                VALUES (:first_name, :middle_name, :last_name, :suffix, :alias, :email, :mobile_number, :dob, :gender, :street, :barangay, :municipality, :officers, :info_stat, :case_number, :status, NOW())";
                $insert_stmt = $pdo->prepare($insert_query);

                // Bind parameters to the prepared statement
                $insert_stmt->bindParam(':first_name', $first_name);
                $insert_stmt->bindParam(':middle_name', $middle_name);
                $insert_stmt->bindParam(':last_name', $last_name);
                $insert_stmt->bindParam(':suffix', $suffix);
                $insert_stmt->bindParam(':alias', $alias);
                $insert_stmt->bindParam(':email', $email);
                $insert_stmt->bindParam(':mobile_number', $mobile_number);
                $insert_stmt->bindParam(':dob', $dob);
                $insert_stmt->bindParam(':gender', $gender);
                $insert_stmt->bindParam(':street', $street);
                $insert_stmt->bindParam(':barangay', $barangay);
                $insert_stmt->bindParam(':municipality', $municipality);
                $insert_stmt->bindParam(':officers', $officers);
                $insert_stmt->bindParam(':info_stat', $info_stat);
                $insert_stmt->bindParam(':case_number', $case_number);
                $insert_stmt->bindParam(':status', $status_value, PDO::PARAM_STR); // Corrected line



                // Execute the prepared statement
                $insert_stmt->execute();

                // Redirect to a success page or perform any other actions after successful registration
                // header("Location: registration_success.php");
                success("Petitioner added successfully", "petitioners_list_v02.php");
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
            <h3 class="page-title">Add Petitioner</h3>
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
                                <h5 class="card-title">Add Petitioner</h5>

                                <div class="container">
                                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"
                                        class="needs-validation" novalidate autocomplete="off">

                                        <!-- Personal Information -->
                                        <div class="mb-3">
                                            <h6 class="card-subtitle mb-2 text-muted">Personal Information</h6>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="first_name" class="form-label text-dark">First Name</label>
                                                <input type="text" class="form-control" id="first_name"
                                                    name="first_name" placeholder="Enter first name" required
                                                    value="<?php echo isset($trimmed['first_name']) ? $trimmed['first_name'] : ''; ?>"
                                                    autocomplete="given-name">
                                                <div class="invalid-feedback">
                                                    Please enter a valid first name.
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="middle_name" class="form-label text-dark">Middle
                                                    Name</label>
                                                <input type="text" class="form-control" id="middle_name"
                                                    name="middle_name" placeholder="Enter middle name"
                                                    value="<?php echo isset($trimmed['middle_name']) ? $trimmed['middle_name'] : ''; ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="last_name" class="form-label text-dark">Last Name</label>
                                                <input type="text" class="form-control" id="last_name" name="last_name"
                                                    placeholder="Enter last name" required
                                                    value="<?php echo isset($trimmed['last_name']) ? $trimmed['last_name'] : ''; ?>"
                                                    autocomplete="family-name">
                                                <div class="invalid-feedback">
                                                    Please enter a valid last name.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-5">
                                                <label for="suffix" class="form-label text-dark">Suffix</label>
                                                <select class="form-select" id="suffix" name="suffix">
                                                    <option value="">Select</option>
                                                    <option value="Jr." <?php if (isset($trimmed['suffix']) && $trimmed['suffix'] == 'Jr.')
                                                        echo 'selected="selected"'; ?>>Jr.
                                                    </option>
                                                    <option value="Sr." <?php if (isset($trimmed['suffix']) && $trimmed['suffix'] == 'Sr.')
                                                        echo 'selected="selected"'; ?>>Sr.
                                                    </option>
                                                    <option value="II" <?php if (isset($trimmed['suffix']) && $trimmed['suffix'] == 'II.')
                                                        echo 'selected="selected"'; ?>>II
                                                    </option>
                                                    <option value="III" <?php if (isset($trimmed['suffix']) && $trimmed['suffix'] == 'III.')
                                                        echo 'selected="selected"'; ?>>III
                                                    </option>
                                                    <option value="IV" <?php if (isset($trimmed['suffix']) && $trimmed['suffix'] == 'IV.')
                                                        echo 'selected="selected"'; ?>>IV
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-5">
                                                <label for="alias" class="form-label text-dark">Alias</label>
                                                <input type="text" class="form-control" id="alias" name="alias"
                                                    placeholder="Enter alias"
                                                    value="<?php echo isset($trimmed['alias']) ? $trimmed['alias'] : ''; ?>">
                                            </div>
                                        </div>

                                        <!-- Address -->
                                        <div class="mb-3">
                                            <h6 class="card-subtitle mb-2 text-muted text-dark">Address</h6>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="street" class="form-label text-dark">Street</label>
                                                <input type="text" class="form-control" id="street" name="street"
                                                    placeholder="Enter street"
                                                    value="<?php echo isset($trimmed['street']) ? $trimmed['street'] : ''; ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="barangay" class="form-label text-dark">Barangay</label>
                                                <input type="text" class="form-control" id="barangay" name="barangay"
                                                    placeholder="Enter barangay"
                                                    value="<?php echo isset($trimmed['barangay']) ? $trimmed['barangay'] : ''; ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="municipality"
                                                    class="form-label text-dark">Municipality</label>
                                                <select class="form-select" id="municipality" name="municipality">
                                                    <option value="" selected disabled>Select Municipality</option>
                                                    <option value="Cavinti" <?php if (isset($trimmed['municipality']) && $trimmed['municipality'] == 'Cavinti')
                                                        echo 'selected="selected"'; ?>>Cavinti</option>
                                                    <option value="Calauan" <?php if (isset($trimmed['municipality']) && $trimmed['municipality'] == 'Calauan')
                                                        echo 'selected="selected"'; ?>>Calauan</option>
                                                    <option value="Famy" <?php if (isset($trimmed['municipality']) && $trimmed['municipality'] == 'Famy')
                                                        echo 'selected="selected"'; ?>>Famy</option>
                                                    <option value="Kalayaan" <?php if (isset($trimmed['municipality']) && $trimmed['municipality'] == 'Kalayaan')
                                                        echo 'selected="selected"'; ?>>Kalayaan</option>
                                                    <option value="Lumban" <?php if (isset($trimmed['municipality']) && $trimmed['municipality'] == 'Lumban')
                                                        echo 'selected="selected"'; ?>>Lumban</option>
                                                    <option value="Liliw" <?php if (isset($trimmed['municipality']) && $trimmed['municipality'] == 'Liliw')
                                                        echo 'selected="selected"'; ?>>Liliw</option>
                                                    <option value="Luisiana" <?php if (isset($trimmed['municipality']) && $trimmed['municipality'] == 'Luisiana')
                                                        echo 'selected="selected"'; ?>>Luisiana</option>
                                                    <option value="Mabitac" <?php if (isset($trimmed['municipality']) && $trimmed['municipality'] == 'Mabitac')
                                                        echo 'selected="selected"'; ?>>Mabitac</option>
                                                    <option value="Magdalena" <?php if (isset($trimmed['municipality']) && $trimmed['municipality'] == 'Magdalena')
                                                        echo 'selected="selected"'; ?>>Magdalena</option>
                                                    <option value="Majayjay" <?php if (isset($trimmed['municipality']) && $trimmed['municipality'] == 'Majayjay')
                                                        echo 'selected="selected"'; ?>>Majayjay</option>
                                                    <option value="Paete" <?php if (isset($trimmed['municipality']) && $trimmed['municipality'] == 'Paete')
                                                        echo 'selected="selected"'; ?>>Paete</option>
                                                    <option value="Pagsanjan" <?php if (isset($trimmed['municipality']) && $trimmed['municipality'] == 'Pagsanjan')
                                                        echo 'selected="selected"'; ?>>Pagsanjan</option>
                                                    <option value="Pakil" <?php if (isset($trimmed['municipality']) && $trimmed['municipality'] == 'Pakil')
                                                        echo 'selected="selected"'; ?>>Pakil</option>
                                                    <option value="Pangil" <?php if (isset($trimmed['municipality']) && $trimmed['municipality'] == 'Pangil')
                                                        echo 'selected="selected"'; ?>>Pangil</option>
                                                    <option value="Pila" <?php if (isset($trimmed['municipality']) && $trimmed['municipality'] == 'Pila')
                                                        echo 'selected="selected"'; ?>>Pila</option>
                                                    <option value="Sta.Cruz" <?php if (isset($trimmed['municipality']) && $trimmed['municipality'] == 'Sta.Cruz')
                                                        echo 'selected="selected"'; ?>>Sta.Cruz</option>
                                                    <option value="Sta.Maria" <?php if (isset($trimmed['municipality']) && $trimmed['municipality'] == 'Sta.Maria')
                                                        echo 'selected="selected"'; ?>>Sta.Maria</option>
                                                    <option value="Siniloan" <?php if (isset($trimmed['municipality']) && $trimmed['municipality'] == 'Siniloan')
                                                        echo 'selected="selected"'; ?>>Siniloan</option>
                                                    <option value="Victoria" <?php if (isset($trimmed['municipality']) && $trimmed['municipality'] == 'Victoria')
                                                        echo 'selected="selected"'; ?>>Victoria</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label text-dark">Assigned Parole Officer</label>
                                                <!-- Show the officer name (readonly for display) -->
                                                <input type="text" class="form-control" id="officer_name"
                                                    name="officer_name" value="" readonly>
                                                <!-- Hidden input for the actual officer value to submit -->
                                                <input type="hidden" id="officers" name="officers" value="">
                                            </div>
                                            <!-- Additional Information -->
                                            <div class="mb-3">
                                                <h6 class="card-subtitle mb-2 text-muted">Additional Information</h6>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-5">
                                                    <label for="email" class="form-label text-dark">Email
                                                        Address</label>
                                                    <input type="email" class="form-control" id="email" name="email"
                                                        placeholder="Enter email address"
                                                        value="<?php echo isset($trimmed['email']) ? $trimmed['email'] : ''; ?>"
                                                        autocomplete="email">
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="mobile_number" class="form-label text-dark">Mobile
                                                        Number</label>
                                                    <input type="text" class="form-control" id="mobile_number"
                                                        name="mobile_number" placeholder="Enter mobile number"
                                                        value="<?php echo isset($trimmed['mobile_number']) ? $trimmed['mobile_number'] : ''; ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <label for="dob" class="form-label text-dark">Date of Birth</label>
                                                    <input type="date" class="form-control" id="dob" name="dob"
                                                        max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>"
                                                        value="<?php if (isset($trimmed['dob']))
                                                            echo $trimmed['dob']; ?>">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="caseNumber" class="form-label text-dark">Case
                                                        Number:</label>
                                                    <input type="text" class="form-control" name="case_number"
                                                        id="caseNumber" placeholder="enter case number" value="<?php if (isset($trimmed['case_number']))
                                                            echo $trimmed['case_number']; ?>">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="male" class="form-label text-dark">Gender: </label>
                                                    <div class="col">
                                                        <input class="form-check-input" type="radio" name="gender"
                                                            id="male" value="Male" <?php if (isset($trimmed['gender']) && $trimmed['gender'] == 'Male')
                                                                echo 'checked="checked"'; ?>>
                                                        Male
                                                        <input class="form-check-input" type="radio" name="gender"
                                                            id="female" value="Female" <?php if (isset($trimmed['gender']) && $trimmed['gender'] == 'Female')
                                                                echo 'checked="checked"'; ?> required> Female
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="pdl" class="form-label text-dark">Choose: </label>
                                                    <div class="col">
                                                        <input class="form-check-input" type="radio" name="info_stat"
                                                            id="pdl" value="PDL" <?php if (isset($trimmed['info_stat']) && $trimmed['info_stat'] == 'PDL')
                                                                echo 'checked="checked"'; ?>> PDL
                                                        <input class="form-check-input" type="radio" name="info_stat"
                                                            id="bailed" value="BAILED" <?php if (isset($trimmed['info_stat']) && $trimmed['info_stat'] == 'BAILED')
                                                                echo 'checked="checked"'; ?>> BAILED
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Add more form fields as needed -->
                                            <div class="d-grid gap-2 col-8 mx-auto">
                                                <button type="submit" class="btn btn-primary">Add Petitioner</button>
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


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function updateOfficerName() {
                const municipality = document.getElementById('municipality').value;
                if (municipality) {
                    fetch(`get_officer_by_area.php?municipality=${encodeURIComponent(municipality)}`)
                        .then(response => response.text())
                        .then(data => {
                            document.getElementById('officer_name').value = data;
                            document.getElementById('officers').value = data; // Set hidden input for form submission
                        });
                } else {
                    document.getElementById('officer_name').value = '';
                    document.getElementById('officers').value = '';
                }
            }

            document.getElementById('municipality').addEventListener('change', updateOfficerName);

            // Optionally, call once on page load if values are pre-filled
            updateOfficerName();
        });
    </script>

    <?php show_footer(); ?>