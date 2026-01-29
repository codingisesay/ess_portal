/**
 * Generic duplicate check before form submit
 *
 * Usage:
 *  data-duplicate-check="true"
 *  data-select-id="organisation_reimbursement_type_id"
 *  data-table-selector="#tableSection"
 *  data-column-index="2"
 *  data-error-title="Already Exists"
 *  data-error-message="This reimbursement type already has restrictions defined."
 */

document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('form[data-duplicate-check="true"]').forEach(form => {

        form.addEventListener('submit', function (e) {

            const selectId = form.dataset.selectId;
            const tableSelector = form.dataset.tableSelector;
            const columnIndex = Number(form.dataset.columnIndex) || 2;

            const title = form.dataset.errorTitle || 'Duplicate Entry';
            const message = form.dataset.errorMessage || 'This record already exists.';

            const selectEl = document.getElementById(selectId);
            if (!selectEl || !selectEl.value) return;

            const selectedText = selectEl.options[selectEl.selectedIndex]
                .text.trim().toLowerCase();

            const cells = document.querySelectorAll(
                `${tableSelector} tbody tr td:nth-child(${columnIndex})`
            );

            const existingValues = Array.from(cells)
                .map(td => td.textContent.trim().toLowerCase());

            if (existingValues.includes(selectedText)) {
                e.preventDefault();

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: title,
                        text: message,
                        confirmButtonColor: '#d33'
                    });
                }

                return false;
            }
        });
    });

});
