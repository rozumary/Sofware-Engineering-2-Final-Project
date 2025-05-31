<?php
// This page activates the user's account.

require 'includes/config.inc.php';
include 'includes/header.php';


$subject = 'Activation Code';
$body = "Thank you " . ucfirst($fn) . ", for registering.<br /> 
To activate your account, please click on this link:<br /><br /> 
<a href='$activationLink'>$activationLink</a>";

// Send the email
send_email($_POST['email'], $subject, $body);

// If $x and $y don't exist or aren't of the proper format, redirect the user:
if (isset($_GET['x'], $_GET['y'])
	&& filter_var($_GET['x'], FILTER_VALIDATE_EMAIL)
	&& (strlen($_GET['y']) == 32 )
	) {

	// Update the database...
	require(MYSQL);
	$q = "UPDATE users SET verified=1, active=NULL WHERE (email='" . mysqli_real_escape_string($dbc, $_GET['x']) . "' AND active='" . mysqli_real_escape_string($dbc, $_GET['y']) . "') LIMIT 1";
	$r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($dbc));

	// Print a customized message:
	if (mysqli_affected_rows($dbc) == 1) {
		// echo "<h5>Your account is now active. You may now log in.</h5>";
        ?>
        <script>
			Swal.fire({
        title: "Account Activated!",
        text: "Your account has been successfully activated. You may now log in.",
        icon: 'success',
        confirmButtonText: "Go to Login",
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "login.php";
        }
    });
        </script>
        <?php
	} else {
		echo '<p class="error">Your account could not be activated. Please re-check the link or contact the system administrator.</p>';
	}

	mysqli_close($dbc);

} else { // Redirect.

	$url = BASE_URL . 'login.php'; // Define the URL.
	ob_end_clean(); // Delete the buffer.
	header("Location: $url");
	exit(); // Quit the script.

} // End of main IF-ELSE.

// include 'includes/footer.php';
?>