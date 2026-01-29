
{{-- Page-specific CSS and Font Awesome icons (keeps styles and icons loading) --}}
<link rel="stylesheet" href="{{ asset('/user_end/css/salaryDetailsCreation.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="page-layout">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <h1>Salary Details</h1>
            <p>Manage components</p>
            <a href="{{ route('user.setting') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
        
        <div class="employee-info">
            <div class="employee-avatar">
                <div class="avatar">{{ substr($user->name ?? 'AD', 0, 2) }}</div>
                <div class="employee-name">
                    <h3>{{ $user->name ?? 'Aniket Desai' }}</h3>
                    <span class="status-badge">Active</span>
                </div>
            </div>
            
            <div class="info-item">
                <i class="fas fa-user"></i>
                <div class="info-content">
                    <span class="info-label">Employee ID</span>
                    <span class="info-value" id="employee_id">{{ $user->employeeID ?? 'PV0009' }}</span>
                </div>
            </div>
            
            <div class="info-item">
                <i class="fas fa-briefcase"></i>
                <div class="info-content">
                    <span class="info-label">Department</span>
                    <span class="info-value">{{ $user->department_name ?? 'Development' }}</span>
                </div>
            </div>
            
            <div class="info-item">
                <i class="fas fa-id-badge"></i>
                <div class="info-content">
                    <span class="info-label">Designation</span>
                    <span class="info-value">{{ $user->designation_name ?? 'Associate Engineering Manager' }}</span>
                </div>
            </div>
        </div>
        
        
        <div class="last-updated">
            <span>Last Updated</span>
            <span class="date">Today</span>
        </div>
    </div>

    <!-- Card Body Container -->
    <div class="card-body">
                <!-- Table Header -->
                <div class="table-header">
                    <div class="header-cell">Effective From</div>
                    <div class="header-cell">Payhead</div>
                    <div class="header-cell">Rate</div>
                    <div class="header-cell">Per</div>
                    <div class="header-cell">Type</div>
                    <div class="header-cell">Calculation</div>
                    <div class="header-cell">Action</div>
                </div>
                
                <!-- Table Rows -->
                <div class="table-rows">
                    <div class="table-row">
                        <!-- Effective From -->
                        <div class="table-cell">
                            <div class="input-wrapper">
                                <input type="date" name="effective_from[]" class="form-input" required>
                            </div>
                        </div>
                        
                        <!-- Payhead -->
                        <div class="table-cell">
                            <div class="input-wrapper">
                                <input type="text" name="payhead[]" class="form-input" list="payheadOptions" placeholder="Select Payhead" required>
                            </div>
                        </div>
                        
                        <!-- Rate -->
                        <div class="table-cell">
                            <div class="input-wrapper currency-input">
                                <span class="currency">₹</span>
                                <input type="number" name="rate[]" class="form-input" step="0.01" placeholder="0.00" required>
                            </div>
                        </div>
                        
                          <!-- Per (Auto-fill) -->
                        <div class="table-cell">
                            <div class="input-wrapper">
                                <input type="text" name="per[]" class="form-input auto-filled" placeholder="Per" readonly>
                            </div>
                        </div>
                        
                        <!-- Type (Auto-fill) -->
                        <div class="table-cell">
                            <div class="input-wrapper">
                                <input type="text" name="type[]" class="form-input auto-filled" placeholder="Type" readonly>
                            </div>
                        </div>
                        
                        <!-- Calculation (Auto-fill) -->
                        <div class="table-cell">
                            <div class="input-wrapper">
                                <input type="text" name="calculation[]" class="form-input auto-filled" placeholder="Calculation" readonly>
                            </div>
                        </div>
                        
                        <!-- Action -->
                        <div class="table-cell">
                            <button type="button" class="delete-btn">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Card Footer -->
                <div class="card-footer">
                    <div class="footer-left">
                        <button type="button" class="btn btn-add">
                            <i class="fas fa-plus"></i> Add Component
                        </button>
                      <!-- Action button for dynamically adding additional form sections/rows -->
                        <button type="button" class="btn btn-add-another" style="margin-left: 10px;">
                            <i class="fas fa-plus-circle"></i> Add Another
                        </button>

                        <span class="component-count">1 component added</span>
                    </div>
                    <div class="footer-right">
                       <!-- Button to reset/clear all fields in the form -->
                        <button type="button" class="btn btn-ghost" id="resetForm">

                            <i class="fas fa-undo"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Configuration
                        </button>
                    </div>
                </div>
    </div>
    
            <!-- Datalist for payhead autocomplete -->
            <datalist id="payheadOptions">
            </datalist>
        <!-- card end -->
