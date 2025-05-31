<?php

include __DIR__ . '/functions.php';

display_header_inner();

set_config_inc();
set_send_email();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require(MYSQL);

	// Assume nothing:
	$uid = FALSE;

	// Validate the email address...
	if (!empty($_POST['email'])) {

		// Check for the existence of that email address...
		$q = 'SELECT user_id FROM users WHERE email="'.  mysqli_real_escape_string($dbc, $_POST['email']) . '"';
		$r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($dbc));

		if (mysqli_num_rows($r) == 1) { // Retrieve the user ID:
			list($uid) = mysqli_fetch_array($r, MYSQLI_NUM);
		} else { // No database match made.
            error("The email address does not match those on file!");
			// echo '<p class="error">The submitted email address does not match those on file!</p>';
		}

	} else { // No email!
        error("Please enter a valid email address");
		// echo '<p class="error">You forgot to enter your email address!</p>';
	} // End of empty($_POST['email']) IF.

	if ($uid) { // If everything's OK.

		// Create a new, random password:
		$p = bin2hex(random_bytes(10)); // Generate a random 20-char password 
		$ph = password_hash($p, PASSWORD_DEFAULT);

		// Update the database:
		$q = "UPDATE users SET pass='$ph' WHERE user_id=$uid LIMIT 1";
		$r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($dbc));

		if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

			// Send an email:
            // Define the subject and body of the email
			$subject = 'Your temporary password.';
            $body = "Your password to log in our website has been temporarily changed to '$p'. Please log in using this password and this email address. Then you may change your password to something more familiar.";

            // Use he send_email function to send the email.
            send_email($_POST['email'], $subject, $body);

			// Print a message and wrap up:
            success("Your password has been changed. You will receive the new, temporary password at the email address with which you registered. Once you have logged in with this password, you may change it by clicking on the 'Change Password' link.", "login.php");
			// echo '<h3>Your password has been changed. You will receive the new, temporary password at the email address with which you registered. Once you have logged in with this password, you may change it by clicking on the "Change Password" link.</h3>';
			mysqli_close($dbc);
			// include __DIR__ . '/includes/footer.php';
			exit(); // Stop the script.

		} else { // If it did not run OK.
            error('Your password could not be changed due to a system error. We apologize for any inconvenience.');
			// echo '<p class="error">Your password could not be changed due to a system error. We apologize for any inconvenience.</p>';
		}

	} else { // Failed the validation test.
		// echo '<p class="error">Please try again.</p>';
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
			<li>Forgot Password</li>
		</ol>
		<h2>Forgot Password</h2>
		

	</div>
</section><!-- End Breadcrumbs -->

<section class="inner-page">
	<div class="container">
	<div class="row">
            <div class="col-md-5 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h3>Reset Your Password</h3>
                    </div>
                    <div class="card-body">
                        <form action="forgot_password.php" method="post">
                            <div class="form-group txt_field">
                                <p>Enter your email address below and we will send the you a code to reset your password.</p>
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="email@example.com" value="<?php if (isset($_POST['email'])) echo htmlspecialchars($_POST['email'], ENT_QUOTES); ?>">
                            </div> <br />
                            
                            <div class="d-grid gap-2 col-10 mx-auto">
                                <button type="submit" name="submit" class="btn btn-primary btn-lg">Reset My Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

	</div>
	</section>

</main><!-- End #main -->







<?php display_footer(); ?>