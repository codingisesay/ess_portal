

window.APP = window.APP || {};
window.APP.REGEX = {
    ALPHABETS_SPACE: /[^A-Za-z\s]/g,
    TEXT_EXTENDED: /[^a-zA-Z\s.&]/g,
    NUMBERS_ONLY: /[^0-9]/g,
    DECIMAL: /[^0-9.]/g,
    NON_DIGITS: /\D/g, 
    EMAIL: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
    BANK_ALLOWED_CHARS: /[^a-zA-Z\s.&]/g,   // letters, space, dot, &
    MULTIPLE_SPACES: /\s{2,}/g,              // more than one space
    LEADING_SPACES: /^\s+/g   
};

window.APP.PATTERN = {
    ALPHABETS_SPACE: '[A-Za-z\\s]+',
    EMAIL: '[^\\s@]+@[^\\s@]+\\.[^\\s@]+'
};

// common-validation.js  ✅
function validateEmail(input) {
    const email = input.value.trim();
    let error;

    if (input.closest('.popup-form-group')) {
        error = input.closest('.popup-form-group').nextElementSibling;
    } else if (input.closest('.form-group')) {
        error = input.closest('.form-group')
            .parentElement
            .querySelector('small');
    }

    if (!error) return true;

    if (email === '') {
        error.style.display = 'none';
        input.classList.remove('invalid');
        return false;
    }

    if (!APP.REGEX.EMAIL.test(email)) {
        error.style.display = 'block';
        input.classList.add('invalid');
        return false;
    }

    error.style.display = 'none';
    input.classList.remove('invalid');
    return true;
}
// Allow only alphabets and spaces  
function allowOnlyAlphabets(input) {
    if (!input) return;
    input.value = input.value.replace(APP.REGEX.ALPHABETS_SPACE, '');
}

// Auto-bind for all fields having .only-alpha class
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.only-alpha').forEach(input => {

        if (input.dataset.bound) return;
        input.dataset.bound = 'true';

        input.setAttribute('pattern', APP.PATTERN.ALPHABETS_SPACE);
        input.setAttribute('title', 'Only alphabets are allowed');

        input.addEventListener('input', () => {
            input.value = input.value.replace(APP.REGEX.ALPHABETS_SPACE, '');
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
    const YEAR_DAYS = getYearDays(); // dynamic

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
            let value = input.value.replace(APP.REGEX.NUMBERS_ONLY, '');
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
   USER DEFINED DAYS (COMMON)
========================= */

function bindUserDefinedDays() {
    document.querySelectorAll('.user-days').forEach(input => {

        if (input.dataset.bound) return;
        input.dataset.bound = 'true';

        const max = Number(input.dataset.max ?? LIMITS.USER_DEFINED_DAYS_MAX);

        input.addEventListener('input', () => {
            let value = input.value.replace(APP.REGEX.NUMBERS_ONLY, '');

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
            let value = input.value.replace(APP.REGEX.NON_DIGITS, '');
            let num = Number(value);

            if (num > 31) num = 31;
            if (num < 1 && value !== '') num = 1;

            input.value = value ? num : '';
        });
    });
}

/* =========================
   MOBILE NUMBER VALIDATION
========================= */

function mobileNumberValidation() {
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
                ? value.replace(APP.REGEX.DECIMAL, '')
                : value.replace(APP.REGEX.NUMBERS_ONLY, '');

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

document.addEventListener('DOMContentLoaded', mobileNumberValidation);


/* ----------------------------------------------------
   MIN / MAX LEAVE PAIR VALIDATION (COMMON)
---------------------------------------------------- */
function normalizeNumber(input, min = 1, max = 365) {
    let value = input.value.replace(APP.REGEX.NUMBERS_ONLY, '');

    if (value.length > 3) value = value.slice(0, 3);

    let num = Number(value);

    if (num > max) num = max;
    if (num < min && value !== '') num = min;

    input.value = value ? num : '';
    return num;
}

document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.num-pair').forEach(input => {

        input.addEventListener('input', () => {

            const min = Number(input.dataset.min || 1);
            const max = Number(input.dataset.max || 365);
            const pairName = input.dataset.pair;

            const currentValue = normalizeNumber(input, min, max);

            if (!pairName) return;

            // Find paired input by NAME (works for create & edit)
            const pairInput = document.querySelector(
                `input[name="${pairName}"]`
            );

            if (!pairInput || !pairInput.value) return;

            const pairValue = Number(pairInput.value);

            // 🔁 Cross validation
            if (input.classList.contains('min-leave') && currentValue > pairValue) {
                input.value = pairValue;
            }

            if (input.classList.contains('max-leave') && currentValue < pairValue) {
                input.value = pairValue;
            }
        });

    });
});



document.addEventListener('DOMContentLoaded', () => {
    bindNumericRanges();  
    bindUserDefinedDays();
    bindDays();
});




