function resetForm() {
    document.getElementById('modalTitle').innerText = 'Add New Showtime';
    document.getElementById('showtime_id').value = '';
    document.querySelector('form').reset();
}

function editShowtime(showtime) {
    document.getElementById('modalTitle').innerText = 'Edit Showtime';
    document.getElementById('showtime_id').value = showtime.showtime_id;
    document.getElementById('movie_id').value = showtime.movie_id;
    document.getElementById('screen_id').value = showtime.screen_id;
    document.getElementById('show_date').value = showtime.show_date;
    document.getElementById('show_time').value = showtime.show_time;
    
    new bootstrap.Modal(document.getElementById('showtimeModal')).show();
}