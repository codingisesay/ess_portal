     
     <!DOCTYPE html>
<html>
<head>
    <!-- Page title -->
<title>Admin Dashboard</title>
</head>
<body>
     <!-- Custom admin styles -->
    <link rel="stylesheet" href="{{ asset('Offical_admin/css/official_admin.css') }}">
 <!-- Subscription Module CSS -->
<link rel="stylesheet" href="{{ asset('Offical_admin/css/subscription_module.css') }}">

<!-- Add Font Awesome for icons (if not already included in your layout) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

 <!-- =========================
     ADD SUBSCRIPTION PLAN MODAL
     ========================= -->
<div id="subscriptionModal" class="modal">
    <!-- Modal content wrapper -->
    <div class="modal-content">

        <!-- Modal header -->
        <div class="modal-header">
            <h2>Add Subscription Plan</h2>

            <!-- Close button -->
            <span class="close-btn" id="closeSubscription">&times;</span>
        </div>
        <!-- div modal-header close -->

        <!-- Subscription plan creation form -->

                <form id="subscriptionForm" method="POST" action="{{ route('subscription.plans.save') }}">
            @csrf

            <!-- Plan Name -->
            <div class="subscription-form-group required">
                <input type="text" name="plan_name" id="plan_name" placeholder=" " required>
                <label for="plan_name">Plan Name</label>
            </div>

            <!-- Description -->
            <div class="subscription-form-group">
                <textarea name="description" id="description" placeholder=" " rows="3"></textarea>
                <!-- Added required (*) mark to all mandatory fields --> 
                <label for="description">Description
                    <span style="color: red;">*</span>
                </label>
            </div>

            <!-- Price Fields Row -->
            <div class="form-row">
                <div class="subscription-form-group">
                    <!-- Right-aligned and auto-formatted with commas as you type -->
                    <input type="text" inputmode="decimal" step="0.01" name="price_monthly" id="price_monthly" placeholder=" " style="text-align: right;">
                    <!-- Added required (*) mark to mandatory fields --> 
                    <label for="price_monthly">Price Monthly ($)
                        <span style="color: red;">*</span>
                    </label>
                </div>
                <div class="subscription-form-group">
                    <!-- Auto-formatted with commas as you type -->
                    <input type="text" inputmode="decimal" step="0.01" name="price_yearly" id="price_yearly" placeholder=" " style="text-align: right;">
                    <!-- Added required (*) mark to mandatory fields --> 
                    <label for="price_yearly">Price Yearly ($)
                        <span style="color: red;">*</span>
                    </label>
                </div>
            </div>



            <!-- Trial Days and Status Row -->
            <div class="form-row">  
                <div class="subscription-form-group">
                    <!-- Enter trial days: numbers only, up to 3 digits -->
                    <input type="number" name="trial_days" id="trial_days" placeholder=" " min="0" maxLength="3"
                    oninput="this.value = this.value.slice(0, 3)">
                    <!-- Added required (*) mark to all mandatory fields --> 
                    <label for="trial_days">Trial Days (0 for no trial)
                        <span style="color: red;">*</span>
                    </label>
                </div>
                <div class="subscription-form-group">
                    <select name="status" id="status" required>
                        <!-- Added the select option as default--> 
                        <option value="" disabled selected>Select</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                    <!-- Added required (*) mark to all mandatory fields --> 
                    <label for="status">Status
                        <span style="color: red;">*</span>
                    </label>
                </div>
            </div>

            <!-- Popular Plan Toggle -->
            <div class="subscription-form-group">
                <div class="popular-checkbox">
                    <input type="checkbox" name="is_popular" id="is_popular" value="1">
                    <label for="is_popular">Mark as Popular Plan</label>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="button" class="btn-cancel" id="cancelBtn">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Save Plan
                </button>
            </div>
                </form>
               <!-- form subscriptionForm close -->

                    </div>
                    <!-- div modal-content close -->
                </div>
                <!-- div subscriptionModal close -->

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get the modal and buttons
    const modal = document.getElementById('subscriptionModal');
    const btn = document.getElementById('addSubscriptionBtn');
    const closeBtn = modal ? modal.querySelector('#closeSubscription') : null;
    const cancelBtn = document.getElementById('cancelSubscription');
    const form = document.getElementById('subscriptionForm');

    // Get the Monthly Price input field element
    const priceMonthly = document.getElementById('price_monthly');
    // Get the Yearly Price input field element
    const priceYearly = document.getElementById('price_yearly');

    // Function to show modal
    function showModal() {
        if (modal) {
            modal.style.display = 'flex';
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
    }

    // Function to hide modal
    function hideModal() {
        if (modal) {
            modal.style.display = 'none';
            modal.classList.remove('show');
            document.body.style.overflow = '';
        }
    }

    // Add event listeners
    if (btn) {
        btn.addEventListener('click', showModal);
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', hideModal);
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', hideModal);
    }

    // Close when clicking outside the modal content
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            hideModal();
        }
    });

    // Close with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal && modal.classList.contains('show')) {
            hideModal();
        }
    });

    // Price formatting
    // takes the current input value and formats it with commas
    // adding commas for the seperators like 1,000
    function formatWithCommas(value) {
        if (value == null) return '';
        let v = String(value).replace(/,/g, '');
        v = v.replace(/[^0-9.]/g, '');
        const parts = v.split('.');
        const intPart = parts[0] || '';
        let decPart = parts[1] || '';
        if (decPart.length > 2) decPart = decPart.slice(0, 2);
        const withCommas = intPart.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        return decPart.length ? withCommas + '.' + decPart : withCommas;
    }


    // formats price fields with commas as we type.
    // Formats value while typing
    function bindPriceFormatting(inputEl) {
        if (!inputEl) return;
        inputEl.addEventListener('input', function() {
            const before = inputEl.value;
            const after = formatWithCommas(before);
            inputEl.value = after;
        });
        inputEl.addEventListener('blur', function() {
            inputEl.value = formatWithCommas(inputEl.value);
        });
    }

    bindPriceFormatting(priceMonthly);
    bindPriceFormatting(priceYearly);

    // Auto-calculate yearly price from monthly price
    function toNumber(val){
        if (val == null) return 0;
        const cleaned = String(val).replace(/,/g,'').trim();
        const n = parseFloat(cleaned);
        return isNaN(n) ? 0 : n;
    }

    function updateYearlyFromMonthly(){
        if (!priceMonthly || !priceYearly) return;
        const monthly = toNumber(priceMonthly.value);
        if (!monthly) { priceYearly.value = ''; return; }
        const yearly = (monthly * 12).toFixed(2);
        priceYearly.value = formatWithCommas(yearly);
    }

    if (priceMonthly) {
        priceMonthly.addEventListener('input', updateYearlyFromMonthly);
        priceMonthly.addEventListener('blur', updateYearlyFromMonthly);
    }


// Before submitting the form:
// - Remove commas from price values
// - Ensure backend receives clean numeric values
    if (form) {
        form.addEventListener('submit', function() {
            if (priceMonthly) priceMonthly.value = priceMonthly.value.replace(/,/g, '');
            if (priceYearly) priceYearly.value = priceYearly.value.replace(/,/g, '');
        });
    }
});
</script>
</body>
</html>
@endpush
