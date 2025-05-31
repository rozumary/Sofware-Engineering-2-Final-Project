<?php 

include __DIR__ . '/functions.php';

set_config_inc();

display_header_inner();



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require(MYSQL);

    // Validate the email address:
    if (!empty($_POST['email'])) {
        $e = mysqli_real_escape_string($dbc, $_POST['email']);
    } else {
        $e = FALSE;
        // echo '<p class="error">You forgot to enter your email address!</p>';
        loginError('Please enter your email address!');
    }
    // Validate the password:
    if (!empty($_POST['pass'])) {
        $p = trim($_POST['pass']);
    } else {
        $p = FALSE;
        loginError('Please enter your password!');
        // echo '<p class="error">You forgot to enter your password!</p>';
    }

    if ($e && $p) { // If everything's OK.

        // Query the database:
        $q = "SELECT user_id, first_name, last_name, user_level, pass, role FROM users WHERE email='$e' AND active IS NULL";
        $r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($dbc));

        if (@mysqli_num_rows($r) == 1) { // A match was made.

            // Fetch the values:
            list($user_id, $first_name, $last_name, $user_level, $pass, $role) = mysqli_fetch_array($r, MYSQLI_NUM);
            mysqli_free_result($r);

            // Check the password:
            if (password_verify($p, $pass)) {

                // Store the info in the session:
                $_SESSION['user_id'] = $user_id;
                $_SESSION['first_name'] = $first_name;
                $_SESSION['last_name'] = $last_name;
                $_SESSION['email'] = $e;
                $_SESSION['user_level'] = $user_level;
                $_SESSION['role'] = $role;

                // Fetch the user's profile picture path and store it in the session
                // $q_profile = "SELECT profile_picture FROM users WHERE user_id = $user_id";
                // $r_profile = mysqli_query($dbc, $q_profile);
                // if ($r_profile && mysqli_num_rows($r_profile) > 0) { 
                //     $profile_data = mysqli_fetch_assoc($r_profile);
                //     $_SESSION['profile_picture'] = $profile_data['profile_picture'];
                // }

                // mysqli_free_result($r_profile);
                
                // Check user_level and redirect accordingly
                if ($user_level == 1) {
                    // Admin user, redirect to admin page
                    // header("Location: admin_dashboard.php");
                    // exit();
                    // loginSuccess("Log In Successfully", "admin_dashboard.php");
                    signedinSuccess("admin_dashboard.php");
                    exit();
                } else {
                    // Regular user, redirect to regular user page
                    // header("Location: user_dashboard.php");
                    // exit();
                    loginSuccess("Log In Successfully", BASE_URL . "user_dashboard.php");
                    exit();
                }
                mysqli_close($dbc);
                
                //Redirect the user:
                // $url = BASE_URL . 'user_dashboard.php'; // Define the URL.
                ob_end_clean(); // Delete the buffer.
                // header("Location: $url");
                // exit(); // Quit the script.
                exit();

            } else {
                // echo '<p class="error">Either the email address and password entered do not match those on file or you have not yet activated your account.</p>';
                loginErrorAlert("Your email or password is incorrect");
            }

        } else { // No match was made.
            // echo '<p class="error">Either the email address and password entered do not match those on file or you have not yet activated your account.</p>';
            loginErrorAlert("Your email or password is incorrect");
        }

    } //else { // If everything wasn't OK.
         // echo '<p class="error">Please try again.</p>';
    // }
    mysqli_close($dbc);

} // End of SUBMIT conditional.
?>


<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
        <div class="container">

            <ol>
                <li><a href="index.php">Home</a></li>
                <li>Login</li>
            </ol>
            <h2>Login</h2>
            

        </div>
    </section><!-- End Breadcrumbs -->

    <section class="inner-page">
        <div class="container" id="loginContainer">
        <div class="row">
            <div class="col-md-5 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h3>Login Form</h3>
                    </div>
                    <div class="card-body">
                        <form action="login.php" method="post">
                            <div class="form-group txt_field">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" autocomplete="email" value="<?php if (isset($_POST['email'])) echo htmlspecialchars($_POST['email'], ENT_QUOTES); ?>">
                            </div>
                            <div class="form-group txt_field">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                            <input type="password" name="pass" class="form-control" id="passwordInput" autocomplete="current-password" value="<?php if (isset($_POST['pass'])) echo htmlspecialchars($_POST['pass'], ENT_QUOTES); ?>">
                            </div>
                            <div class="form-group">
                                <a href="forgot_password.php">Forgot Password?</a>
                            </div><br />
                            <div class="d-grid gap-2 col-10 mx-auto">
                            <button type="submit" name="submit" class="btn btn-warning btn-lg">Login</button>
                            </div>
                            <div class="form-group signup_link"> <br />
                                Not a member yet? <a href="register_v3.php">Sign up</a>
                            </div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
        </div>
    </section><!-- End Inner Page Section -->
	</section>
	

</main><!-- End #main -->


<script>
document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordInput = document.getElementById('passwordInput');
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    this.textContent = type === 'password' ? 'Show' : 'Hide';
});
</script>

