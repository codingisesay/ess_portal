     <!-- Custom admin styles -->
    <link rel="stylesheet" href="{{ asset('Offical_admin/css/official_admin.css') }}">
 
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
        <form id="subscriptionForm">

            <!-- Plan name input -->
            <div class="form-group">
                <label for="planName">Plan Name *</label>
                <input type="text" id="planName" name="planName" required>
            </div>

            <!-- Plan description input -->
            <div class="form-group">
                <label for="planDescription">Description</label>
                <textarea id="planDescription" name="planDescription" rows="3"></textarea>
            </div>

            <!-- Plan pricing input -->
            <div class="form-group">
                <label for="planPrice">Price (₹) *</label>
                <input type="number"
                       id="planPrice"
                       name="planPrice"
                       min="0"
                       step="0.01"
                       required>
            </div>

            <!-- Billing cycle selection -->
            <div class="form-group">
                <label for="billingCycle">Billing Cycle</label>
                <select id="billingCycle" name="billingCycle">
                    <option value="monthly">Monthly</option>
                    <option value="quarterly">Quarterly</option>
                    <option value="yearly">Yearly</option>
                </select>
            </div>

            <!-- Plan active status toggle -->
            <div class="form-group">
                <div class="checkbox-group">
                    <label class="checkbox-container">
                        <input type="checkbox" id="isActive" name="isActive" checked>
                        <span class="checkmark"></span>
                        Active
                    </label>
                </div>
            </div>

            <!-- Form action buttons -->
            <div class="form-actions">
                <button type="button"
                        id="cancelSubscription"
                        class="btn btn-cancel">
                    Cancel
                </button>

                <button type="submit"
                        class="btn btn-primary">
                    Create Plan
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
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = {
                planName: document.getElementById('planName').value,
                planDescription: document.getElementById('planDescription').value,
                planPrice: document.getElementById('planPrice').value,
                billingCycle: document.getElementById('billingCycle').value,
                isActive: document.getElementById('isActive').checked
            };
            
            console.log('Subscription plan form submitted:', formData);
            
            // For now, just hide the modal and reset the form
            hideModal();
            form.reset();
        });
    }
});
</script>
@endpush
