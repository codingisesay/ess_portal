
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

    <!-- Include Add Client Module -->
    @include('admin_view.Add_client_module')
    
    <!-- Include Notification Module -->
    @include('admin_view.notification_module')
    
    <!-- Include Subscription Plan Module -->
    @include('admin_view.subscription_plan_module')
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
                    <li class="active" title="Dashboard"><i class="fas fa-home"></i></li>
                    <li title="Analytics"><i class="fas fa-chart-line"></i></li>
                    <li title="Users"><i class="fas fa-users"></i></li>
                    <li title="Products"><i class="fas fa-box"></i></li>
                    <li title="Orders"><i class="fas fa-shopping-cart"></i></li>
                    <li title="Settings"><i class="fas fa-cog"></i></li>
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
                        <!-- Client Card 1 -->
                        <div class="client-card">
                            <div class="client-avatar client-avatar-blue">AC</div>
                            <div class="client-info">
                                <h3>Acme Corp</h3>
                                <p>John Smith • Enterprise</p>
                                <div class="storage-bar">
                                    <div class="storage-fill" style="width: 85%;"></div>
                                </div>
                                <div class="storage-info">
                                    <span>85% Storage Used</span>
                                </div>
                            </div>
                            <div class="client-status active">Active</div>
                        </div>

                        <!-- Client Card 2 -->
                        <div class="client-card">
                            <div class="client-avatar" style="background-color: #e8f5e9; color: #388e3c;">TI</div>
                            <div class="client-info">
                                <h3>TechStart</h3>
                                <p>Sarah Johnson • Startup</p>
                                <div class="storage-bar">
                                    <div class="storage-fill" style="width: 45%;"></div>
                                </div>
                                <div class="storage-info">
                                    <span>45% Storage Used</span>
                                </div>
                            </div>
                            <div class="client-status active">Active</div>
                        </div>

                        <!-- Client Card 3 -->
                        <div class="client-card">
                            <div class="client-avatar" style="background-color: #fff3e0; color: #f57c00;">GR</div>
                            <div class="client-info">
                                <h3>Global Retail</h3>
                                <p>Michael Brown • Business</p>
                                <div class="storage-bar">
                                    <div class="storage-fill" style="width: 72%;"></div>
                                </div>
                                <div class="storage-info">
                                    <span>72% Storage Used</span>
                                </div>
                            </div>
                            <div class="client-status active">Active</div>
                        </div>

                        <!-- Client Card 4 -->
                        <div class="client-card">
                            <div class="client-avatar" style="background-color: #e0f7fa; color: #00acc1;">DS</div>
                            <div class="client-info">
                                <h3>DataSystems</h3>
                                <p>Emily Davis • Enterprise</p>
                                <div class="storage-bar">
                                    <div class="storage-fill" style="width: 38%;"></div>
                                </div>
                                <div class="storage-info">
                                    <span>38% Storage Used</span>
                                </div>
                            </div>
                            <div class="client-status active">Active</div>
                        </div>

                        <!-- Client Card 5 -->
                        <div class="client-card">
                            <div class="client-avatar" style="background-color: #f3e5f5; color: #8e24aa;">MS</div>
                            <div class="client-info">
                                <h3>MediaSoft</h3>
                                <p>David Wilson • Professional</p>
                                <div class="storage-bar">
                                    <div class="storage-fill" style="width: 62%;"></div>
                                </div>
                                <div class="storage-info">
                                    <span>62% Storage Used</span>
                                </div>
                            </div>
                            <div class="client-status expiring">Expiring</div>
                        </div>
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
        // Close success modal
        document.getElementById('closeSuccess').addEventListener('click', function() {
            const successModal = document.getElementById('successModal');
            successModal.style.display = 'none';
            successModal.classList.remove('show');
        });

        document.getElementById('successOkBtn').addEventListener('click', function() {
            const successModal = document.getElementById('successModal');
            successModal.style.display = 'none';
            successModal.classList.remove('show');
        });

        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            const successModal = document.getElementById('successModal');
            if (event.target === successModal) {
                successModal.style.display = 'none';
                successModal.classList.remove('show');
            }
        });
    </script>
    });
</script>
</body>
</html>

