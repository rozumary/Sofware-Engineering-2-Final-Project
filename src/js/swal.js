// Import SweetAlert2
// import Swal from 'sweetalert2';

function swalFireConfirmationMessage(){ 
    Swal.fire({
        // title: "Registration Successful, " + firstName + "!",
        title: "Registration Successful!",
        text: "You have successfully registered for an account. Please check your email to activate your account.",
        icon: 'success',
        confirmButtonText: "Homepage",
        cancelButtonText: "Go to Login Page",
        showCancelButton: true
    }).then((result) => {
    if (result.isConfirmed) {
      // Keep the user on the registration page.
    window.location.href = "index.php";
    } else {
      // Go to the login page.
    window.location.href = "login.php";
    }
    });
}



// Call the function and pass it a callback function.
function swalActivationMessage(){
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
  // window.location.href = "login.php";
}



function loginErrorAlert() {
  Swal.fire({
    icon: 'error',
    title: 'Login Error',
    text: 'Your email or password is incorrect. Please try again.',
    confirmButtonText: 'Ok',
  });
}



function LoginSuccesAllert(){
  Swal.fire({
      icon: 'success',
      title: 'Success!',
      text: "Log In Successfully",
      confirmButtonText: "Okay",
  }).then((result) => {
    if (result.isConfirmed) {
        window.location.href = "user_dashboard.php";
    }
});
}


function logoutSuccesAllert(){
  Swal.fire({
      icon: 'success',
      title: 'You are now logged out',
      text: "Logout Successfully",
      confirmButtonText: "Okay",
  }).then((result) => {
    if (result.isConfirmed) {
        window.location.href = "index.php";
    }
});
}

//**************************************************************** */

function verifyAlert(userId){
  Swal.fire({
    title: "Are you sure you want to verify this account?",
    text: "Verify Account.",
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: '#44ccff',
    cancelButtonColor: '#d33',
    confirmButtonText: "Yes",
    cancelButtonText: "No"
  }).then((result) => {
    if (result.isConfirmed) {
      // Verify the account
      console.log("Verifying account...");
      window.location.href = "verify_user.php?id=" + userId;
      // window.location.href = "verify_user.php?"
    } else {
      // Do nothing
    }
  });
}




function rejectAlert(){
  Swal.fire({
    title: "Are you sure you want to reject this account?",
    text: "Once you verify your account, you cannot undo this action.",
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: '#44ccff',
    cancelButtonColor: '#d33',
    confirmButtonText: "Yes",
    cancelButtonText: "No"
  }).then((result) => {
    if (result.isConfirmed) {
      // Verify the account
      window.location.href = "verify_user.php?id=<?php echo $row['user_id']; ?>";
    } else {
      // Do nothing
    }
  });
}