<!-- scipt for payhead list -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    fetch("/payhead-list")
        .then(res => res.json())
        .then(response => {

            if (!response.status) {
                console.error("Failed to load payheads");
                return;
            }

            const datalist = document.getElementById("payheadOptions");
            datalist.innerHTML = "";

            response.data.forEach(payhead => {
                const option = document.createElement("option");
                option.value = payhead.name;
                datalist.appendChild(option);
            });
        })
        .catch(err => console.error("Error fetching payheads", err));

});
</script>
<!-- script for payhead details autofill -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    document.addEventListener("change", function (e) {

        if (!e.target.matches('input[name="payhead[]"]')) return;

        let payheadInput = e.target;
        let row = payheadInput.closest(".table-row");

        let perField = row.querySelector('input[name="per[]"]');
        let typeField = row.querySelector('input[name="type[]"]');
        let calcField = row.querySelector('input[name="calculation[]"]');
        let rateField = row.querySelector('input[name="rate[]"]');
        let effectiveField = row.querySelector('input[name="effective_from[]"]');

        fetch(`/payhead-details?payhead=${encodeURIComponent(payheadInput.value)}`)
            .then(res => res.json())
            .then(response => {

                console.log("Backend Response:", response);

                if (!response.status) {
                    alert(response.message);
                    return;
                }

                const data = response.data;

                // Auto-fill input fields
                perField.value = data.calculation_period ?? '';
                typeField.value = data.type ?? '';
                calcField.value = data.calculation_type ?? '';
                
                if (data.effective_from) {
                    effectiveField.value = data.effective_from;
                }

                // Rate stays empty
                rateField.value = '';

            })
            .catch(err => console.error("Payhead fetch failed:", err));
    });

});
</script>


