document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('payment-form');

    if (form) {
        // Input Formatting for Card Number
        const cardNumInput = document.getElementById('card_number');
        if (cardNumInput) {
            cardNumInput.addEventListener('input', function (e) {
                let value = e.target.value.replace(/\D/g, '');
                e.target.value = value.replace(/(\d{4})(?=\d)/g, '$1 ').trim();
            });
        }

        // Input Formatting for Expiry Date
        const cardExpiryInput = document.getElementById('card_expiry');
        if (cardExpiryInput) {
            cardExpiryInput.addEventListener('input', function (e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length >= 2) {
                    e.target.value = value.substring(0, 2) + '/' + value.substring(2, 4);
                } else {
                    e.target.value = value;
                }
            });
        }

        form.addEventListener('submit', function (e) {
            let isValid = true;
            const method = document.getElementById('payment_method').value;

            // Clear previous errors
            document.querySelectorAll('.error-msg').forEach(el => el.textContent = '');

            // Helper function to set error
            const setError = (input, message) => {
                const errorEl = input.parentElement.querySelector('.error-msg');
                if (errorEl) {
                    errorEl.textContent = message;
                }
                isValid = false;
            };

            if (method === 'card') {
                // Validate Card Number
                const num = document.getElementById('card_number');
                if (num) {
                    const val = num.value.replace(/\s/g, '');
                    if (val === '') {
                        setError(num, 'Card Number is Required!!');
                    } else if (!/^\d{16}$/.test(val)) {
                        setError(num, 'Invalid Card Number (16 digits required)!!');
                    }
                }

                // Validate Expiry
                const expiry = document.getElementById('card_expiry');
                if (expiry) {
                    if (expiry.value === '') {
                        setError(expiry, 'Expiry Date is Required!!');
                    } else if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(expiry.value)) {
                        setError(expiry, 'Invalid Expiry Date (MM/YY)!!');
                    }
                }

                // Validate CVV
                const cvv = document.getElementById('card_cvv');
                if (cvv) {
                    if (cvv.value === '') {
                        setError(cvv, 'CVV is Required!!');
                    } else if (!/^\d{4}$/.test(cvv.value)) {
                        setError(cvv, 'Invalid CVV (4 digits)!!');
                    }
                }

                // Validate Name
                const name = document.getElementById('card_name');
                if (name && name.value.trim() === '') {
                    setError(name, 'Card Holder Name is Required!!');
                }

            } else if (method === 'upi') {
                // Validate UPI ID
                const upi = document.getElementById('upi_id');
                if (upi) {
                    if (upi.value.trim() === '') {
                        setError(upi, 'UPI ID is Required!!');
                    } else if (!/^[\w.-]+@[\w.-]+$/.test(upi.value)) {
                        setError(upi, 'Invalid UPI ID Format!!');
                    }
                }
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    }
});
