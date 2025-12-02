{{-- Load page-specific CSS --}}
<link rel="stylesheet" href="{{ asset('/user_end/css/salaryDetailsCreation.css') }}">

<!-- container div  -->
<div class="container mt-4">

{{-- Page Title --}}
    <h2 class="mb-3">Create Salary Details</h2>
     {{-- Employee Information --}}
     <!-- div start -->
    <div class="employee-info">
        <p>
             {{-- Employee ID Display --}}
            <strong>Employee ID:</strong>
            <span id="employee_id">{{ $user->employeeID ?? 'N/A' }}</span>
        </p>
        <p>
            {{-- Employee Name Display --}}
            <strong>Employee Name:</strong>
            <span id="employee_name">{{ $user->name ?? 'N/A' }}</span>
        </p>
    </div> 
    <!-- div end -->

    <!-- Salary Table Section -->
    <div class="salary-section">
        <!-- Sticky Header -->
        <div class="salary-table-header">
            <div>Effective From</div>
            <div>Payhead</div>
            <div>Rate</div>
            <div>Per</div>
            <div>Pay Head Type</div>
            <div>Calculation Type</div>
            <div>Computed On</div>
            <div>Action</div>
        </div>
        
        <!-- Table Container -->
        <div class="salary-table-container">
            <table class="salary-table" id="salaryTable">
                <tbody id="salaryRows">
                    <tr>
                        <td>
                            <input type="date" 
                                   name="effective_from[]" 
                                   class="salary-input" 
                                   required>
                        </td>
                        <td>
                            <input type="text" 
                                   name="payhead[]" 
                                   class="salary-input payhead-input" 
                                   placeholder="e.g. Basic, HRA" 
                                   list="payheadOptions"
                                   autocomplete="off"
                                   required>
                        </td>
                        <td>
                            <input type="number" 
                                   name="rate[]" 
                                   class="salary-input rate-input"
                                   step="0.01"
                                   required>
                        </td>
                        <td>
                            <select name="per[]" class="salary-input" disabled>
                                <option value="Month">Month</option>
                                <option value="Day">Day</option>
                                <option value="Hour">Hour</option>
                            </select>
                        </td>
                        <td>
                            <select name="pay_head_type[]" class="salary-input" disabled>
                                <option value="Earnings">Earnings</option>
                                <option value="Deductions">Deductions</option>
                            </select>
                        </td>
                        <td>
                            <select name="calculation_type[]" class="salary-input" disabled>
                                <option value="Flat Amount">Flat Amount</option>
                                <option value="Percentage">Percentage</option>
                                <option value="As Per Attendance">As Per Attendance</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" 
                                   name="computed_on[]" 
                                   class="salary-input" 
                                   placeholder="e.g. Basic"
                                   required>
                        </td>
                        <td class="text-center">
                            <button type="button" class="deleteRow">×</button>
                        </td>
                    </tr>
                </tbody>
        
        <!-- Add this datalist for payhead autocomplete -->
        <datalist id="payheadOptions">
            <option value="Basic">
            <option value="HRA">
            <option value="DA">
            <option value="TA">
            <option value="Medical">
            <option value="PF">
            <option value="TDS">
        </datalist>
    </table>