<script>
/*
  Page script:
  - Saves rows to localStorage for the current user
  - Restores saved rows on load
  - Auto-fills Type/Per/Calculation fields based on selected payhead
  - Adds/removes rows and wire up interactions
*/
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.getElementById('salaryRows');
    const firstRow = tableBody ? tableBody.querySelector('tr') : null;
    const form = document.querySelector('form') || document.createElement('div');
    const STORAGE_KEY = 'salaryFormData_' + '{{ $user->id ?? "" }}';

    // Save the whole form to localStorage so user won't lose progress
    function saveFormData() {
        const formData = { rows: [] };
        
        document.querySelectorAll('#salaryRows tr').forEach(row => {
            const inputs = row.querySelectorAll('input, select');
            const rowData = {};
            
            inputs.forEach(input => {
                if (input.name && !input.disabled) {
                    rowData[input.name.replace('[]', '')] = input.value;
                }
            });
            
            formData.rows.push(rowData);
        });
        
        localStorage.setItem(STORAGE_KEY, JSON.stringify(formData));
    }

    // Load saved form from localStorage (if any) and populate rows
    function loadFormData() {
        const savedData = localStorage.getItem(STORAGE_KEY);
        if (!savedData) return;
        
        try {
            const formData = JSON.parse(savedData);
            
            // remove all rows except the first template row
            while (tableBody && tableBody.rows.length > 1) {
                tableBody.deleteRow(1);
            }
            
            // create rows from saved data and fill inputs
            formData.rows.forEach((rowData, index) => {
                const row = index === 0 ? (tableBody ? tableBody.rows[0] : null) : addNewRow();
                
                Object.entries(rowData).forEach(([name, value]) => {
                    const input = row && row.querySelector(`[name^="${name}"]`);
                    if (input) {
                        input.value = value;
                        // when payhead is filled, fire change so dependent fields update
                        if (input.classList.contains('payhead-input')) {
                            input.dispatchEvent(new Event('change'));
                        }
                    }
                });
            });
            
        } catch (e) {
            console.error('Error loading saved data:', e);
            localStorage.removeItem(STORAGE_KEY);
        }
    }

    // Default config for payheads — used to populate related fields automatically
    const payheadConfig = {
        'Basic': { type: 'Earnings', per: 'Month', calculation: 'Flat Amount' },
        'HRA':   { type: 'Earnings', per: 'Month', calculation: 'Percentage' },
        'DA':    { type: 'Earnings', per: 'Month', calculation: 'Percentage' },
        'TA':    { type: 'Earnings', per: 'Month', calculation: 'Flat Amount' },
        'Medical': { type: 'Earnings', per: 'Month', calculation: 'Flat Amount' },
        'PF':    { type: 'Deductions', per: 'Month', calculation: 'Percentage' },
        'TDS':   { type: 'Deductions', per: 'Month', calculation: 'Percentage' }
    };

    // Given a row and a payhead name, update the Type/Per/Calculation fields
    function fillRow(row, payhead) {
        const config = payheadConfig[payhead] || {};
        if (config.type) row.querySelector('[name="pay_head_type[]"]').value = config.type;
        if (config.per) row.querySelector('[name="per[]"]').value = config.per;
        if (config.calculation) row.querySelector('[name="calculation_type[]"]').value = config.calculation;
    }

    // clone the first row to add a new blank row and wire it up
    function addNewRow() {
        if (!firstRow || !firstRow.parentNode) return null;
        const newRow = firstRow.cloneNode(true);
        
        // reset any non-readonly inputs in the clone
        newRow.querySelectorAll('input, select').forEach(input => {
            if (input.type !== 'button' && !input.hasAttribute('readonly')) {
                input.value = '';
            }
        });
        
        firstRow.parentNode.appendChild(newRow);
        addRowEventListeners(newRow);
        
        const payheadInput = newRow.querySelector('.payhead-input');
        if (payheadInput) payheadInput.focus();
        
        return newRow;
    }
    
    // Attach listeners for payhead, rate, and delete inside a row
    function addRowEventListeners(row) {
        const payheadInput = row.querySelector('.payhead-input');
        const rateInput = row.querySelector('.rate-input');
        
        if (payheadInput) {
            payheadInput.addEventListener('change', handlePayheadChange);
            payheadInput.addEventListener('input', saveFormData);
        }
        
        if (rateInput) {
            rateInput.addEventListener('input', saveFormData);
            rateInput.addEventListener('keydown', handleRateKeydown);
        }
        
        const deleteBtn = row.querySelector('.deleteRow');
        if (deleteBtn) {
            deleteBtn.addEventListener('click', handleDeleteRow);
        }
    }

    // When payhead changes, auto-fill other fields and save progress
    function handlePayheadChange(e) {
        const row = e.target.closest('tr');
        fillRow(row, e.target.value);
        saveFormData();
        
        // move focus to rate field for quick entry
        const rateInput = row.querySelector('.rate-input');
        if (rateInput) rateInput.focus();
    }
    
    // pressing Enter while in Rate should add a new row (quick data entry)
    function handleRateKeydown(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addNewRow();
        }
    }
    
    // remove a row, or clear it if it's the last one
    function handleDeleteRow(e) {
        e.preventDefault();
        const row = e.target.closest('tr');
        if (tableBody && tableBody.querySelectorAll('tr').length > 1) {
            row.remove();
        } else {
            // clear inputs if only template row remains
            const inputs = row.querySelectorAll('input, select');
            inputs.forEach(input => {
                if (input.type !== 'button' && !input.hasAttribute('readonly') && !input.disabled) {
                    if (input.tagName === 'SELECT') {
                        input.selectedIndex = 0;
                    } else {
                        input.value = '';
                    }
                }
            });
        }
        saveFormData();
    }
    
    // Wire up listeners on page load and setup form hooks
    function setupEventListeners() {
        document.querySelectorAll('#salaryRows tr').forEach(row => {
            addRowEventListeners(row);
        });
        
        if (form) {
            form.addEventListener('submit', function() {
                // clear saved draft on successful submit
                localStorage.removeItem(STORAGE_KEY);
            });
        }
        
        // save on any input change (safe guard)
        document.addEventListener('input', function(e) {
            if (e.target.matches('input, select') && 
                !e.target.hasAttribute('readonly') && 
                !e.target.disabled) {
                saveFormData();
            }
        });
        
        // also save before leaving the page
        window.addEventListener('beforeunload', saveFormData);
    }
    
    // start up
    setupEventListeners();
    loadFormData();
});
</script>

