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
