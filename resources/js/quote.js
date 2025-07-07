// Quote Page Specific Functions

// Toggle elevator and floor fields based on property type
function toggleElevadorAndar(prefix) {
    const apartmentRadio = document.querySelector(`input[name="${prefix}_type"][value="apartment"]`);
    const houseRadio = document.querySelector(`input[name="${prefix}_type"][value="house"]`);
    const elevatorFloorDiv = document.getElementById(`${prefix}_elevator_floor`);
    const elevatorRadios = document.querySelectorAll(`input[name="${prefix}_elevator"]`);
    const floorInput = document.getElementById(`${prefix}_floor`);

    if (!elevatorFloorDiv) return;

    if (apartmentRadio && apartmentRadio.checked) {
        // Show elevator and floor fields
        elevatorFloorDiv.classList.remove('hidden');
        elevatorFloorDiv.classList.add('grid', 'grid-cols-1', 'md:grid-cols-2');

        // Make elevator field required
        elevatorRadios.forEach(radio => radio.setAttribute('required', 'required'));
    } else if (houseRadio && houseRadio.checked) {
        // Hide elevator and floor fields
        elevatorFloorDiv.classList.add('hidden');
        elevatorFloorDiv.classList.remove('grid', 'grid-cols-1', 'md:grid-cols-2');

        // Remove requirement and clear values
        elevatorRadios.forEach(radio => {
            radio.removeAttribute('required');
            radio.checked = false;
        });
        if (floorInput) floorInput.value = '';
    }
}

// Initialize quote page functionality
document.addEventListener('DOMContentLoaded', function () {
    // This script only runs on pages that have quote-specific elements
    const quoteForm = document.querySelector('form[action*="quote.send"]');
    if (!quoteForm) return;

    console.log('Quote page scripts loaded');
});

// Export functions for global use
window.toggleElevadorAndar = toggleElevadorAndar;
