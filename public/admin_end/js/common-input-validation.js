
/**
 * Validate amount input
 * - Digits + single decimal
 * - Max 2 decimal places
 * - Configurable max length
 * - No zero-only value
 */
function validateAmount(input, options = {}) {
    if (!input) return;

    const {
        maxDecimals = 2,
        maxLength = 10,
        allowZero = false
    } = options;

    let value = input.value;

    // Allow digits and decimal only
    value = value.replace(APP.REGEX.DECIMAL, '');

    // Prevent multiple decimals
    const parts = value.split('.');
    if (parts.length > 2) {
        value = parts[0] + '.' + parts[1];
    }

    // Limit decimal places
    if (parts[1] && parts[1].length > maxDecimals) {
        value = parts[0] + '.' + parts[1].slice(0, maxDecimals);
    }

    // Limit total length
    if (value.length > maxLength) {
        value = value.slice(0, maxLength);
    }

    // Prevent zero-only value
    if (!allowZero && (value === '0' || value === '0.00')) {
        value = '';
    }

    input.value = value;
}

document.addEventListener('input', function (e) {
    const el = e.target;

    if (el.dataset.validate === 'amount') {
        validateAmount(el, {
            maxDecimals: Number(el.dataset.decimals) || 2,
            maxLength: Number(el.dataset.maxlen) || 10,
            allowZero: el.dataset.allowZero === 'true'
        });
    }
});

/**
 * Validate Bank Name
 * - Letters, spaces, dot (.), ampersand (&)
 * - No multiple spaces
 * - Max length configurable (default 50)
 */
function validateBankName(input, maxLen = 50) {
    if (!input) return;

    let value = input.value;

    // Allow only letters, space, dot and ampersand
    value = value.replace(APP.REGEX.BANK_ALLOWED_CHARS, '');

    // Prevent multiple spaces
    value = value.replace(APP.REGEX.MULTIPLE_SPACES, ' ');

    // Trim leading spaces
    value = value.replace(APP.REGEX.LEADING_SPACES, '');

    // Enforce max length
    if (value.length > maxLen) {
        value = value.slice(0, maxLen);
    }

    input.value = value;
}


document.addEventListener('input', function (e) {
    const el = e.target;

    if (el.dataset.validate === 'bank-name') {
        validateBankName(el, Number(el.dataset.maxlen) || 50);
    }
});

