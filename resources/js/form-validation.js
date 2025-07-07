// Form Validation and Masks

// Apply CEP mask
function applyCepMask(input) {
    let value = input.value.replace(/\D/g, '');
    if (value.length <= 8) {
        value = value.replace(/(\d{5})(\d{3})/, '$1-$2');
        input.value = value;
    }
}

// Apply phone mask
function applyPhoneMask(input) {
    let value = input.value.replace(/\D/g, '');

    if (value.length <= 10) {
        // Format: (11) 1234-5678
        value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
    } else {
        // Format: (11) 91234-5678
        value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
    }

    input.value = value;
}

// Capitalize name function
function capitalizeName(input) {
    const value = input.value;
    const words = value.split(' ');

    const capitalizedWords = words.map(word => {
        if (word.length > 3) {
            return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
        }
        return word.toLowerCase();
    });

    input.value = capitalizedWords.join(' ');
}

// Initialize form masks and validations
document.addEventListener('DOMContentLoaded', function () {
    // Apply phone masks to all phone fields
    const phoneFields = ['residential_phone', 'commercial_phone', 'mobile_phone', 'phone'];

    phoneFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('input', function (e) {
                applyPhoneMask(e.target);
            });
        }
    });

    // Apply name capitalization
    const nameField = document.getElementById('name');
    if (nameField) {
        nameField.addEventListener('blur', function (e) {
            capitalizeName(e.target);
        });
    }
});

// Export functions for global use
window.applyCepMask = applyCepMask;
window.applyPhoneMask = applyPhoneMask;
window.capitalizeName = capitalizeName;

// Keep old function names for backward compatibility
window.aplicarMascaraCEP = applyCepMask;
window.aplicarMascaraTelefone = applyPhoneMask;
window.capitalizarNome = capitalizeName;
