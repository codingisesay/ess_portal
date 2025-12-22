     
     <!DOCTYPE html>
<html>
<head>
<title>Add Subscription Plan</title>
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
                <label for="description">Description</label>
            </div>

            <!-- Price Fields Row -->
            <div class="form-row">
                <div class="subscription-form-group">
                    <input type="number" step="0.01" name="price_monthly" id="price_monthly" placeholder=" ">
                    <label for="price_monthly">Price Monthly ($)</label>
                </div>
                <div class="subscription-form-group">
                    <input type="number" step="0.01" name="price_yearly" id="price_yearly" placeholder=" ">
                    <label for="price_yearly">Price Yearly ($)</label>
                </div>
            </div>



            <!-- Trial Days and Status Row -->
            <div class="form-row">  
                <div class="subscription-form-group">
                    <input type="number" name="trial_days" id="trial_days" placeholder=" " min="0">
                    <label for="trial_days">Trial Days (0 for no trial)</label>
                </div>
                <div class="subscription-form-group">
                    <select name="status" id="status" required>
                        <option value="" disabled selected></option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                    <label for="status">Status</label>
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

    // Handle form submission
    if (form) {
        form.addEventListener('', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = {
                planName: document.getElementById('planName').value,
                planDescription: document.getElementById('planDescription').value,
                planPrice: document.getElementById('planPrice').value,
                billingCycle: document.getElementById('billingCycle').value,
                isActive: document.getElementById('isActive').checked
            };
           
            
            // For now, just hide the modal and reset the form
            hideModal();
            form.reset();
        });
    }
});
</script>
</body>
</html>
@endpush
