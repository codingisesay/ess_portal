@extends('admin_view.admin_layout')

@section('content')
<!-- Subscription Plan All Details css -->
<link rel="stylesheet" href="{{ asset('Offical_admin/css/Subscription_plan_All_details.css') }}">

<!-- Main page wrapper -->
<div class="spad-page">

<!-- Page header section -->
    <div class="spad-header">
        <div>
            <h2>Subscription Plans</h2>
            <p>Manage your subscription plans and pricing</p>
        </div>
    </div>
    <!-- Page header section end -->

    <!-- Page stats section which shows total plans, active plans and popular plans -->
    <div class="spad-stats">
      <!-- Total Plans show on subscription plan page -->
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-dollar-sign"></i></div>
            <div class="stat-info">
                <div class="stat-title">Total Plans</div>
                <div class="stat-value">{{ $totalPlans }}</div>
            </div>
        </div>
        <!-- Active Plans show on subscription plan page -->
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-user-check"></i></div>
            <div class="stat-info">
                <div class="stat-title">Active Plans</div>
                <div class="stat-value">{{ $activePlans }}</div>
            </div>
        </div>
        <!-- Popular Plans show on subscription plan page -->
        <div class="stat-card">
            <div class="stat-icon yellow"><i class="fas fa-fire"></i></div>
            <div class="stat-info">
                <div class="stat-title">Popular Plans</div>
                <div class="stat-value">{{ $popularPlans }}</div>
            </div>
        </div>
    </div>
    <!-- Page stats section end -->

    <!-- Page grid section which shows all subscription plans -->
<div class="spad-grid">
   <!-- Loop through each subscription plan -->
    @forelse($subscriptionPlans as $plan)
        <div class="plan-card {{ $plan->is_popular ? 'popular' : '' }}">
            
            {{-- Top bar area keeps consistent header UI for all cards --}}
            @if($plan->is_popular)
                <div class="popular-bar">
                    <span><i class="fas fa-crown"></i> Most Popular</span>
                </div>
            @else
            <!-- empty Popular Plans show on subscription plan page -->
                <div class="popular-bar muted"></div>
            @endif
            <!-- Plan Header -->
            <div class="plan-head">
                <h3>{{ $plan->plan_name }}</h3>

                {{-- Plan Status --}}
                @if($plan->status === 'Active')
                    <span class="badge success">Active</span>
                @else
                    <span class="badge warning">Inactive</span>
                @endif
            </div>

            {{-- Plan Description --}}
            <p class="plan-sub">
                {{ $plan->description ?? 'No description available' }}
            </p>

            {{-- Monthly Price --}}
            <div class="plan-price">
                <span class="amount">₹{{ number_format($plan->price_monthly) }}</span>
                <span class="per">/month</span>
            </div>

            {{-- Yearly Price --}}
            <div class="plan-year">
                or ₹{{ number_format($plan->price_yearly) }}/year
                (save ₹{{ number_format(max(0, ($plan->price_monthly * 12) - $plan->price_yearly)) }})
            </div>

            {{-- Plan Features --}}
            <ul class="plan-features">
                <li>
                    <i class="fas fa-check"></i>
                    {{ $plan->trial_days }} days trial period
                </li>
            </ul>

            {{-- Actions --}}
            <div class="plan-actions">
                <button class="btn-lite sp-edit-btn"
                    data-id="{{ $plan->id }}"
                    data-name="{{ $plan->plan_name }}"
                    data-description="{{ $plan->description }}"
                    data-price_monthly="{{ $plan->price_monthly }}"
                    data-price_yearly="{{ $plan->price_yearly }}"
                    data-trial_days="{{ $plan->trial_days }}"
                    data-status="{{ $plan->status }}"
                    data-is_popular="{{ (int) $plan->is_popular }}">
                    <i class="fas fa-pen"></i> Edit
                </button>
            </div>

        </div>
    @empty
     <!-- Message shown when no plans exist -->
        <p>No subscription plans found.</p>
    @endforelse
</div>

</div>

