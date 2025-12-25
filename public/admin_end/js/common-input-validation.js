/**
 * Validate organization name
 * - Allows alphabets, spaces, dot (.), ampersand (&)
 * - Max length: 100 characters
 */
function validateOrgName(input) {
    if (!input) return;

    let value = input.value;

    // Allow only letters, space, dot, ampersand
    value = value.replace(/[^a-zA-Z\s.&]/g, '');

    // Limit length
    if (value.length > 100) {
        value = value.slice(0, 100);
    }

    input.value = value;
}



/**
 * Validate Reimbursement Name
 * - Alphabets + spaces only
 * - No leading spaces
 * - Max length configurable
 */
function validateReimbursementName(input, maxLen = 50) {
    if (!input) return;

    let value = input.value;

    // Allow only alphabets and spaces
    value = value.replace(/[^a-zA-Z\s]/g, '');

    // Remove leading spaces
    value = value.replace(/^\s+/g, '');

    // Enforce max length
    if (value.length > maxLen) {
        value = value.slice(0, maxLen);
    }

    input.value = value;
}


/**
 * Validate Reimbursement Abbreviation
 * - Alphabets only
 * - Auto uppercase
 * - Max length configurable
 */
function validateReimbursementAbbreviation(input, maxLen = 10) {
    if (!input) return;

    let value = input.value;

    // Allow only letters
    value = value.replace(/[^a-zA-Z]/g, '');

    // Convert to uppercase
    value = value.toUpperCase();

    // Enforce max length
    if (value.length > maxLen) {
        value = value.slice(0, maxLen);
    }

    input.value = value;
}


document.addEventListener('input', function (e) {
    const el = e.target;

    if (el.dataset.validate === 'reim-name') {
        validateReimbursementName(el, el.dataset.max);
    }

    if (el.dataset.validate === 'reim-abbr') {
        validateReimbursementAbbreviation(el, el.dataset.max);
    }
});


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
    value = value.replace(/[^0-9.]/g, '');

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
