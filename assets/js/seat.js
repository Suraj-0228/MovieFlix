document.addEventListener('DOMContentLoaded', function () {
    const seats = document.querySelectorAll('.seat.available');
    const selectedSeatsDisplay = document.getElementById('selected-seats-display');
    const totalPriceElement = document.getElementById('total-price');
    const selectedSeatsInput = document.getElementById('selected_seats_input');
    const totalAmountInput = document.getElementById('total_amount_input');
    const proceedBtn = document.getElementById('proceed-btn');

    let selectedSeats = [];
    let totalAmount = 0;

    seats.forEach(seat => {
        seat.addEventListener('click', function () {
            const seatId = this.getAttribute('data-id');
            const seatPrice = parseFloat(this.getAttribute('data-price'));
            const seatNumber = this.getAttribute('data-number');

            if (this.classList.contains('selected')) {
                this.classList.remove('selected');
                selectedSeats = selectedSeats.filter(s => s.id !== seatId);
                totalAmount -= seatPrice;
            } else {
                this.classList.add('selected');
                selectedSeats.push({ id: seatId, number: seatNumber, price: seatPrice });
                totalAmount += seatPrice;
            }

            updateSummary();
        });
    });

    function updateSummary() {
        if (selectedSeats.length === 0) {
            selectedSeatsDisplay.innerHTML = '<p class="text-white-50 fst-italic">No Seats Selected!!</p>';
            proceedBtn.disabled = true;
        } else {
            let html = '';
            selectedSeats.forEach(s => {
                html += `<span class="badge bg-danger me-2 mb-2 p-2" style="font-size: 0.9rem;">${s.number}</span>`;
            });
            selectedSeatsDisplay.innerHTML = html;
            proceedBtn.disabled = false;
        }

        totalPriceElement.textContent = '₹' + totalAmount;
        selectedSeatsInput.value = JSON.stringify(selectedSeats.map(s => s.id)); // Sending only IDs
        totalAmountInput.value = totalAmount;
    }
});