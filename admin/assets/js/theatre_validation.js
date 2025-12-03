document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');

    if (form) {
        form.addEventListener('submit', function (e) {
            let isValid = true;

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

            // Validate Name
            const name = document.getElementById('name');
            if (name && name.value.trim() === '') {
                setError(name, 'Theatre Name is Required!!');
            }

            // Validate Location
            const location = document.getElementById('location');
            if (location && location.value.trim() === '') {
                setError(location, 'Location is Required!!');
            }

            // Validate City
            const city = document.getElementById('city');
            if (city && city.value.trim() === '') {
                setError(city, 'City is Required!!');
            }

            // Validate Total Screens
            const totalScreens = document.getElementById('total_screens');
            if (totalScreens) {
                const screensValue = parseInt(totalScreens.value);
                if (isNaN(screensValue) || screensValue <= 0) {
                    setError(totalScreens, 'Valid Total Screens is Required!!');
                }
            }

            // Validate Prices (if present in the form)
            ['vip_price', 'premium_price', 'regular_price'].forEach(id => {
                const priceInput = document.getElementById(id);
                if (priceInput) {
                    const price = parseFloat(priceInput.value);
                    if (isNaN(price) || price < 0) {
                        setError(priceInput, 'Valid Price is Required!!');
                    }
                }
            });

            if (!isValid) {
                e.preventDefault();
            }
        });
    }
});
