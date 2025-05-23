const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

signUpButton.addEventListener('click', () => {
    container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
    container.classList.remove("right-panel-active");
});

document.addEventListener("DOMContentLoaded", function () {
    let registerButton = document.getElementById("registerButton");
    if (registerButton) {
        registerButton.addEventListener("click", function () {
            sessionStorage.setItem("registered", "true");
        });
    }
});

