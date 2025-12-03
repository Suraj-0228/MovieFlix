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

            // Validate Movie
            const movieId = document.getElementById('movie_id');
            if (movieId && movieId.value === '') {
                setError(movieId, 'Please Select a Movie!!');
            }

            // Validate Screen
            const screenId = document.getElementById('screen_id');
            if (screenId && screenId.value === '') {
                setError(screenId, 'Please Select a Screen!!');
            }

            // Validate Date
            const showDate = document.getElementById('show_date');
            if (showDate && showDate.value === '') {
                setError(showDate, 'Show Date is Required!!');
            }

            // Validate Time
            const showTime = document.getElementById('show_time');
            if (showTime && showTime.value === '') {
                setError(showTime, 'Show Time is Required!!');
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    }
});
