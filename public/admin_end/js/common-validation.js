// common-validation.js

function validateEmail(input) {
    const email = input.value.trim();
    let error;

    // Edit modal structure
    if (input.closest('.popup-form-group')) {
        error = input.closest('.popup-form-group').nextElementSibling;
    }
    // Create form structure
    else if (input.closest('.form-group')) {
        error = input.closest('.form-group')
            .parentElement
            .querySelector('small');
    }

    if (!error) return true;

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (email === '') {
        error.style.display = 'none';
        input.classList.remove('invalid');
        return false;
    }

    if (!emailRegex.test(email)) {
        error.style.display = 'block';
        input.classList.add('invalid');
        return false;
    } else {
        error.style.display = 'none';
        input.classList.remove('invalid');
        return true;
    }
}
// Allow only alphabets and spaces
function allowOnlyAlphabets(input) {
    input.value = input.value.replace(/[^A-Za-z\s]/g, '');
}
// Auto-bind for all fields having .only-alpha class
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.only-alpha').forEach(input => {
        input.setAttribute('pattern', '[A-Za-z\\s]+');
        input.setAttribute('title', 'Only alphabets are allowed');
        input.addEventListener('input', () => {
            input.value = input.value.replace(/[^A-Za-z\s]/g, '');
        });
    });
});


// =======================
// NUMERIC RANGE (COMMON)
// =======================
function bindNumericRanges() {
    document.querySelectorAll('.num-range').forEach(input => {

        if (input.dataset.bound) return;
        input.dataset.bound = 'true';

        const min = Number(input.dataset.min ?? 0);
        const max = Number(input.dataset.max ?? 9999);
        const step = Number(input.dataset.step ?? 1);

        input.setAttribute('type', 'number');
        input.setAttribute('min', min);
        input.setAttribute('max', max);
        input.setAttribute('step', step);

        input.addEventListener('input', () => {
            let value = input.value.replace(/[^0-9.]/g, '');
            let num = Number(value);

            if (num > max) num = max;
            if (num < min && value !== '') num = min;

            // Step handling (supports .5, 1, etc.)
            if (step % 1 !== 0 && num % step !== 0) {
                num = Math.round(num / step) * step;
            }

            input.value = value ? num : '';
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    bindNumericRanges();
});
