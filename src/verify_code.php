<?php

include __DIR__ . '/functions.php';

set_config_inc();
set_send_email();

display_header_inner();

$email = isset($_GET['email']) ? $_GET['email'] : '';
$codeError = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require(MYSQL);
    $email = mysqli_real_escape_string($dbc, $_POST['email']);
    $code = mysqli_real_escape_string($dbc, $_POST['code']);

    $q = "SELECT user_id FROM users WHERE email='$email' AND verification_code='$code' LIMIT 1";
    $r = mysqli_query($dbc, $q);

if (mysqli_num_rows($r) == 1) {
    // Activate the account
    $q2 = "UPDATE users SET verified=1, verification_code=NULL, active=NULL WHERE email='$email'";
    mysqli_query($dbc, $q2);

    echo '<script>
        Swal.fire({
            title: "Account Activated!",
            text: "Your account has been successfully activated. You may now log in.",
            icon: "success",
            confirmButtonText: "Go to Login"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "login.php";
            }
        });
    </script>';
    exit();
}
    } else {
        $codeError = "Invalid code. Please check your email and try again.";
    }

?>

<main id="main">
    <section class="inner-page">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h3>Email Verification</h3>
                        </div>
                        <div class="card-body">
                            <form method="post" action="verify_code.php">
                                <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                                <div class="mb-3">
                                    <label for="code" class="form-label">Enter the 6-digit code sent to your
                                        email:</label>
                                    <input type="text" class="form-control" id="code" name="code" maxlength="6"
                                        required>
                                    <span class="error"><?php echo $codeError; ?></span>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-warning">Verify</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>