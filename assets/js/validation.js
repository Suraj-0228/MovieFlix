document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('form');

    forms.forEach(form => {
        // Real-time Password Validation
        const passwordInput = form.querySelector('input[name="password"]');
        const confirmPasswordInput = form.querySelector('input[name="confirm_password"]');

        if (passwordInput && confirmPasswordInput) {
            function validatePasswordMatch() {
                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;
                const confirmPasswordError = confirmPasswordInput.parentElement.nextElementSibling;

                if (confirmPassword.length > 0 && password !== confirmPassword) {
                    if (confirmPasswordError && confirmPasswordError.classList.contains('error-msg')) {
                        confirmPasswordError.textContent = `Passwords doesn't Match!!`;
                    }
                } else {
                    if (confirmPasswordError && confirmPasswordError.classList.contains('error-msg')) {
                        confirmPasswordError.textContent = '';
                    }
                }
            }

            passwordInput.addEventListener('input', validatePasswordMatch);
            confirmPasswordInput.addEventListener('input', validatePasswordMatch);
        }

        form.addEventListener('submit', function (e) {
            let isValid = true;

            // Clear previous errors
            document.querySelectorAll('.error-msg').forEach(el => el.textContent = '');

            // Email Validation
            const emailInput = form.querySelector('input[type="email"]');
            if (emailInput) {
                const email = emailInput.value;
                const emailError = emailInput.parentElement.nextElementSibling; // Assuming <p> is next sibling

                if (!email.includes('@') || !email.includes('.com')) {
                    if (emailError && emailError.classList.contains('error-msg')) {
                        emailError.textContent = 'Email must Contain "@" and ".com"!!';
                    }
                    isValid = false;
                }
            }

            // Name Validation
            const nameInput = form.querySelector('input[name="name"]');
            if (nameInput) {
                const name = nameInput.value.trim();
                const nameError = nameInput.parentElement.nextElementSibling;

                if (name === '') {
                    if (nameError && nameError.classList.contains('error-msg')) {
                        nameError.textContent = 'Full Name is Required!!';
                    }
                    isValid = false;
                }
            }

            // Phone Validation
            const phoneInput = form.querySelector('input[name="phone"]');
            if (phoneInput) {
                const phone = phoneInput.value.trim();
                const phoneError = phoneInput.parentElement.nextElementSibling;

                if (phone === '') {
                    if (phoneError && phoneError.classList.contains('error-msg')) {
                        phoneError.textContent = 'Phone Number is Required!!';
                    }
                    isValid = false;
                } else if (!/^\d{10}$/.test(phone)) {
                    if (phoneError && phoneError.classList.contains('error-msg')) {
                        phoneError.textContent = 'Phone Number must be 10 in Digits!!';
                    }
                    isValid = false;
                }
            }

            // Password Validation
            const passwordInput = form.querySelector('input[name="password"]');
            const confirmPasswordInput = form.querySelector('input[name="confirm_password"]');

            if (passwordInput) {
                const password = passwordInput.value;
                const passwordError = passwordInput.parentElement.nextElementSibling;

                if (password.length < 6 || password.length > 15) {
                    if (passwordError && passwordError.classList.contains('error-msg')) {
                        passwordError.textContent = 'Password must be between 6 and 15 Characters!!';
                    }
                    isValid = false;
                }

                // Confirm Password Validation
                if (confirmPasswordInput) {
                    const confirmPassword = confirmPasswordInput.value;
                    const confirmPasswordError = confirmPasswordInput.parentElement.nextElementSibling;

                    if (confirmPassword !== password) {
                        if (confirmPasswordError && confirmPasswordError.classList.contains('error-msg')) {
                            confirmPasswordError.textContent = `Passwords doesn't Match!!`;
                        }
                        isValid = false;
                    }
                }
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    });
});
