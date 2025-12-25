// /* ----------------------------------------------------
//    DATE HELPERS
// ---------------------------------------------------- */
// function getNowRounded() {
//     const now = new Date();
//     now.setSeconds(0, 0);
//     return now;
// }

// function hoursBetween(start, end) {
//     return (end - start) / (1000 * 60 * 60);
// }


// /* ----------------------------------------------------
//    APPLY MIN DATETIME (COMMON)
// ---------------------------------------------------- */
// document.addEventListener('DOMContentLoaded', () => {
//     const minDateTime = getNowRounded().toISOString().slice(0, 16);

//     document.querySelectorAll('[data-min-now="true"]').forEach(input => {
//         input.min = minDateTime;
//     });
// });


// function validateLeaveCycle({ startSelector, endSelector, yearSelector }) {
//     const startInput = document.querySelector(startSelector);
//     const endInput = document.querySelector(endSelector);
//     const yearInput = yearSelector
//         ? document.querySelector(yearSelector)
//         : null;

//     if (!startInput || !endInput || !startInput.value || !endInput.value) return;

//     const now = getNowRounded();
//     const start = new Date(startInput.value);
//     const end = new Date(endInput.value);

//     startInput.setCustomValidity('');
//     endInput.setCustomValidity('');

//     if (start < now) {
//         startInput.setCustomValidity('Start Date & Time cannot be in the past');
//         return;
//     }

//     if (end <= start) {
//         endInput.setCustomValidity('End Date & Time must be after Start Date & Time');
//         return;
//     }

//     const diffHours = hoursBetween(start, end);

//     if (diffHours < 24) {
//         endInput.setCustomValidity('Leave cycle must be at least 1 full day');
//         return;
//     }

//     if (diffHours / 24 > 366) {
//         endInput.setCustomValidity('Leave cycle cannot exceed 1 year');
//         return;
//     }

//     if (yearInput && /^\d{4}-\d{2}$/.test(yearInput.value)) {
//         const startYear = parseInt(yearInput.value.substring(0, 4));
//         const endYear = startYear + 1;

//         if (start.getFullYear() < startYear || end.getFullYear() > endYear) {
//             endInput.setCustomValidity(
//                 `Dates must be within year slot ${yearInput.value}`
//             );
//         }
//     }
// }




























/* ====================================================
   COMMON DATE VALIDATION UTILITIES
==================================================== */

/**
 * Get current date-time rounded to minutes
 */
function getNowRounded() {
    const now = new Date();
    now.setSeconds(0, 0);
    return now;
}

/**
 * Apply min="now" to all inputs with data-min-now
 */
document.addEventListener('DOMContentLoaded', () => {
    const minDateTime = getNowRounded().toISOString().slice(0, 16);

    document.querySelectorAll('[data-min-now="true"]').forEach(input => {
        input.min = minDateTime;
    });
});

/**
 * Validate start & end date-time fields
 * - No past dates
 * - End must be after start
 */
function validateDateRange({ startSelector, endSelector }) {
    const startInput = document.querySelector(startSelector);
    const endInput = document.querySelector(endSelector);

    if (!startInput || !endInput) return;

    startInput.setCustomValidity('');
    endInput.setCustomValidity('');

    if (!startInput.value || !endInput.value) return;

    const now = getNowRounded();
    const start = new Date(startInput.value);
    const end = new Date(endInput.value);

    // ❌ Start date in the past
    if (start < now) {
        startInput.setCustomValidity('Start Date & Time cannot be in the past');
        return;
    }

    // ❌ End date in the past
    if (end < now) {
        endInput.setCustomValidity('End Date & Time cannot be in the past');
        return;
    }

    // ❌ End before or same as start
    if (end <= start) {
        endInput.setCustomValidity(
            'End Date & Time must be after Start Date & Time'
        );
        return;
    }
}


function validateProcessStart(input, cycleStart, cycleEnd) {
    input.setCustomValidity('');

    if (!cycleStart.value || !cycleEnd.value) return;

    if (input.value < cycleStart.value) {
        input.setCustomValidity('Process start cannot be before cycle start');
        return;
    }

    if (input.value > cycleEnd.value) {
        input.setCustomValidity('Process start cannot be after cycle end');
    }
}

function validateProcessEnd(input, processStart, cycleEnd) {
    input.setCustomValidity('');

    if (!processStart.value || !cycleEnd.value) return;

    if (input.value < processStart.value) {
        input.setCustomValidity('Process end cannot be before process start');
        return;
    }

    if (input.value > cycleEnd.value) {
        input.setCustomValidity('Process end cannot exceed cycle end');
    }
}


