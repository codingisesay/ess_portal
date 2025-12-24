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
