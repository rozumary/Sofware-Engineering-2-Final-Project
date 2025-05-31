<?php

include __DIR__ . '/functions.php';

set_config_inc();
set_send_email();

display_header_inner();




// infoMessage("Please put all information of the applicant who'll apply for probation because he's/she's the one who'll use this once his/her application for probation is approved");
// infoMessage("Make sure that you'll register here is the one who will be applying for probation, if the applicant is still in jail/prison, a relative, officer can create his/her account just make sure to provide his/her real information like name, lastname etc. for faster verification of account.");

$fn_Error =
	$mn_Error =
	$ln_Error =
	$try_Error =
	$email_Error =
	$mobile_Error=
	$pass1_Error =
	$pass2_Error =
	$system_Error =
	$email_Exist_Error =
	$contact_Error = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Handle the form.

	// Need the database connection:
	require(MYSQL);

	// Trim all the incoming data:
	$trimmed = array_map('trim', $_POST);

	// Assume invalid values:
	$fn = $mn = $ln = $e = $p = $suffix = FALSE;
	// $fn = $ln = $e = <$ class="math-inline">p \= FALSE;

	// Check for a first name:
	if (preg_match('/^[A-Z \'.-]{2,20}$/i', $trimmed['first_name'])) {
		$fn = mysqli_real_escape_string($dbc, $trimmed['first_name']);
	} else {
		$fn_Error = 'Please enter your first name!';
	}

	// Check for a middle name:
	if (!empty($trimmed['middle_name'])) {
		if (preg_match('/^[A-Z \'.-]{2,20}$/i', $trimmed['middle_name'])) {
			$mn = mysqli_real_escape_string($dbc, $trimmed['middle_name'][0]); // Extract the first initial
		} else {
			$mn_Error = 'Please enter a valid middle name!';
		}
	} else {
		$mn = ''; // Set middle initial to empty if not provided
	}


	// Check for a last name:
	if (preg_match('/^[A-Z \'.-]{2,40}$/i', $trimmed['last_name'])) {
		$ln = mysqli_real_escape_string($dbc, $trimmed['last_name']);
	} else {
		$ln_Error = 'Please enter your last name!';
	}

	//suffix can be empty:
	$suffix = isset($_POST['suffix']) ? mysqli_real_escape_string($dbc, $_POST['suffix']) : null;

	// Check for an email address:
	if (filter_var($trimmed['email'], FILTER_VALIDATE_EMAIL)) {
		$e = mysqli_real_escape_string($dbc, $trimmed['email']);
	} else {
		$email_Error = 'Please enter a valid email address';
	}

	// Check for a password and match against the confirmed password:
	if (strlen($trimmed['password1']) >= 10 && isPasswordStrong($trimmed['password1'])) {
		if ($trimmed['password1'] == $trimmed['password2']) {
			$p = password_hash($trimmed['password1'], PASSWORD_DEFAULT);
		} else {
			$pass2_Error = 'Your password did not match the confirmed password!';
		}
	} else {
		$pass1_Error = 'Please enter a valid password, Password should be at least 10 characters long and include uppercase, lowercase, digits, and special characters';
	}

	// Check contact number
	if (validatePhoneNumber($trimmed['mobile_number'])) {
		$mobile_number = mysqli_real_escape_string($dbc, $trimmed['mobile_number']);
	} else {
		$mobile_Error = 'Please enter valid number';
	}



if ($fn && $ln && $e && $p && $mobile_number) { // If everything's OK...

    // Make sure the email address is available:
    $q = "SELECT user_id FROM users WHERE email='$e'";
    $r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($dbc));

    if (mysqli_num_rows($r) == 0) { // Available.

        // Create the activation code (for legacy, but not used for code entry)
        $a = md5(uniqid(rand(), true));

        // Generate a 6-digit verification code
        $verification_code = rand(100000, 999999);

        // Add the user to the database:
        $q = "INSERT INTO users (email, pass, first_name, middle_name, last_name, suffix, mobile_number, active, verification_code, registration_date) VALUES ('$e', '$p', '$fn', '$mn', '$ln', ";
        if ($suffix === null) {
            $q .= "NULL";
        } else {
            $q .= "'$suffix'";
        }
        $q .= ", '$mobile_number', '$a', '$verification_code', NOW() )";
        
        $r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($dbc));

        if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

            // Send the verification code to the user's email
            $subject = 'Your Account Verification Code';
            $body = "Thank you " . ucfirst($fn) . ", for registering.<br>
            To activate your account, please enter this code on the website:<br><br>
            <b style='font-size:1.5em;'>$verification_code</b>";

            send_email($_POST['email'], $subject, $body);

            // Redirect to code verification page
            header("Location: verify_code.php?email=" . urlencode($e));
            exit();

        } else { // If it did not run OK.
            $system_Error = 'You could not be registered due to a system error. We apologize for any inconvenience.';
        }
    } else { // The email address is not available.
        $email_Exist_Error = 'That email address has already been registered!';
    }
} else { // If one of the data tests failed.
    $try_Error = 'Please fix the item(s) indicated. Please try again.';
}

	mysqli_close($dbc);
} // End of the main Submit conditional.

