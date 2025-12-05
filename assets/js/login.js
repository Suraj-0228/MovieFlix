const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#password');
const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
const confirm_password = document.querySelector('#confirm_password');

togglePassword.addEventListener('click', function (e) {
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.querySelector('i').classList.toggle('fa-eye-slash');
    this.querySelector('i').classList.toggle('fa-eye');
});

toggleConfirmPassword.addEventListener('click', function (e) {
    const type = confirm_password.getAttribute('type') === 'password' ? 'text' : 'password';
    confirm_password.setAttribute('type', type);
    this.querySelector('i').classList.toggle('fa-eye-slash');
    this.querySelector('i').classList.toggle('fa-eye');
});