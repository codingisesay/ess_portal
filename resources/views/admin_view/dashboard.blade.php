<!-- added the layout sidebar inside a dashboard  -->
@extends('admin_view.admin_layout')

    <!-- Include Add Client Module -->
    @include('admin_view.Add_client_module')
    
    <!-- Include Notification Module -->
    @include('admin_view.notification_module')
    
    <!-- Include Subscription Plan Module -->
    @include('admin_view.subscription_plan_module')

    @include('admin_view.client_details_popup')


{{-- Main content section starts --}}    
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- =========================
     DASHBOARD CONTAINER
     ========================= -->

        <!-- =========================
         MAIN CONTENT AREA
         ========================= -->

        <!-- Dashboard header -->
            <header class="header">
                <div>
                    <h1 class="header-title">Dashboard</h1>
                    <p class="header-subtitle">Welcome back, Admin</p>
                </div>
            </header>

             <!-- =========================
             STATS SUMMARY CARDS
             ========================= -->
            <div class="stats-grid">
                <!-- Total clients -->
                 <!-- it is used for getting a count of total clients -->
                 @php
                    $totalClients = \DB::table('organisations')->count();
                    @endphp
                <div class="stat-card stat-card-blue">
                    <div class="stat-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>

                    <!-- changes made to get count of total clients -->
                    <div class="stat-details">
                        <h3>{{ $totalClients }}</h3>
                        <p>Total Clients</p>
                    </div>
                </div>

                <!-- Active clients -->
                @php
                $activeClients = \DB::table('organisations')->where('status', '=', 1)->count();
                @endphp
                <div class="stat-card stat-card-green">
                    <div class="stat-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    
                    <!-- changes made to get count of active clients -->
                    <div class="stat-details">
                        <h3>
                            {{ $activeClients }}
                        </h3>
                        <p>Active</p>
                    </div>
                </div>

                <!-- Expiring soon clients -->
                <div class="stat-card stat-card-orange">
                    <div class="stat-icon">
                        <i class="fas fa-exclamation"></i>
                    </div>
                    <div class="stat-details">
                        <h3>1</h3>
                        <p>Expiring Soon</p>
                    </div>
                </div>
            </div>

            <!-- =========================
            dashboard Body
            ========================= -->
            <div class="dashboard-content">
                <!-- =========================
                main-content-2
                ========================= -->
                <div class="main-content-2">
                    <!-- Clients overview header -->
                    <div class="section-header">
                        <h2>Clients Overview</h2>
                        <a href="#" class="view-all">View All</a>
                    </div>
                    
                    <!-- Clients grid where all clients are displayed -->
                    <div class="clients-grid">

                      <!-- Loop through organisations -->
                        @forelse ($organisations as $org)
                            @php
                                // Initials (AC, TI, etc.)
                                $initials = collect(explode(' ', $org->name))
                                    ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
                                    ->take(2)
                                    ->implode('');

                                // Storage %
                                $storage = (int) ($org->storage_used_percent ?? 0);

                                // Status handling (1 = Active, 0 = Inactive)
                                $statusClass = ((int) ($org->status ?? 0) === 1)
                                    ? 'active'
                                    : 'inactive';

                                // subscription plan name from plans collection
                                $planName = optional(collect($subscriptionPlans)->firstWhere('id', $org->software_package_plan))->plan_name ?? '—';
                            @endphp


                             <!-- Avatar with initials -->
                              <!-- used the right column name for mobile number (mobile) -->
                               <!-- getting the current value of software package id -->
                            <div class="client-card"
                                 data-client-id="{{ $org->id }}"
                                 data-email="{{ $org->email ?? '' }}"
                                 data-phone="{{ $org->mobile ?? '' }}"
                                 data-package-id="{{ $org->software_package_plan ?? '' }}"
                                 data-package="{{ $planName }}">
                                <div class="client-avatar client-avatar-blue">
                                    {{ $initials }}
                                </div>

                                <!-- Client details -->
                                <div class="client-info">
                                    <h3>{{ $org->name }}</h3>
                                    <p>
                                        {{ $org->contact_person ?? '—' }}
                                    </p>
 
                                </div>
                                 <!-- Client status -->
                                <div class="client-status {{ $statusClass }}">
                                    {{ ucfirst($statusClass) }}
                                </div>
                            </div>
 
                        @empty
                        <!-- Message when no data is available -->
                        <p>No organisations found.</p>
                        @endforelse
                    </div>
                </div>
                <!-- end of main-content-2 -->


                <!-- =========================
                 RIGHT SIDEBAR PANEL
                 ========================= -->
                <div class="sidebar-content">

                <!-- Quick actions -->
                    <div class="quick-actions">
                        <h3>Quick Actions</h3>
                        <button id="addClientBtn" class="action-btn primary">
                             <!-- new client is getting add from here -->
                            <i class="fas fa-plus"></i> Add New Client
                        </button>
                        <button id="sendNotificationBtn" class="action-btn secondary">
                            <!-- notification is getting send from here -->
                            <i class="fas fa-paper-plane"></i> Send Notification
                        </button>
                    </div>
                     <!-- div quick-actions close -->


                     <!-- Expiring clients section -->
                    <div class="expiring-soon">
                        <div class="section-header">
                            <h3>Expiring Soon</h3>
                        </div>
                        <div class="expiring-card">
                            <div class="expiring-avatar" style="background-color: #e8f5e9; color: #388e3c;">TI</div>
                            <div class="expiring-info">
                                <h4>TechStart</h4>
                                <p>2024-12-25</p>
                            </div>
                            <a href="#" class="view-details">View Details</a>
                        </div>
                    </div>
                  <!-- div expiring-soon close -->

                  <!-- Subscription Plans section -->
                  <div class="quick-actions">
                        <div class="section-header">
                            <h3>Subscription Plans</h3>
                            <a href="#" class="view-all-2">View All</a>
                        </div>
                        <!-- Subscription plan add from here -->
                        <button id="addSubscriptionBtn" class="action-btn secondary">
                            <i class="fas fa-plus-circle"></i> Add Subscription Plan
                        </button>
                    </div>  <!-- div quick-actions close -->
                </div> <!-- sidebar-content close -->
            </div> <!-- main-content-2 close -->
    </div> <!-- dashboard-content close -->


    
    <!-- Scripts will be pushed here by child views -->
    @stack('scripts')
    
    <!-- SUCCESS MODAL -->
    <div id="successModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Success</h2>
                <span class="close-btn" id="closeSuccess">&times;</span>
            </div>
            <p>Client added successfully</p>
            <button id="successOkBtn" class="btn btn-primary">OK</button>
        </div>
    </div> 

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Close success modal
            const closeSuccessBtn = document.getElementById('closeSuccess');
            if (closeSuccessBtn) {
                closeSuccessBtn.addEventListener('click', function() {

                    
                    const successModal = document.getElementById('successModal');
                    if (successModal) {
                        successModal.style.display = 'none';
                        successModal.classList.remove('show');
                    }
                });
            }

            const successOkBtn = document.getElementById('successOkBtn');
            if (successOkBtn) {
                successOkBtn.addEventListener('click', function() {
                    const successModal = document.getElementById('successModal');
                    if (successModal) {
                        successModal.style.display = 'none';
                    }
                });
            }

        
            // Handle Users nav item click to show Clients Overview in full view
            const usersNavLink = document.querySelector('li[title="Users"] a.nav-link');
            if (usersNavLink) {
                usersNavLink.addEventListener('click', function(e) {
                    // Allow default navigation to Client_all_details page
                });
            }
        });
    </script>
     <!-- added sweetalert2 script for sending expiry notification to all clients -->
   <script>
document.getElementById('sendNotificationBtn').addEventListener('click', function () {

    Swal.fire({
        title: 'Are you sure?',
        text: 'Send expiry notifications to all clients?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, send it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (!result.isConfirmed) return;

        fetch("{{ route('admin.sendExpiryMails') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json",
                "Content-Type": "application/json"
            }
        })
        .then(response => response.json())
        .then(data => {
            Swal.fire({
                icon: 'success',
                title: 'Done!',
                text: data.message
            });
        })
        .catch(error => {
            console.error(error);
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: 'Something went wrong'
            });
        });
    });
});
</script>


@endsection
{{-- Main content section ends --}}
