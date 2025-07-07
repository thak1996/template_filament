// Modal Functions
function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

function showModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'flex';
    }
}

// Initialize modals on page load
document.addEventListener('DOMContentLoaded', function () {
    // Check for success modal
    const successModal = document.getElementById('successModal');
    if (successModal && successModal.dataset.show === 'true') {
        showModal('successModal');
    }

    // Check for error modal
    const errorModal = document.getElementById('errorModal');
    if (errorModal && errorModal.dataset.show === 'true') {
        showModal('errorModal');
    }
});

// Export functions for global use
window.closeModal = closeModal;
window.showModal = showModal;
