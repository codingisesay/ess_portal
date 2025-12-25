// common-validate-month-start.js

function validateMonthStart(input) {
    let value = input.value.replace(/[^0-9]/g, '');
    let num = Number(value);

    if (num > 31) num = 31;
    if (num < 1 && value !== '') num = 1;

    input.value = value ? num : '';
}

function validateLeaveCount(input) {
    let value = input.value.replace(/[^0-9]/g, '');
    let num = Number(value);

    if (num > 365) num = 365;
    if (num < 0) num = 0;

    input.value = value ? num : '';
}