</div> 
<!-- div end -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.getElementById('salaryRows');
    const firstRow = tableBody.querySelector('tr');
    const form = document.querySelector('form') || document.createElement('div');
    const STORAGE_KEY = 'salaryFormData_' + '{{ $user->id ?? "" }}';

    // Function to save form data to localStorage
    function saveFormData() {
        const formData = {
            rows: []
        };
        
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

    // Function to load form data from localStorage
    function loadFormData() {
        const savedData = localStorage.getItem(STORAGE_KEY);
        if (!savedData) return;
        
        try {
            const formData = JSON.parse(savedData);
            
            // Clear existing rows except the first one
            while (tableBody.rows.length > 1) {
                tableBody.deleteRow(1);
            }
            
            // Add saved rows
            formData.rows.forEach((rowData, index) => {
                const row = index === 0 ? tableBody.rows[0] : addNewRow();
                
                Object.entries(rowData).forEach(([name, value]) => {
                    const input = row.querySelector(`[name^="${name}"]`);
                    if (input) {
                        input.value = value;
                        // Trigger change event for autofill to work
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

    // Payhead configuration with default values
    const payheadConfig = {
        'Basic': { 
            type: 'Earnings', 
            per: 'Month', 
            calculation: 'Flat Amount' 
        },
        'HRA': { 
            type: 'Earnings', 
            per: 'Month', 
            calculation: 'Percentage' 
        },
        'DA': { 
            type: 'Earnings', 
            per: 'Month', 
            calculation: 'Percentage' 
        },
        'TA': { 
            type: 'Earnings', 
            per: 'Month', 
            calculation: 'Flat Amount' 
        },
        'Medical': { 
            type: 'Earnings', 
            per: 'Month', 
            calculation: 'Flat Amount' 
        },
        'PF': { 
            type: 'Deductions', 
            per: 'Month', 
            calculation: 'Percentage' 
        },
        'TDS': { 
            type: 'Deductions', 
            per: 'Month', 
            calculation: 'Percentage' 
        }
    };

    // Function to fill row based on payhead
    function fillRow(row, payhead) {
        const config = payheadConfig[payhead] || {};
        if (config.type) row.querySelector('[name="pay_head_type[]"]').value = config.type;
        if (config.per) row.querySelector('[name="per[]"]').value = config.per;
        if (config.calculation) row.querySelector('[name="calculation_type[]"]').value = config.calculation;
    }

    // Function to add a new row
    function addNewRow() {
        const newRow = firstRow.cloneNode(true);
        
        // Clear all input values in the new row
        newRow.querySelectorAll('input, select').forEach(input => {
            if (input.type !== 'button' && !input.hasAttribute('readonly')) {
                input.value = '';
            }
        });
        
        tableBody.appendChild(newRow);
        
        // Add event listeners to the new row
        addRowEventListeners(newRow);
        
        // Focus on the payhead input of the new row
        const payheadInput = newRow.querySelector('.payhead-input');
        if (payheadInput) payheadInput.focus();
        
        return newRow;
    }
    
    // Add event listeners to a row
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

    // Event handlers
    function handlePayheadChange(e) {
        const row = e.target.closest('tr');
        fillRow(row, e.target.value);
        saveFormData();
        
        // Move focus to rate input
        const rateInput = row.querySelector('.rate-input');
        if (rateInput) rateInput.focus();
    }
    
    function handleRateKeydown(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addNewRow();
        }
    }
    
    function handleDeleteRow(e) {
        e.preventDefault();
        const row = e.target.closest('tr');
        if (tableBody.querySelectorAll('tr').length > 1) {
            row.remove();
        } else {
            // If it's the last row, just clear the inputs
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
    
    // Add event listeners to the form
    function setupEventListeners() {
        // Add event listeners to existing rows
        document.querySelectorAll('#salaryRows tr').forEach(row => {
            addRowEventListeners(row);
        });
        
        // Add form submit handler
        if (form) {
            form.addEventListener('submit', function() {
                // Clear saved data on successful form submission
                localStorage.removeItem(STORAGE_KEY);
            });
        }
        
        // Save form data on input changes
        document.addEventListener('input', function(e) {
            if (e.target.matches('input, select') && 
                !e.target.hasAttribute('readonly') && 
                !e.target.disabled) {
                saveFormData();
            }
        });
        
        // Handle page unload to save data
        window.addEventListener('beforeunload', saveFormData);
    }
    
    // Initialize the page
    setupEventListeners();
    loadFormData();
});
</script>
</div> 
<!-- end of container -->

<script>
// cursor to the Payhead input field when the page loads
document.addEventListener('DOMContentLoaded', function() {
    const payheadInput = document.querySelector('.payhead-input');
    if (payheadInput) {
        setTimeout(() => {
            payheadInput.focus();
        }, 100); // Small delay to ensure everything is loaded
    }
});
</script>
