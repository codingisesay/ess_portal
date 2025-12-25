

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


