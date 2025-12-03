function resetTheatreForm() {
    document.getElementById('theatreModalTitle').innerText = 'Add New Theatre';
    document.getElementById('theatre_id').value = '';
    document.getElementById('name').value = '';
    document.getElementById('location').value = '';
    document.getElementById('city').value = '';
    document.getElementById('total_screens').value = '';
}

function editTheatre(theatre) {
    document.getElementById('theatreModalTitle').innerText = 'Edit Theatre';
    document.getElementById('theatre_id').value = theatre.theatre_id;
    document.getElementById('name').value = theatre.name;
    document.getElementById('location').value = theatre.location;
    document.getElementById('city').value = theatre.city;
    document.getElementById('total_screens').value = theatre.total_screens;
    
    new bootstrap.Modal(document.getElementById('theatreModal')).show();
}

function addScreen(theatreId) {
    document.getElementById('screen_theatre_id').value = theatreId;
    new bootstrap.Modal(document.getElementById('screenModal')).show();
}