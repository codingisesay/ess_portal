
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- Page title -->
    <title>Admin Dashboard</title>
    <!-- Custom admin styles -->
    <link rel="stylesheet" href="{{ asset('Offical_admin/css/official_admin.css') }}">
    <!-- Font Awesome icons -->
    <link rel="stylesheet" href="{{ asset('Offical_admin/css/create_user_popup.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

    <!-- Include Add Client Module -->
    @include('admin_view.Add_client_module')
    
    <!-- Include Notification Module -->
    @include('admin_view.notification_module')
    
    <!-- Include Subscription Plan Module -->
    @include('admin_view.subscription_plan_module')

    @include('admin_view.create_user_popup')

    @include('admin_view.client_details_popup')


<body>

<!-- =========================
     DASHBOARD CONTAINER
     ========================= -->

    <div class="container">
        <!-- Sidebar -->
         <!-- <aside> because it stays on the side and helps navigate the page -->
        <aside class="sidebar">

        <!-- Application logo -->
            <div class="logo">
                <i class="fas fa-chart-pie"></i>
            </div>

            <!-- Sidebar navigation -->
            <nav>
                <ul>
            <!-- =========================
                SIDEBAR NAVIGATION MENU
                Primary navigation for admin dashboard
                ========================= -->
            <nav>
                <ul>

                    <!-- Dashboard: default landing page -->
                    <!-- Marked as active to highlight current route -->
                    <li class="active" title="Dashboard">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <!-- Analytics: reports, metrics, and insights -->
                    <li title="Analytics">
                        <a href="#" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Analytics</span>
                        </a>
                    </li>

                    <!-- Users: manage users, roles, and permissions -->
                    <li title="Users">
                        <a href="#" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Users</span>
                        </a>
                    </li>

                    <!-- Products: product listing, creation, and updates -->
                    <li title="Products">
                        <a href="#" class="nav-link">
                            <i class="fas fa-box"></i>
                            <span>Products</span>
                        </a>
                    </li>

                    <!-- Orders: order tracking and fulfillment -->
                    <li title="Orders">
                        <a href="#" class="nav-link">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Orders</span>
                        </a>
                    </li>

                    <!-- Settings: application and account configuration -->
                    <li title="Settings">
                        <a href="#" class="nav-link">
                            <i class="fas fa-cog"></i>
                            <span>Settings</span>
                        </a>
                    </li>

                </ul>
            </nav>

                </ul>
            </nav> <!-- closed sidebar-navigation -->

            <!-- Logout button -->
            <div class="logout" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
            </div>
        </aside>

         <!-- =========================
         MAIN CONTENT AREA
         ========================= -->
        <main class="main-content">

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
                <div class="stat-card stat-card-blue">
                    <div class="stat-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="stat-details">
                        <h3>5</h3>
                        <p>Total Clients</p>
                    </div>
                </div>

                <!-- Active clients -->
                <div class="stat-card stat-card-green">
                    <div class="stat-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="stat-details">
                        <h3>4</h3>
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
                            @endphp


                             <!-- Avatar with initials -->
                            <div class="client-card" 
                                 data-client-id="{{ $org->id }}"
                                 data-email="{{ $org->email ?? '' }}"
                                 data-phone="{{ $org->phone ?? '' }}"
                                 data-package="{{ $org->package ?? 'basic' }}">
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
        </main> <!-- main-content close -->
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

            // View All link functionality
            const viewAllLink = document.querySelector('.view-all');
            if (viewAllLink) {
                viewAllLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    const sidebar = document.querySelector('.sidebar');
                    const usersNavItem = document.querySelector('li[title="Users"]');
                    
                    // Expand the sidebar if it's not already expanded
                    if (!sidebar.classList.contains('expanded')) {
                        sidebar.classList.add('expanded');
                        // Wait for the sidebar to expand before scrolling
                        setTimeout(() => {
                            if (usersNavItem) {
                                usersNavItem.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                // Add active class to highlight the Users nav item
                                document.querySelectorAll('.sidebar nav li').forEach(item => {
                                    item.classList.remove('active');
                                });
                                usersNavItem.classList.add('active');
                            }
                        }, 300); // Match this with the CSS transition time
                    } else if (usersNavItem) {
                        usersNavItem.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        // Add active class to highlight the Users nav item
                        document.querySelectorAll('.sidebar nav li').forEach(item => {
                            item.classList.remove('active');
                        });
                        usersNavItem.classList.add('active');
                    }
                });
            }

            // Handle Users nav item click to show Clients Overview in full view
            const usersNavLink = document.querySelector('li[title="Users"] a.nav-link');
            if (usersNavLink) {
                usersNavLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    
                    const mainContent = document.querySelector('.main-content');
                    const mainContent2 = document.querySelector('.main-content-2');
                    
                    if (mainContent && mainContent2) {
                        // Toggle full view class on main content
                        mainContent.classList.toggle('full-view');
                        
                        // Toggle active class on main-content-2
                        mainContent2.classList.toggle('active');
                        
                        // Update active state in navigation
                        document.querySelectorAll('.sidebar nav li').forEach(item => {
                            item.classList.remove('active');
                        });
                        this.parentElement.classList.add('active');
                        
                        // Update the page title
                        const headerTitle = document.querySelector('.header-title');
                        if (headerTitle) {
                            headerTitle.textContent = mainContent.classList.contains('full-view') 
                                ? 'Clients Overview' 
                                : 'Dashboard';
                        }
                        
                        // Scroll to top
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                });
            }
        });
    </script>

</body>
</html>