?>

<main id="main">

	<!-- ======= Breadcrumbs ======= -->
	<section id="breadcrumbs" class="breadcrumbs">
		<div class="container">

			<ol>
				<li><a href="index.php">Home</a></li>
				<li>Register</li>
			</ol>
			<h2>Register</h2>


		</div>
	</section><!-- End Breadcrumbs -->

	<section class="inner-page">
		<div class="container">
			<div class="row">
				<div class="col-md-8 mx-auto">
					<div class="card">
						<div class="card-header">
							<h3>Registration Form</h3>
						</div>
						<div class="card-body">
							<span class="error" style="font-weight: bolder;"><b><?php echo $try_Error; ?></b></span>
							<span class="error"> <?php echo $system_Error; ?></span>
							<form action="register_v3.php" method="post" id="registrationForm">
								<div class="mb-3 row">
									<div class="col-md-3">
										<label for="firstName" class="form-label">First Name <span class="error"><?php echo $fn_Error; ?></span></label>
										<input type="text" class="form-control" id="firstName" name="first_name" placeholder="E.G. PETER" value="<?php if (isset($_POST['first_name'])) echo htmlspecialchars($_POST['first_name'], ENT_QUOTES); ?>">
									</div>
									<div class="col-md-3">
										<label for="middleName" class="form-label">Middle Name <span class="error"><?php echo $mn_Error; ?></span></label>
										<input type="text" class="form-control" id="middleName" name="middle_name" placeholder="E.G. POUND" value="<?php if (isset($_POST['middle_name'])) echo htmlspecialchars($_POST['middle_name'], ENT_QUOTES); ?>">
									</div>
									<div class="col-md-3">
										<label for="lastName" class="form-label">Last Name <span class="error"><?php echo $ln_Error; ?></span></label>
										<input type="text" class="form-control" id="lastName" name="last_name" placeholder="E.G. PARKER" value="<?php if (isset($_POST['last_name'])) echo htmlspecialchars($_POST['last_name'], ENT_QUOTES); ?>">
									</div>
									<div class="col-md-3">
										<label for="suffix" class="form-label">Suffix </label>
											<select name="suffix" class="form-control form-select" id="Suffix">
												<option value="">Select</option>
												<option value="Jr."	<?php if (isset($trimmed['suffix']) && $trimmed['suffix'] == 'Jr.') echo 'selected="selected"'; ?>>Jr.</option>
												<option value="Sr." <?php if (isset($trimmed['suffix']) && $trimmed['suffix'] == 'Sr.') echo 'selected="selected"'; ?>>Sr.</option>
												<option value="II" 	<?php if (isset($trimmed['suffix']) && $trimmed['suffix'] == 'II.') echo 'selected="selected"'; ?>>II</option>
												<option value="III" <?php if (isset($trimmed['suffix']) && $trimmed['suffix'] == 'III.') echo 'selected="selected"'; ?>>III</option>
												<option value="IV" 	<?php if (isset($trimmed['suffix']) && $trimmed['suffix'] == 'IV.') echo 'selected="selected"'; ?>>IV</option>
											</select>
									</div>
								</div>
								<div class="mb-3 row">
									<div class="col-md-5">
										<label for="email" class="form-label">Email<span class="error"> <?php echo $email_Error; ?></span><span class="error"> <?php echo $email_Exist_Error; ?></span></label>
										<input type="email" class="form-control" id="email" name="email" placeholder="email@example.com" value="<?php if (isset($_POST['email'])) echo htmlspecialchars($_POST['email'], ENT_QUOTES); ?>">
									</div>
									<div class="col-md-5">
										<label for="mobileNumber" class="form-label">Mobile No.<span class="error"> <?php echo $mobile_Error; ?></span></label>
										<input type="text" class="form-control" name="mobile_number" id="mobileNumber" value="<?php if (isset($_POST['mobile_number'])) echo htmlspecialchars($_POST['mobile_number'], ENT_QUOTES); ?>">
									</div>
								</div>
								<div class="mb-3 row">
									<div class="col-md-5">
										<label for="password" class="form-label">Password<span class="error"> <?php echo $pass1_Error; ?></span></label>
										<input type="password" class="form-control" id="password" name="password1" placeholder="Enter your password here" value="<?php if (isset($_POST['password1'])) echo htmlspecialchars($_POST['password1'], ENT_QUOTES); ?>">
									</div>
									<div class="col-md-5">
										<label for="confirmPassword" class="form-label">Confirm Password<span class="error"> <?php echo $pass2_Error; ?></span></label>
										<input type="password" class="form-control" id="confirmPassword" name="password2" placeholder="Confirm password here" value="<?php if (isset($_POST['password2'])) echo htmlspecialchars($_POST['password2'], ENT_QUOTES); ?>">
									</div>

								</div>
								<div class="d-grid gap-2 col-8 mx-auto">
									<button type="submit" name="submit" class="btn btn-warning btn-lg">Register</button>
								</div>
								<div class="form-group text">
									<br />
									<h5>Already have an account? <a href="login.php">Login now</a></h5>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	
<?php display_footer(); ?>

</main><!-- End #main -->