<!-- ================= Edit Plan Modal ================= -->
<div id="editPlanModal">
  <div>

   <!-- Modal header -->
    <div class="modal-header-row">
      <h3>Edit Subscription Plan</h3>
      <!-- Close modal button -->
      <button id="closeEditPlan">&times;</button>
    </div>

     <!-- Edit form -->
    <form id="editPlanForm" method="POST" action="#">
      @csrf
       <!-- Modal form grid -->
      <div class="modal-grid">

        <!-- Plan name input -->
        <div class="fl-group modal-grid-span">
          <input type="text" name="plan_name" id="ep_plan_name" class="form-control" placeholder=" " required>
          <label>Plan Name
            <span style="color: red;">*</span>
          </label>
        </div>

        <!-- Plan description input -->
        <div class="fl-group modal-grid-span">
          <textarea name="description" id="ep_description" class="form-control" rows="3" placeholder=" "></textarea>
          <label>Description
            <span style="color: red;">*</span>
          </label>
        </div>

        <!-- Plan monthly price input -->
        <div class="fl-group">
          <input type="number" step="0.01" name="price_monthly" id="ep_price_monthly" class="form-control" placeholder=" " style="text-align: right;">
          <label>Price Monthly
            <span style="color: red;">*</span>
          </label>
        </div>

        <!-- Plan yearly price input -->
        <div class="fl-group">
          <input type="number" step="0.01" name="price_yearly" id="ep_price_yearly" class="form-control" placeholder=" " style="text-align: right;">
          <label>Price Yearly
            <span style="color: red;">*</span>
          </label>
        </div>

        <!-- Plan trial days input -->
        <div class="fl-group">
          <input type="number" name="trial_days" id="ep_trial_days" class="form-control" min="0" placeholder=" " maxLength="3"
                    oninput="this.value = this.value.slice(0, 3)">
          <label>Trial Days
            <span style="color: red;">*</span>
          </label>
        </div>

        <!-- Plan status input -->
        <div class="fl-group">
          <select name="status" id="ep_status" class="form-control" required>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
          </select>
          <label>Status
            <span style="color: red;">*</span>
          </label>
        </div>

        <!-- Plan popular input -->
        <div class="modal-inline">
          <input type="checkbox" id="ep_is_popular" name="is_popular" value="1">
          <label for="ep_is_popular">Mark as Popular</label>
        </div>
      </div>

      <!-- Modal actions -->
      <div class="modal-actions">
        <button type="button" id="cancelEditPlan" class="btn-secondary">Cancel</button>
        <button type="submit" class="btn-primary">Save Changes</button>
      </div>
    </form>
    <!-- form end -->
  </div> <!-- close div normal div-->
  </div> <!-- close div modal -->

