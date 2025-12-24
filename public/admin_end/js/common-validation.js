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
// YEAR DAYS (COMMON)
// =======================
function getYearDays(year = new Date().getFullYear()) {
    return ((year % 4 === 0 && year % 100 !== 0) || year % 400 === 0)
        ? 366
        : 365;
}


// =======================
// NUMERIC RANGE (COMMON)
// =======================
function bindNumericRanges() {
    const YEAR_DAYS = getYearDays(); // ✅ dynamic

    document.querySelectorAll('.num-range').forEach(input => {

        if (input.dataset.bound) return;
        input.dataset.bound = 'true';

        const min = Number(input.dataset.min ?? 0);
        const max =
            input.dataset.max === 'YEAR_DAYS'
                ? YEAR_DAYS
                : Number(input.dataset.max ?? YEAR_DAYS);

        const step = Number(input.dataset.step ?? 1);

        input.setAttribute('min', min);
        input.setAttribute('max', max);
        input.setAttribute('step', step);

        input.addEventListener('input', () => {
            let value = input.value.replace(/[^0-9]/g, '');
            let num = Number(value);

            if (num > max) num = max;
            if (num < min && value !== '') num = min;

            input.value = value ? num : '';
        });
    });
}

document.addEventListener('DOMContentLoaded', bindNumericRanges);

/* =========================
   COMMON CONSTANTS
========================= */

const LIMITS = {
    TEXT_DEFAULT: 50,
    USER_DEFINED_DAYS_MAX: 365,
    DAYS_IN_MONTH: 31
};


/* =========================
   TEXT ONLY (COMMON)
========================= */

function bindTextOnly() {
    document.querySelectorAll('.text-only').forEach(input => {

        if (input.dataset.bound) return;
        input.dataset.bound = 'true';

        const maxLen = Number(input.dataset.maxlen ?? LIMITS.TEXT_DEFAULT);

        input.addEventListener('input', () => {
            let val = input.value.replace(/[^a-zA-Z\s.&]/g, '');
            if (val.length > maxLen) val = val.slice(0, maxLen);
            input.value = val;
        });
    });
}

/* =========================
   USER DEFINED DAYS (COMMON)
========================= */

function bindUserDefinedDays() {
    document.querySelectorAll('.user-days').forEach(input => {

        if (input.dataset.bound) return;
        input.dataset.bound = 'true';

        const max = Number(input.dataset.max ?? LIMITS.USER_DEFINED_DAYS_MAX);

        input.addEventListener('input', () => {
            let value = input.value.replace(/[^0-9]/g, '');

            if (value.length > 3) value = value.slice(0, 3);

            let num = Number(value);

            if (num > max) num = max;
            if (num < 1 && value !== '') num = 1;

            input.value = value ? num : '';
        });
    });
}

function bindDays() {
    document.querySelectorAll('.days-only').forEach(input => {

        if (input.dataset.bound) return;
        input.dataset.bound = 'true';

        input.addEventListener('input', () => {
            let value = input.value.replace(/\D/g, '');
            let num = Number(value);

            if (num > 31) num = 31;
            if (num < 1 && value !== '') num = 1;

            input.value = value ? num : '';
        });
    });
}

/* =========================
   GENERIC NUMBER VALIDATION
========================= */

function bindNumberValidation() {
    document.querySelectorAll('.num-validate').forEach(input => {

        if (input.dataset.bound) return;
        input.dataset.bound = 'true';

        const min  = Number(input.dataset.min ?? 0);
        const max  = Number(input.dataset.max ?? Infinity);
        const step = Number(input.dataset.step ?? 1);
        const allowDecimal = step % 1 !== 0;

        input.addEventListener('input', () => {
            let value = input.value;

            // Allow digits + optional decimal
            value = allowDecimal
                ? value.replace(/[^0-9.]/g, '')
                : value.replace(/[^0-9]/g, '');

            let num = allowDecimal ? parseFloat(value) : Number(value);

            if (isNaN(num)) {
                input.value = '';
                return;
            }

            // Enforce min / max
            if (num > max) num = max;
            if (num < min) num = min;

            // Enforce step (0.5, 1, etc.)
            if (allowDecimal && step > 0) {
                num = Math.floor(num / step) * step;
            }

            input.value = value ? num : '';
        });
    });
}

document.addEventListener('DOMContentLoaded', bindNumberValidation);




document.addEventListener('DOMContentLoaded', () => {
    bindNumericRanges();
    bindTextOnly();
    bindUserDefinedDays();
    bindDays();
});




