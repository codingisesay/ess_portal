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

