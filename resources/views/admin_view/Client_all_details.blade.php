@extends('admin_view.admin_layout')

@section('content')
<link rel="stylesheet" href="{{ asset('Offical_admin/css/client-details.css') }}">
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

    <!-- Client Cards Grid -->
    <div class="client-cards-grid">
        @foreach($organisations as $org)
        <div class="client-card">
            <div class="card-header">
                <div class="client-avatar">
                    {{ strtoupper(substr($org->name, 0, 2)) }}
                </div>
                <div class="client-info">
                    <h3 class="client-name">{{ $org->name }}</h3>
                    <p class="client-type">{{ $org->type ?? 'Business' }}</p>
                </div>
                <i class="fas fa-eye view-icon"></i>
            </div>

            <div class="contact-person">
                <i class="fas fa-user"></i>
                <span>{{ $org->contact_person ?? 'Not Assigned' }}</span>
            </div>

            <div class="client-info">
                    <h3 class="client-name">{{ $org->email }}</h3>
                    <p class="client-type">{{ $org->type ?? 'Business' }}</p>
                </div>

            <div class="status-badge {{ $org->status === 'active' ? 'status-active' : 'status-expiring' }}">
                {{ ucfirst($org->status ?? 'Active') }}
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
