 
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
                    <!-- Active state based on current route -->
                    <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" title="Dashboard">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <!-- Analytics: reports, metrics, and insights -->
                    <li title="Analytics">
                        <a href="#" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Subscriptions</span>
                        </a>
                    </li>

                    <!-- Users: manage users, roles, and permissions -->
                     <!-- addded navigation for the client_all_details page -->
                    <li title="Users">
                        <a href="{{ route('admin.client_all_details') }}" class="nav-link {{ request()->routeIs('admin.client_all_details') ? 'active' : '' }}">
                            <i class="fas fa-users"></i>
                            <span>Clients</span>
                        </a>
                    </li>
                     <li></li>


                </ul>
            </nav>

                </ul>
            </nav> <!-- closed sidebar-navigation -->

            <!-- Logout button -->
            <div class="logout" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
            </div>
        </aside>

        <!-- logout form (POST) -->
        <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none;">
            @csrf
        </form>

        <script>
            const viewAllLink = document.querySelector('.view-all');
            // Handle admin logout click -> submit hidden POST form
            const logoutBtn = document.querySelector('.logout');
            if (logoutBtn) {
                logoutBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = document.getElementById('admin-logout-form');
                    if (form) form.submit();
                });
            }
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
        </script>

        <!-- Main Content -->
        <main class="main-content">
            @yield('content')
        </main>
    </body>
</html>