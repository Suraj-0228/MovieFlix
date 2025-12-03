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

            // Validate Title
            const title = document.getElementById('title');
            if (title && title.value.trim() === '') {
                setError(title, 'Title is Required!!');
            }

            // Validate Genre
            const genre = document.getElementById('genre');
            if (genre && genre.value.trim() === '') {
                setError(genre, 'Genre is Required!!');
            }

            // Validate Duration
            const duration = document.getElementById('duration');
            if (duration && (duration.value.trim() === '' || duration.value <= 0)) {
                setError(duration, 'Valid duration is Required!!');
            }

            // Validate Rating
            const rating = document.getElementById('rating');
            if (rating) {
                const ratingValue = parseFloat(rating.value);
                if (isNaN(ratingValue) || ratingValue < 0 || ratingValue > 10) {
                    setError(rating, 'Rating must be between 0 and 10!!');
                }
            }

            // Validate Release Date
            const releaseDate = document.getElementById('release_date');
            if (releaseDate && releaseDate.value.trim() === '') {
                setError(releaseDate, 'Release date is Required!!');
            }

            // Validate Poster URL
            const posterUrl = document.getElementById('poster_url');
            if (posterUrl) {
                const urlPattern = /^(https?:\/\/[^\s$.?#].[^\s]*)$/i;
                if (!urlPattern.test(posterUrl.value.trim())) {
                    setError(posterUrl, 'Please, Enter a Valid URL');
                }
            }

            // Validate Description
            const description = document.getElementById('description');
            if (description && description.value.trim() === '') {
                setError(description, 'Description is Required!!');
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    }
});
