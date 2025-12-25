@extends('admin_view.admin_layout')

@section('content')
<link rel="stylesheet" href="{{ asset('Offical_admin/css/Subscription_plan_All_details.css') }}">

<div class="spad-page">
    <div class="spad-header">
        <div>
            <h2>Subscription Plans</h2>
            <p>Manage your subscription plans and pricing</p>
        </div>
        <a href="#" class="btn-primary">
            <i class="fas fa-plus"></i>
            <span>Add New Plan</span>
        </a>
    </div>

    <div class="spad-stats">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-dollar-sign"></i></div>
            <div class="stat-info">
                <div class="stat-title">Total Plans</div>
                <div class="stat-value">{{ $totalPlans }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-user-check"></i></div>
            <div class="stat-info">
                <div class="stat-title">Active Plans</div>
                <div class="stat-value">{{ $activePlans }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow"><i class="fas fa-fire"></i></div>
            <div class="stat-info">
                <div class="stat-title">Popular Plans</div>
                <div class="stat-value">{{ $popularPlans }}</div>
            </div>
        </div>
    </div>

<div class="spad-grid">
    @forelse($subscriptionPlans as $plan)
        <div class="plan-card {{ $plan->is_popular ? 'popular' : '' }}">
            
            {{-- Show "Most Popular" badge if plan is marked popular --}}
            @if($plan->is_popular)
                <div class="popular-bar">
                    <span><i class="fas fa-crown"></i> Most Popular</span>
                </div>
            @endif

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
        <p>No subscription plans found.</p>
    @endforelse
</div>

</div>
<!-- Edit Plan Modal -->
<div id="editPlanModal">
  <div>
    <div class="modal-header-row">
      <h3>Edit Subscription Plan</h3>
      <button id="closeEditPlan">&times;</button>
    </div>
    <form id="editPlanForm" method="POST" action="#">
      @csrf
      <div class="modal-grid">
        <div class="fl-group modal-grid-span">
          <input type="text" name="plan_name" id="ep_plan_name" class="form-control" placeholder=" " required>
          <label>Plan Name</label>
        </div>
        <div class="fl-group modal-grid-span">
          <textarea name="description" id="ep_description" class="form-control" rows="3" placeholder=" "></textarea>
          <label>Description</label>
        </div>
        <div class="fl-group">
          <input type="number" step="0.01" name="price_monthly" id="ep_price_monthly" class="form-control" placeholder=" ">
          <label>Price Monthly</label>
        </div>
        <div class="fl-group">
          <input type="number" step="0.01" name="price_yearly" id="ep_price_yearly" class="form-control" placeholder=" ">
          <label>Price Yearly</label>
        </div>
        <div class="fl-group">
          <input type="number" name="trial_days" id="ep_trial_days" class="form-control" min="0" placeholder=" ">
          <label>Trial Days</label>
        </div>
        <div class="fl-group">
          <select name="status" id="ep_status" class="form-control" required>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
          </select>
          <label>Status</label>
        </div>
        <div class="modal-inline">
          <input type="checkbox" id="ep_is_popular" name="is_popular" value="1">
          <label for="ep_is_popular">Mark as Popular</label>
        </div>
      </div>
      <div class="modal-actions">
        <button type="button" id="cancelEditPlan" class="btn-secondary">Cancel</button>
        <button type="submit" class="btn-primary">Save Changes</button>
      </div>
    </form>
  </div>
  </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const modal = document.getElementById('editPlanModal');
  const closeBtn = document.getElementById('closeEditPlan');
  const cancelBtn = document.getElementById('cancelEditPlan');
  const form = document.getElementById('editPlanForm');

  function openModal() {
    if (modal) {
      modal.style.display = 'flex';
      document.body.style.overflow = 'hidden';
    }
  }
  function closeModal() {
    if (modal) {
      modal.style.display = 'none';
      document.body.style.overflow = '';
    }
  }

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

      document.getElementById('ep_plan_name').value = name;
      document.getElementById('ep_description').value = description;
      document.getElementById('ep_price_monthly').value = pm;
      document.getElementById('ep_price_yearly').value = py;
      document.getElementById('ep_trial_days').value = trial;
      document.getElementById('ep_status').value = status;
      document.getElementById('ep_is_popular').checked = isPopular;

      form.action = "{{ url('/subscription-plans/update') }}/" + id;
      openModal();
    });
  });

  if (closeBtn) closeBtn.addEventListener('click', closeModal);
  if (cancelBtn) cancelBtn.addEventListener('click', closeModal);
  window.addEventListener('click', function(e){ if (e.target === modal) closeModal(); });
  document.addEventListener('keydown', function(e){ if (e.key === 'Escape' && modal && modal.style.display === 'flex') closeModal();});
});
</script>
@endsection