<script>
document.addEventListener('DOMContentLoaded', function() {
  // the Edit Plan modal element
  const modal = document.getElementById('editPlanModal');
  // the close button element
  const closeBtn = document.getElementById('closeEditPlan');
  // the cancel button element
  const cancelBtn = document.getElementById('cancelEditPlan');
  // the form element
  const form = document.getElementById('editPlanForm');
  // the monthly price input element
  const monthlyInput = document.getElementById('ep_price_monthly');
  const yearlyInput = document.getElementById('ep_price_yearly');

  // Create an number formatter so values show like 1,00,000 
  const inrFormatter = new Intl.NumberFormat('en-IN', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
  // Turn a string like "1,00,000" back into a plain number we can do math with
  function unformatNumber(val) {
    if (val === null || val === undefined) return NaN;
    const s = String(val).replace(/,/g, '').trim();
    const n = parseFloat(s);
    return isNaN(n) ? NaN : n;
  }
  // Format any given value using the numbering system for a friendlier display
  function formatINR(val) {
    const n = typeof val === 'number' ? val : unformatNumber(val);
    if (isNaN(n) || !isFinite(n)) return '';
    return inrFormatter.format(n);
  }
  // Inputs of type "number" do not display commas, so we switch to text when we want commas visible
  function setAsText(input) {
    if (input && input.type !== 'text') input.type = 'text';
  }
  // Before submitting, we switch inputs back to type "number" so clean numeric values are sent to backend
  function setAsNumber(input) {
    if (input && input.type !== 'number') input.type = 'number';
  }

  // Show the Edit Plan modal
  function openModal() {
    if (modal) {
      modal.style.display = 'flex';
      document.body.style.overflow = 'hidden';
    }
  }
  // Hide the Edit Plan modal
  function closeModal() {
    if (modal) {
      modal.style.display = 'none';
      document.body.style.overflow = '';
    }
  }
  

  // auto calculate yearly price from monthly
  function computeYearlyFromMonthly() {
    if (!monthlyInput || !yearlyInput) return;
    const m = unformatNumber(monthlyInput.value);
    if (!isNaN(m) && isFinite(m)) {
      const y = Math.max(0, m * 12);
      // Update yearly in the UI
      yearlyInput.value = formatINR(Math.round(y));
    } else {
      yearlyInput.value = '';
    }
  }

  // As the user types the monthly price, keep it formatted and update the yearly price
  function formatMonthlyLiveAndCompute() {
    if (!monthlyInput) return;
    setAsText(monthlyInput);
    const raw = unformatNumber(monthlyInput.value);
    monthlyInput.value = isNaN(raw) ? '' : formatINR(raw);
    computeYearlyFromMonthly();
  }

  if (monthlyInput) {
    // ensure text type so commas are visible
    setAsText(monthlyInput);
    // If there's already a value, format it once when the modal opens
    if (monthlyInput.value) monthlyInput.value = formatINR(monthlyInput.value);
    monthlyInput.addEventListener('input', formatMonthlyLiveAndCompute);
    monthlyInput.addEventListener('change', formatMonthlyLiveAndCompute);
  }

  // Keep the yearly price formatted with commas if the user edits it directly
  function formatYearlyLive() {
    if (!yearlyInput) return;
    setAsText(yearlyInput);
    const raw = unformatNumber(yearlyInput.value);
    yearlyInput.value = isNaN(raw) ? '' : formatINR(raw);
  }
  if (yearlyInput) {
    // ensure text type so commas are visible
    setAsText(yearlyInput);
    // If there's already a value, format it once when the modal opens
    if (yearlyInput.value) yearlyInput.value = formatINR(yearlyInput.value);
    yearlyInput.addEventListener('input', formatYearlyLive);
    yearlyInput.addEventListener('change', formatYearlyLive);
  }

  // When the user clicks an Edit button on a plan card, load its data into the modal and show it
  document.querySelectorAll('.sp-edit-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const id = this.dataset.id;
      const name = this.dataset.name || '';
      const description = this.dataset.description || '';
      const pm = this.dataset.price_monthly || '';
      const py = this.dataset.price_yearly || '';
      const trial = this.dataset.trial_days || '';
      const status = this.dataset.status || 'Active';
      const isPopular = parseInt(this.dataset.is_popular || '0', 10) === 1;

      // Copy raw values onto the form fields
      document.getElementById('ep_plan_name').value = name;
      document.getElementById('ep_description').value = description;
      document.getElementById('ep_price_monthly').value = pm;
      document.getElementById('ep_price_yearly').value = py;
      document.getElementById('ep_trial_days').value = trial;
      document.getElementById('ep_status').value = status;
      document.getElementById('ep_is_popular').checked = isPopular;

      // Point the form to the correct update URL for the selected plan
      form.action = "{{ url('/subscription-plans/update') }}/" + id;
      // Immediately show the monthly price with commas when the modal opens
      if (monthlyInput) {
        setAsText(monthlyInput);
        if (pm) monthlyInput.value = formatINR(pm);
      }
      // Immediately show the yearly price with commas when the modal opens
      if (yearlyInput) {
        setAsText(yearlyInput);
        if (py) yearlyInput.value = formatINR(py);
      }
      // If yearly price is empty or zero, prefill based on monthly
      if (yearlyInput && (!yearlyInput.value || parseFloat(yearlyInput.value) === 0)) {
        computeYearlyFromMonthly();
      }
      openModal();
    });
  });

  // Basic close interactions: close button, cancel button, outside click, and Escape key
  if (closeBtn) closeBtn.addEventListener('click', closeModal);
  if (cancelBtn) cancelBtn.addEventListener('click', closeModal);
  window.addEventListener('click', function(e){ if (e.target === modal) closeModal(); });
  document.addEventListener('keydown', function(e){ if (e.key === 'Escape' && modal && modal.style.display === 'flex') closeModal();});

  // Just before we submit the form, strip commas and switch inputs back to number
  // so the backend gets clean numeric values (e.g., "100000" instead of "1,00,000")
  if (form) {
    form.addEventListener('submit', function() {
      if (monthlyInput) {
        const m = unformatNumber(monthlyInput.value);
        setAsNumber(monthlyInput);
        monthlyInput.value = isNaN(m) ? '' : String(m.toFixed(2));
      }
      if (yearlyInput) {
        const y = unformatNumber(yearlyInput.value);
        setAsNumber(yearlyInput);
        yearlyInput.value = isNaN(y) ? '' : String(Math.round(y));
      }
    });
  }
});
</script>
@endsection
