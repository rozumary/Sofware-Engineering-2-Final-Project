document.addEventListener("DOMContentLoaded", function() {
    const showPasswordButton = document.getElementById("showPasswordButton");
    const passwordInput = document.getElementById("exampleInputPassword2");

    showPasswordButton.addEventListener("click", () => {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            showPasswordButton.innerHTML = '<i class="fa fa-eye-slash"></i>';
        } else {
            passwordInput.type = "password";
            showPasswordButton.innerHTML = '<i class="fa fa-eye"></i>';
        }
    });

const showConfirmPasswordButton = document.getElementById(
    "showConfirmPasswordButton"
);
const confirmPasswordInput = document.getElementById(
    "exampleInputConfirmPassword2"
);

showConfirmPasswordButton.addEventListener("click", () => {
    if (confirmPasswordInput.type === "password") {
        confirmPasswordInput.type = "text";
        showConfirmPasswordButton.innerHTML = '<i class="fa fa-eye-slash"></i>';
    } else {
        confirmPasswordInput.type = "password";
        showConfirmPasswordButton.innerHTML = '<i class="fa fa-eye"></i>';
    }

    });
});
