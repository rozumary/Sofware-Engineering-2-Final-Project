<?php

include __DIR__ . '/functions.php';

show_header();
set_config_inc();

display_navbar();
display_sidebar();

$userLevel = $_SESSION['user_level'];

if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) : //From profile.php
    $id = $_GET['id'];
elseif ((isset($_POST['id'])) && (is_numeric($_POST['id']))) : // Form submission.
    $id = $_POST['id'];
else :
    oopsMsg('This page has been accessed in error.');
endif;

require(MYSQL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') :

    $errors = [];

    if (empty($_POST['first_name'])) :
        $errors['first_name'] = 'Please enter your first name.';
    else :
        $fn = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
    endif;

    $mn = mysqli_real_escape_string($dbc, trim($_POST['middle_name']));

    if (empty($_POST['last_name'])) :
        $errors['last_name'] = 'Please enter your last name.';
    else :
        $ln = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
    endif;

    $suffix = mysqli_real_escape_string($dbc, trim($_POST['suffix']));

    $alias = mysqli_real_escape_string($dbc, trim($_POST['alias']));

    if (empty($_POST['email'])) :
        $errors['email'] = 'Please enter your email address.';
    else :
        $e = mysqli_real_escape_string($dbc, trim($_POST['email']));
    endif;

    if (empty($_POST['mobile_number'])) :
        $errors['mobile_number'] = 'Please enter your Mobile Number.';
    elseif (!preg_match('/^(09|\+639)\d{9}$/', $_POST['mobile_number'])) :
        $errors['mobile_number'] = 'Invalid Mobile Number. Please use the format: 09xxxxxxxxx or +639xxxxxxxxx.';
    else :
        $mobile_number = mysqli_real_escape_string($dbc, trim($_POST['mobile_number']));
    endif;

    if (empty($_POST['dob'])) :
        $errors['dob'] = 'Please enter your Date of Birth.';
    else :
        $dob = $_POST['dob'];
        $minAge = 18;
        $today = new DateTime();
        $birthdate = new DateTime($dob);
        $age = $birthdate->diff($today)->y;

        if ($age < $minAge) :
            $errors['dob'] = 'You must be at least 18 years old';
        endif;
    endif;

    if (empty($_POST['gender'])) :
        $errors['gender'] = 'Please enter your gender.';
    else :
        $gender = mysqli_real_escape_string($dbc, trim($_POST['gender']));
    endif;

    $street = mysqli_real_escape_string($dbc, trim($_POST['street']));

    if (empty($_POST['barangay'])) :
        $errors['barangay'] = 'Please enter your barangay';
    else :
        $barangay = mysqli_real_escape_string($dbc, trim($_POST['barangay']));
    endif;

    $municipality = mysqli_real_escape_string($dbc, trim($_POST['municipality']));

    if (empty($_POST['info_stat'])) :
        $errors['info_stat'] = 'Please choose your stat';
    else :
        $info_stat = mysqli_real_escape_string($dbc, trim($_POST['info_stat']));
    endif;

    // if (empty($_POST['case_number'])) :
    //     $errors['case_number'] = 'Please enter your case number';
    // else :
    //     $case_number = mysqli_real_escape_string($dbc, trim($_POST['case_number']));
    // endif;


    if (empty($errors)) :

        $q = "SELECT id FROM clients WHERE email='$e' AND id != $id";
        $r = @mysqli_query($dbc, $q);
        if (mysqli_num_rows($r) == 0) :

            $q = "UPDATE clients SET first_name='$fn', middle_name='$mn', last_name='$ln', suffix='$suffix', email='$e', mobile_number='$mobile_number', 
            dob='$dob', gender='$gender', street='$street', barangay='$barangay', municipality='$municipality', info_stat='$info_stat' WHERE id=$id LIMIT 1";
            $r = @mysqli_query($dbc, $q);
            if (mysqli_affected_rows($dbc) == 1) :
                success("The client details has been edited.", "petitioners_list_v02.php");
            else :
                errorMsg("The client could not be edited due to a system error. We apologize for any inconvenience.", "petitioners_list_v02.php");
                exit();
            endif;

        else :
            $errors['email'] = 'The email address has already been registered.';
        endif;

    endif;

endif;

?>

<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Edit Client</h3>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href=<?php echo $userLevel == 1 ? 'admin_dashboard.php' : 'user_dashboard.php'; ?>>Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Client</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Edit Client Personal information</h5>

                                <div class="container">
                                    <div class="row">

                                        <?php
                                        // Always show the form...
                                        // Retrieve the user's information:
                                        $q = "SELECT first_name, middle_name, last_name, suffix, alias, email, mobile_number, dob, gender, street, barangay, municipality, info_stat FROM clients WHERE id=$id";
                                        $r = @mysqli_query($dbc, $q);

                                        if (mysqli_num_rows($r) == 1) :
                                            // Valid user ID, show the form.
                                            // Get the user's information:
                                            $row = mysqli_fetch_array($r, MYSQLI_NUM);
                                        ?>

                                            <div class="col-md-3">
                                                <form action="edit_petitioner.php" method="post">
                                                    <div class="mb-3">
                                                        <label for="first_name" class="form-label text-dark">First Name:</label>
                                                        <input type="text" class="form-control" id="first_name" name="first_name" maxlength="15" value="<?= $row[0] ?>">
                                                        <?php if (isset($errors['first_name'])) : ?>
                                                            <span class="text-danger"><?= $errors['first_name'] ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label for="middle_name" class="form-label text-dark">Middle Name:</label>
                                                    <input type="text" class="form-control" id="middle_name" name="middle_name" maxlength="15" value="<?= $row[1] ?>">
                                                    <?php if (isset($errors['middle_name'])) : ?>
                                                        <span class="text-danger"><?= $errors['middle_name'] ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label for="last_name" class="form-label text-dark">Last Name:</label>
                                                    <input type="text" class="form-control" id="last_name" name="last_name" maxlength="15" value="<?= $row[2] ?>">
                                                    <?php if (isset($errors['last_name'])) : ?>
                                                        <span class="text-danger"><?= $errors['last_name'] ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label for="suffix" class="form-label text-dark">Suffix:</label>
                                                    <select class="form-select" id="suffix" name="suffix">
                                                        <option value="" <?= ($row[3] == '' ? 'selected' : '') ?>>Select</option>
                                                        <option value="Jr." <?= ($row[3] == 'Jr.' ? 'selected' : '') ?>>Jr.</option>
                                                        <option value="Sr." <?= ($row[3] == 'Sr.' ? 'selected' : '') ?>>Sr.</option>
                                                        <option value="II" <?= ($row[3] == 'II' ? 'selected' : '') ?>>II</option>
                                                        <option value="III" <?= ($row[3] == 'III' ? 'selected' : '') ?>>III</option>
                                                        <option value="IV" <?= ($row[3] == 'IV' ? 'selected' : '') ?>>IV</option>
                                                    </select>
                                                </div>
                                            </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="alias" class="form-label text-dark">Alias:</label>
                                                <input type="text" class="form-control" id="alias" name="alias" value="<?= $row[4] ?>">
                                                <?php if (isset($errors['alias'])) : ?>
                                                    <span class="text-danger"><?= $errors['alias'] ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="email" class="form-label text-dark">Email Address:</label>
                                                <input type="email" class="form-control" id="email" name="email" maxlength="60" value="<?= $row[5] ?>" readonly>
                                                <?php if (isset($errors['email'])) : ?>
                                                    <span class="text-danger"><?= $errors['email'] ?></span>
                                                <?php else : ?>
                                                    <small class="text-info">This field can't be edited.</small>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="mobile_number" class="form-label text-dark">Mobile Number:</label>
                                                <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="<?= $row[6] ?>">
                                                <?php if (isset($errors['mobile_number'])) : ?>
                                                    <span class="text-danger"><?= $errors['mobile_number'] ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="dob" class="form-label text-dark">Date of Birth:</label>
                                                <input type="date" class="form-control" id="dob" name="dob" max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>" value="<?= $row[7] ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="gender" class="form-label text-dark">Gender:</label>
                                                <div class="col">
                                                    <input class="form-check-input" type="radio" id="male" name="gender" value="Male" <?php echo ($row[8] == 'Male' ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="male">Male</label>
                                                    <input class="form-check-input" type="radio" id="female" name="gender" value="Female" <?php echo ($row[8] == 'Female' ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="female">Female</label>
                                                </div>
                                                <?php if (isset($errors['gender'])) : ?>
                                                    <span class="text-danger"><?= $errors['gender'] ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="street" class="form-label text-dark">Street:</label>
                                                <input type="text" class="form-control" id="street" name="street" value="<?= $row[9] ?>">
                                                <?php if (isset($errors['street'])) : ?>
                                                    <span class="text-danger"><?= $errors['street'] ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="barangay" class="form-label text-dark">Barangay:</label>
                                                <input type="text" class="form-control" id="barangay" name="barangay" value="<?= $row[10] ?>">
                                                <?php if (isset($errors['barangay'])) : ?>
                                                    <span class="text-danger"><?= $errors['barangay'] ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="municipality" class="form-label text-dark">Municipality:</label>
                                                <select name="municipality" id="municipality" class="form-select">
                                                    <option value="Cavinti" <?php echo ($row[11] == 'Cavinti' ? 'selected' : ''); ?>>Cavinti</option>
                                                    <option value="Famy" <?php echo ($row[11] == 'Famy' ? 'selected' : ''); ?>>Famy</option>
                                                    <option value="Kalayaan" <?php echo ($row[11] == 'Kalayaan' ? 'selected' : ''); ?>>Kalayaan</option>
                                                    <option value="Lumban" <?php echo ($row[11] == 'Lumban' ? 'selected' : ''); ?>>Lumban</option>
                                                    <option value="Liliw" <?php echo ($row[11] == 'Liliw' ? 'selected' : ''); ?>>Liliw</option>
                                                    <option value="Luisiana" <?php echo ($row[11] == 'Luisiana' ? 'selected' : ''); ?>>Luisina</option>
                                                    <option value="Mabitac" <?php echo ($row[11] == 'Mabitac' ? 'selected' : ''); ?>>Mabitac</option>
                                                    <option value="Magdalena" <?php echo ($row[11] == 'Magdalena' ? 'selected' : ''); ?>>Magdalena</option>
                                                    <option value="Majayjay" <?php echo ($row[11] == 'Majayjay' ? 'selected' : ''); ?>>Majayjay</option>
                                                    <option value="Paete" <?php echo ($row[11] == 'Paete' ? 'selected' : ''); ?>>Paete</option>
                                                    <option value="Pagsanjan" <?php echo ($row[11] == 'Pagsanjan' ? 'selected' : ''); ?>>Pagsanjan</option>
                                                    <option value="Pakil" <?php echo ($row[11] == 'Pakil' ? 'selected' : ''); ?>>Pakil</option>
                                                    <option value="Pangil" <?php echo ($row[11] == 'Pangil' ? 'selected' : ''); ?>>Pangil</option>
                                                    <option value="Pila" <?php echo ($row[11] == 'Pila' ? 'selected' : ''); ?>>Pila</option>
                                                    <option value="Sta.Cruz" <?php echo ($row[11] == 'Sta.Cruz' ? 'selected' : ''); ?>>Sta.Cruz</option>
                                                    <option value="Sta.Maria" <?php echo ($row[11] == 'Sta.Maria' ? 'selected' : ''); ?>>Sta.Maria</option>
                                                    <option value="Siniloan" <?php echo ($row[11] == 'Siniloan' ? 'selected' : ''); ?>>Siniloan</option>
                                                    <option value="Victoria" <?php echo ($row[11] == 'Victoria' ? 'selected' : ''); ?>>Victoria</option>
                                                </select>
                                                <?php if (isset($errors['municipality'])) : ?>
                                                    <span class="text-danger"><?= $errors['municipality'] ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="info_stat" class="form-label text-dark">Choose:</label>
                                                <div class="col">
                                                    <input class="form-check-input" type="radio" id="pdl" name="info_stat" value="PDL" <?php echo ($row[12] == 'PDL' ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="pdl">PDL</label>
                                                    <input class="form-check-input" type="radio" id="bailed" name="info_stat" value="BAILED" <?php echo ($row[12] == 'BAILED' ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="bailed">BAILED</label>
                                                </div>
                                                <?php if (isset($errors['info_stat'])) : ?>
                                                    <span class="text-danger"><?= $errors['info_stat'] ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <input type="submit" class="btn btn-primary btn-fw" name="submit" value="Submit">
                                    </div>
                                    <input type="hidden" name="id" value="<?= $id ?>">
                                    </form>
                                </div>

                            <?php
                                        else :
                                            // Not a valid user ID.
                                            echo '<strong><p class="text-danger">This page has been accessed in error.</p></strong>';
                                        endif;

                                        mysqli_close($dbc);

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