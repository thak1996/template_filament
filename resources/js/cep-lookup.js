function clearAddressFields(prefix) {
    const fields = ['street', 'district', 'city', 'state'];

    fields.forEach(field => {
        const element = document.getElementById(prefix + '_' + field);
        if (element) {
            element.value = '';
        }
    });

    const loadingEl = document.getElementById(prefix + '_zipcode_loading');
    const errorEl = document.getElementById(prefix + '_zipcode_error');

    if (loadingEl) loadingEl.classList.add('hidden');
    if (errorEl) errorEl.classList.add('hidden');
}

async function searchAddressByZipcode(zipcode, prefix) {
    const cleanZipcode = zipcode.replace(/\D/g, '');

    if (cleanZipcode.length !== 8) {
        return;
    }

    const loadingEl = document.getElementById(prefix + '_zipcode_loading');
    const errorEl = document.getElementById(prefix + '_zipcode_error');

    if (loadingEl) loadingEl.classList.remove('hidden');
    if (errorEl) errorEl.classList.add('hidden');

    try {
        const response = await fetch(`https://viacep.com.br/ws/${cleanZipcode}/json/`);
        const data = await response.json();

        if (data.erro) {
            throw new Error('Zipcode not found');
        }

        const streetEl = document.getElementById(prefix + '_street');
        const districtEl = document.getElementById(prefix + '_district');
        const cityEl = document.getElementById(prefix + '_city');
        const stateEl = document.getElementById(prefix + '_state');
        const numberEl = document.getElementById(prefix + '_number');

        if (streetEl) streetEl.value = data.logradouro || '';
        if (districtEl) districtEl.value = data.bairro || '';
        if (cityEl) cityEl.value = data.localidade || '';
        if (stateEl) stateEl.value = data.uf || '';

        if (data.logradouro && numberEl) {
            numberEl.focus();
        }

    } catch (error) {
        console.error('Error fetching zipcode:', error);
        if (errorEl) errorEl.classList.remove('hidden');
    } finally {
        if (loadingEl) loadingEl.classList.add('hidden');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const zipCodeFields = [
        { id: 'origin_zipcode', prefix: 'origin' },
        { id: 'destination_zipcode', prefix: 'destination' }
    ];

    zipCodeFields.forEach(({ id, prefix }) => {
        const field = document.getElementById(id);
        if (!field) return;

        field.addEventListener('input', function (e) {
            if (window.applyCepMask) {
                window.applyCepMask(e.target);
            }
        });

        field.addEventListener('blur', function (e) {
            const zipcode = e.target.value.replace(/\D/g, '');
            if (zipcode.length === 8) {
                searchAddressByZipcode(e.target.value, prefix);
            }
        });

        field.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const zipcode = e.target.value.replace(/\D/g, '');
                if (zipcode.length === 8) {
                    searchAddressByZipcode(e.target.value, prefix);
                }
            }
        });
    });
});

window.clearAddressFields = clearAddressFields;
window.searchAddressByZipcode = searchAddressByZipcode;
