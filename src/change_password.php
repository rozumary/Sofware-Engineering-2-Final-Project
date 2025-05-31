<?php

include __DIR__ . '/functions.php';

show_header();
display_navbar();
display_sidebar();
set_config_inc(); // Include database connection

$userLevel = $_SESSION['user_level'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  require(MYSQL);

  // Check for a new password and match against the confirmed password:
  $p = FALSE;
  if (strlen($_POST['password1']) >= 10 && isPasswordStrong(trim($_POST['password1']))) {
    if ($_POST['password1'] == $_POST['password2']) {
      $p = password_hash($_POST['password1'], PASSWORD_DEFAULT);
    } else {
      // echo '<p class="error">Your password did not match the confirmed password!</p>';
      error("Your password did not match the confirmed password!");
    }
  } else {
    // echo '<p class="error">Please enter a valid password!</p>';
    error("Please enter a valid password, Password should be at least 10 characters long and include uppercase, lowercase, digits, and special characters");
  }
    
  if ($p) { // If everything's OK.


    // Make the query:
    $q = "UPDATE users SET pass='$p' WHERE user_id={$_SESSION['user_id']} LIMIT 1";
    $r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br>MySQL Error: " . mysqli_error($dbc));
    if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

      // Send an email, if desired.
      // echo '<h3>Your password has been changed.</h3>';
      success("Your password has been changed", "change_password.php");
      mysqli_close($dbc); // Close the database connection.
      // include('includes/footer.html'); // Include the HTML footer.
      exit();
    } else { // If it did not run OK.

      //echo '<p class="error">Your password was not changed. Make sure your new password is different than the current password. Contact the system administrator if you think an error occurred.</p>';
      error("Your password was not changed. Make sure your new password is different than the current password. Contact the system administrator if you think an error occurred");
    }
  } else { // Failed the validation test.
    // echo '<p class="error">Please try again.</p>';
  }

  mysqli_close($dbc); // Close the database connection.

} // End of the main Submit conditional.





?>


<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">Change Password</h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href=<?php echo $userLevel == 1 ? 'admin_dashboard.php' : 'user_dashboard.php'; ?>>Dashboard</a></li>
          <li class="breadcrumb-item">Settings</li>
          <li class="breadcrumb-item active" aria-current="page">Change Password</li>
        </ol>
      </nav>
    </div>
    <div class="row">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Change your Password</h5>
                

                <p class="card-description"> Provide your new password below </p>

                <div class="container">
                  <div class="row">
                    <div class="col-md-7">
                      <form class="forms-sample" action="change_password.php" method="post" id="passwordChangeForm">
                        <div class="form-group row">
                          <label for="exampleInputPassword2" class="col-sm-3 col-form-label">New Password</label>
                          <div class="col-sm-9">
                            <div class="password-input-group">
                              <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password" name="password1" value="<?php if (isset($_POST['password1'])) echo htmlspecialchars($_POST['password1'], ENT_QUOTES); ?>">
                              <button type="button" id="showPasswordButton" class="btn btn-light"><i class="fa fa-eye"></i></button>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label">Confirm new Password</label>
                          <div class="col-sm-9">
                            <div class="password-input-group">
                              <input type="password" class="form-control" id="exampleInputConfirmPassword2" placeholder="Password" name="password2" value="<?php if (isset($_POST['password2'])) echo htmlspecialchars($_POST['password2'], ENT_QUOTES); ?>">
                              <button type="button" id="showConfirmPasswordButton" class="btn btn-light"><i class="fa fa-eye"></i></button>
                            </div>
                          </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-fw">Submit</button>
                      </form>
                    </div>

                  </div>
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