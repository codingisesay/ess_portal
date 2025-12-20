<!-- added the admin layout file to call the sidebar -->
@extends('admin_view.admin_layout')

@section('content')
<div class="client-details-container">
    <!-- Header Section -->
    <div class="client-header">
        <h2>All Clients</h2>
        <div class="header-actions">
            <div class="search-container">
                <input type="text" placeholder="Search clients..." class="search-input">
                <i class="fas fa-search search-icon"></i>
            </div>
            <button class="filter-btn">
                <i class="fas fa-filter"></i>
                <span>Filter</span>
            </button>
            <button class="add-client-btn">
                <i class="fas fa-plus"></i>
                <span>Add Client</span>
            </button>
        </div>
    </div>
<!-- Created a hardcoded concept for now because the which fields we have to display that we have to discuss -->
    <!-- Client Cards Grid -->
    <div class="client-cards-grid">
        <!-- Client Card 1 -->
        <div class="client-card">
            <div class="card-header">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div class="client-avatar" style="background: #e9d5ff; color: #7c3aed;">AC</div>
                    <div class="client-info">
                        <h3 class="client-name">Acme Corp</h3>
                        <p class="client-type">Enterprise</p>
                    </div>
                </div>
                <i class="fas fa-ellipsis-v view-icon"></i>
            </div>
            <div class="contact-person">
                <i class="fas fa-user"></i>
                <span>Sarah Johnson</span>
            </div>
            <div class="metrics-container">
                <div class="metric-container">
                    <div class="metric-header">
                        <span>Users</span>
                        <span>24/50</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-users-1"></div>
                    </div>
                </div>
                <div class="metric-container">
                    <div class="metric-header">
                        <span>Storage</span>
                        <span>45.8/100 GB</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-storage-1"></div>
                    </div>
                </div>
            </div>
            <div class="status-badge status-active" style="position: absolute; top: 20px; right: 20px;">Active</div>
        </div>

        <!-- Client Card 2 -->
        <div class="client-card">
            <div class="card-header">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div class="client-avatar" style="background: #fef3c7; color: #d97706;">TS</div>
                    <div class="client-info">
                        <h3 class="client-name">Tech Solutions</h3>
                        <p class="client-type">Startup</p>
                    </div>
                </div>
                <i class="fas fa-ellipsis-v view-icon"></i>
            </div>
            <div class="contact-person">
                <i class="fas fa-user"></i>
                <span>Michael Chen</span>
            </div>
            <div class="metrics-container">
                <div class="metric-container">
                    <div class="metric-header">
                        <span>Users</span>
                        <span>8/10</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-users-2"></div>
                    </div>
                </div>
                <div class="metric-container">
                    <div class="metric-header">
                        <span>Storage</span>
                        <span>18.2/50 GB</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-storage-2"></div>
                    </div>
                </div>
            </div>
            <div class="status-badge status-expiring" style="position: absolute; top: 20px; right: 20px;">Expiring</div>
        </div>

        <!-- Client Card 3 -->
        <div class="client-card">
            <div class="card-header">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div class="client-avatar" style="background: #dbeafe; color: #1d4ed8;">GD</div>
                    <div class="client-info">
                        <h3 class="client-name">Global Dynamics</h3>
                        <p class="client-type">Enterprise</p>
                    </div>
                </div>
                <i class="fas fa-ellipsis-v view-icon"></i>
            </div>
            <div class="contact-person">
                <i class="fas fa-user"></i>
                <span>Robert Johnson</span>
            </div>
            <div class="metrics-container">
                <div class="metric-container">
                    <div class="metric-header">
                        <span>Users</span>
                        <span>42/100</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-users-3"></div>
                    </div>
                </div>
                <div class="metric-container">
                    <div class="metric-header">
                        <span>Storage</span>
                        <span>78.5/200 GB</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-storage-3"></div>
                    </div>
                </div>
            </div>
            <div class="status-badge status-active" style="position: absolute; top: 20px; right: 20px;">Active</div>
        </div>

        <!-- Client Card 4 -->
        <div class="client-card">
            <div class="card-header">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div class="client-avatar" style="background: #f3e8ff; color: #7e22ce;">AI</div>
                    <div class="client-info">
                        <h3 class="client-name">Alpha Inc</h3>
                        <p class="client-type">Business</p>
                    </div>
                </div>
                <i class="fas fa-ellipsis-v view-icon"></i>
            </div>
            <div class="contact-person">
                <i class="fas fa-user"></i>
                <span>Jennifer Lee</span>
            </div>
            <div class="metrics-container">
                <div class="metric-container">
                    <div class="metric-header">
                        <span>Users</span>
                        <span>15/25</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-users-4"></div>
                    </div>
                </div>
                <div class="metric-container">
                    <div class="metric-header">
                        <span>Storage</span>
                        <span>32.1/50 GB</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-storage-4"></div>
                    </div>
                </div>
            </div>
            <div class="status-badge status-active" style="position: absolute; top: 20px; right: 20px;">Active</div>
        </div>

        <!-- Client Card 5 -->
        <div class="client-card">
            <div class="card-header">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div class="client-avatar" style="background: #dcfce7; color: #15803d;">NW</div>
                    <div class="client-info">
                        <h3 class="client-name">Next Wave</h3>
                        <p class="client-type">Startup</p>
                    </div>
                </div>
                <i class="fas fa-ellipsis-v view-icon"></i>
            </div>
            <div class="contact-person">
                <i class="fas fa-user"></i>
                <span>David Kim</span>
            </div>
            <div class="metrics-container">
                <div class="metric-container">
                    <div class="metric-header">
                        <span>Users</span>
                        <span>5/10</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-users-5"></div>
                    </div>
                </div>
                <div class="metric-container">
                    <div class="metric-header">
                        <span>Storage</span>
                        <span>8.7/20 GB</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-storage-5"></div>
                    </div>
                </div>
            </div>
            <div class="status-badge status-active" style="position: absolute; top: 20px; right: 20px;">Active</div>
        </div>
    </div>
</div>
@endsection
