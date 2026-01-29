// common-search.js

function toggleNoResults(tableSectionId = 'tableSection', noResultsId = 'noResults') {
    const tableSection = document.getElementById(tableSectionId);
    const noResults = document.getElementById(noResultsId);

    if (!tableSection || !noResults) return;

    const rows = tableSection.querySelectorAll('tbody tr');
    let visibleCount = 0;

    rows.forEach(row => {
        if (row.style.display !== 'none') {
            visibleCount++;
        }
    });

    if (visibleCount === 0) {
        tableSection.style.display = 'none';
        noResults.style.display = 'block';
    } else {
        tableSection.style.display = 'block';
        noResults.style.display = 'none';
    }
}

/**
 * Generic table search handler
 * Usage:
 *  data-search-input="#tableSearch"
 *  data-table-section="tableSection"
 */
document.addEventListener('DOMContentLoaded', function () {
    const searchInputs = document.querySelectorAll('[data-search-input]');

    searchInputs.forEach(input => {
        const tableSectionId = input.dataset.tableSection || 'tableSection';
        const noResultsId = input.dataset.noResults || 'noResults';

        input.addEventListener('input', function () {
            const searchTerm = this.value.toLowerCase();
            const tableSection = document.getElementById(tableSectionId);

            if (!tableSection) return;

            const rows = tableSection.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });

            toggleNoResults(tableSectionId, noResultsId);
        });
    });
});
