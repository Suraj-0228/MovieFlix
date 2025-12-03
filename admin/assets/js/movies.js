function resetForm() {
    document.getElementById('modalTitle').innerText = 'Add New Movie';
    document.getElementById('movie_id').value = '';
    document.querySelector('form').reset();
}

function editMovie(movie) {
    document.getElementById('modalTitle').innerText = 'Edit Movie';
    document.getElementById('movie_id').value = movie.movie_id;
    document.getElementById('title').value = movie.title;
    document.getElementById('genre').value = movie.genre;
    document.getElementById('language').value = movie.language;
    document.getElementById('duration').value = movie.duration;
    document.getElementById('rating').value = movie.rating;
    document.getElementById('release_date').value = movie.release_date;
    document.getElementById('status').value = movie.status;
    document.getElementById('poster_url').value = movie.poster_url;
    document.getElementById('description').value = movie.description;
    
    new bootstrap.Modal(document.getElementById('movieModal')).show();
}