<!-- Global click handler: add rows, delete rows, update counts -->
<script>
document.addEventListener('click', function(e) {
    // Handle Add Component button
    if (e.target.closest('.btn-add')) {
        const rowsContainer = document.querySelector('.table-rows');
        const firstRow = document.querySelector('.table-row');
        
        if (rowsContainer && firstRow) {
            const newRow = firstRow.cloneNode(true);
            
            // clear values and ensure inputs are enabled
            newRow.querySelectorAll('input, select').forEach(input => {
                if (input.type !== 'button') {
                    // Skip setting value for date input in new rows (rows after the first one)
                    if (input.type !== 'date' || rowsContainer.children.length === 0) {
                        input.value = input.tagName === 'SELECT' ? input.querySelector('option').value : '';
                    }
                    if (input.name && input.name.endsWith('[]')) {
                        // Reset the name to ensure it's unique in the form
                        input.name = input.name.replace(/\[\d*\]/, '') + '[]';
                    }
                }
            });
            
            // For new rows (after the first one), hide the date input
            if (rowsContainer.children.length > 0) {
                const dateCell = newRow.querySelector('.table-cell:first-child');
                if (dateCell) {
                    const dateInput = dateCell.querySelector('input[type="date"]');
                    if (dateInput) {
                        dateInput.value = '';
                        dateInput.readOnly = true;
                        dateInput.required = false;
                        dateInput.style.visibility = 'hidden';
                    }
                }
            }
            
            rowsContainer.appendChild(newRow);
            updateComponentsCount();
            
            // Scroll to the newly added row
            newRow.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }
    
    // Handle Add Another button
    if (e.target.closest('.btn-add-another')) {
        const rowsContainer = document.querySelector('.table-rows');
        const firstRow = document.querySelector('.table-row');
        
        if (rowsContainer && firstRow) {
            const newRow = firstRow.cloneNode(true);
            
            // Clear all input values
            newRow.querySelectorAll('input, select').forEach(input => {
                if (input.type !== 'button') {
                    input.value = input.tagName === 'SELECT' ? input.querySelector('option').value : '';
                    if (input.name && input.name.endsWith('[]')) {
                        // Reset the name to ensure it's unique in the form
                        input.name = input.name.replace(/\[\d*\]/, '') + '[]';
                    }
                    // Ensure date input is visible and enabled
                    if (input.type === 'date') {
                        input.readOnly = false;
                        input.required = true;
                        input.style.visibility = 'visible';
                    }
                }
            });
            
            rowsContainer.appendChild(newRow);
            updateComponentsCount();
            
            // Scroll to the newly added row
            newRow.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }
    
    // Delete a salary row or clear it if it's the last row
    if (e.target.closest('.delete-btn')) {
        const row = e.target.closest('.table-row');
        const rows = document.querySelectorAll('.table-row');
        
        if (rows.length > 1) {
            row.remove();
            updateComponentsCount();
        } else {
            row.querySelectorAll('input, select').forEach(input => {
                if (input.type !== 'button') {
                    input.value = input.tagName === 'SELECT' ? input.querySelector('option').value : '';
                }
            });
        }
    }
});
</script>

<!-- Reset button: keep a single blank row and clear it -->
<script>
document.getElementById('resetForm')?.addEventListener('click', function() {
    const rowsContainer = document.querySelector('.table-rows');
    const firstRow = document.querySelector('.table-row');
    
    if (!rowsContainer || !firstRow) return;
    
    // Remove all rows except the first one
    while (rowsContainer.children.length > 1) {
        rowsContainer.removeChild(rowsContainer.lastChild);
    }
    
    // Reset the first row
    firstRow.querySelectorAll('input, select').forEach(input => {
        if (input.type !== 'button') {
            // Reset value
            if (input.type === 'date') {
                input.value = '';
                input.readOnly = false;
                input.required = true;
                input.style.visibility = 'visible';
            } else if (input.tagName === 'SELECT') {
                input.value = input.querySelector('option').value;
            } else {
                input.value = '';
            }
            input.disabled = false;
        }
    });
    
    // Update the component count
    updateComponentsCount();
    
    updateComponentsCount();
    handleDropdownChanges();
});
</script>

<script>
/*
  handleDropdownChanges:
  - Disables the "Per" dropdown when the payhead is a deduction or calculated as percentage.
  - Adds listeners only once per select (uses dataset flag to avoid duplicate bindings).
*/
function handleDropdownChanges() {
    const rows = document.querySelectorAll('.salary-row');
    
    rows.forEach(row => {
        const perSelect = row.querySelector('select[name="per[]"]');
        const payHeadTypeSelect = row.querySelector('select[name="pay_head_type[]"]');
        const calculationTypeSelect = row.querySelector('select[name="calculation_type[]"]');
        
        function updatePerDropdownState() {
            if (!perSelect) return;
            
            const isDeduction = payHeadTypeSelect && payHeadTypeSelect.value === 'Deductions';
            const isPercentage = calculationTypeSelect && calculationTypeSelect.value === 'Percentage';
            
            if (isDeduction || isPercentage) {
                perSelect.disabled = true;
                perSelect.value = 'Month';
            } else {
                perSelect.disabled = false;
            }
        }
        
        // bind change listeners once
        if (payHeadTypeSelect && !payHeadTypeSelect.dataset.hasListener) {
            payHeadTypeSelect.addEventListener('change', updatePerDropdownState);
            payHeadTypeSelect.dataset.hasListener = 'true';
        }
        
        if (calculationTypeSelect && !calculationTypeSelect.dataset.hasListener) {
            calculationTypeSelect.addEventListener('change', updatePerDropdownState);
            calculationTypeSelect.dataset.hasListener = 'true';
        }
        
        // set initial state
        updatePerDropdownState();
    });
}
</script>

<script>
// Keep the component counter up to date in the footer
function updateComponentsCount() {
    const count = document.querySelectorAll('.table-row').length;
    const countElement = document.querySelector('.component-count');
    if (countElement) {
        countElement.textContent = `${count} component${count !== 1 ? 's' : ''} added`;
    }
}

// initial run
handleDropdownChanges();
updateComponentsCount();
</script>

<!-- small helper: focus the payhead input on page load for quick entry -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const payheadInput = document.querySelector('.payhead-input');
    if (payheadInput) {
        setTimeout(() => payheadInput.focus(), 100);
    }
});
</script>

<!-- keyboard UX: Enter on payhead moves to Rate -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    function attachPayheadEnterBehavior(row) {
        const payheadSelect = row.querySelector(".col.payhead select");
        if (payheadSelect && !payheadSelect.dataset.bound) {
            payheadSelect.addEventListener("keydown", function (e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                    const rateInput = row.querySelector(".col.rate input");
                    if (rateInput) {
                        rateInput.focus();
                        try { rateInput.select(); } catch (_) {}
                    }
                }
            });
            payheadSelect.dataset.bound = "true";
        }
    }

    document.querySelectorAll(".salary-row").forEach(row => attachPayheadEnterBehavior(row));

    // make sure dynamically added rows get the same behavior
    const originalAppendChild = Element.prototype.appendChild;
    Element.prototype.appendChild = function (child) {
        const result = originalAppendChild.call(this, child);
        if (child.classList && child.classList.contains("salary-row")) {
            attachPayheadEnterBehavior(child);
        }
        return result;
    };
});
</script>

<!-- keyboard UX: Enter on Rate moves to next row's Payhead or creates a new row -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    function attachRateEnterBehavior(row) {
        if (!row) return;
        const rateInput = row.querySelector('.col.rate input');
        if (!rateInput) return;
        if (rateInput.dataset.rateEnterBound) return;

        rateInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();

                const currentRow = row;
                let nextRow = currentRow.nextElementSibling;
                while (nextRow && !nextRow.classList.contains('salary-row')) {
                    nextRow = nextRow.nextElementSibling;
                }

                function focusPayheadIn(r) {
                    if (!r) return;
                    const payheadSelect = r.querySelector('.col.payhead select');
                    if (payheadSelect) {
                        payheadSelect.focus();
                        try { payheadSelect.select && payheadSelect.select(); } catch(_) {}
                    }
                }

                if (nextRow) {
                    focusPayheadIn(nextRow);
                    return;
                }

                const addBtn = document.querySelector('.add-row-btn');
                if (addBtn) {
                    addBtn.click();
                    setTimeout(function () {
                        const allRows = document.querySelectorAll('.salary-row');
                        const lastRow = allRows[allRows.length - 1];
                        focusPayheadIn(lastRow);
                        try { 
                            if (typeof handleDropdownChanges === 'function') handleDropdownChanges();
                            if (typeof updateComponentsCount === 'function') updateComponentsCount();
                        } catch(_) {}
                    }, 50);
                } else {
                    // fallback clone if add button isn't available
                    const firstRow = document.querySelector('.salary-row');
                    const rowsContainer = document.querySelector('.table-body');
                    if (firstRow && rowsContainer) {
                        const newRow = firstRow.cloneNode(true);
                        newRow.querySelectorAll('input, select').forEach(input => {
                            if (input.type !== 'button' && !input.hasAttribute('readonly')) {
                                if (input.tagName === 'SELECT') input.selectedIndex = 0;
                                else input.value = '';
                                input.disabled = false;
                            }
                        });
                        rowsContainer.appendChild(newRow);
                        setTimeout(() => {
                            focusPayheadIn(newRow);
                            try { if (typeof handleDropdownChanges === 'function') handleDropdownChanges(); } catch(_) {}
                        }, 30);
                    }
                }
            }
        });

        rateInput.dataset.rateEnterBound = 'true';
    }

    document.querySelectorAll('.salary-row').forEach(r => attachRateEnterBehavior(r));

    const container = document.querySelector('.table-body');
    if (container) {
        const mo = new MutationObserver(mutations => {
            for (const m of mutations) {
                for (const node of m.addedNodes) {
                    if (node.nodeType === 1 && node.classList.contains('salary-row')) {
                        attachRateEnterBehavior(node);
                    } else if (node.nodeType === 1 && node.querySelectorAll) {
                        node.querySelectorAll('.salary-row').forEach(r => attachRateEnterBehavior(r));
                    }
                }
            }
        });
        mo.observe(container, { childList: true, subtree: true });
    }

    (function () {
        const orig = Element.prototype.appendChild;
        Element.prototype.appendChild = function (child) {
            const res = orig.call(this, child);
            try {
                if (child && child.classList && child.classList.contains('salary-row')) {
                    attachRateEnterBehavior(child);
                } else if (child && child.querySelectorAll) {
                    child.querySelectorAll('.salary-row').forEach(r => attachRateEnterBehavior(r));
                }
            } catch (_) {}
            return res;
        };
    })();
});
</script>
