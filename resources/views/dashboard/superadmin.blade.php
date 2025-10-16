@extends('superadmin_view/superadmin_layout')
@section('content')
<link rel="stylesheet" href="{{ asset('errors/error.css') }}">
<link rel="stylesheet" href="{{ asset('admin_end/css/admin_dashboard.css') }}" />

<div class="container">
    <div class="topbar">
        <div class="brand">
            <div class="logoo">PV</div>
            <div>
                <h1 class="h-title">Dashboard </h1>
            </div>
        </div>

        <!-- Logout -->
        <a href="{{ route('superadmin.logout') }}" class="logout-btn" title="Logout">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden>
                <path d="M16 17l5-5-5-5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M21 12H9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M13 5H6a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Logout
        </a>
    </div>

    <!-- Branch Users -->
    <section class="card" aria-labelledby="branch-users" style="margin-bottom:18px">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
            <div>
                <h2 id="branch-users" style="margin:0;font-size:16px;display:flex;gap:10px;align-items:center;">
                    <span class="badge">U</span>
                    Branch Users
                </h2>
                <div class="small">User distribution across branches</div>
            </div>
            <div class="small" style="text-align:right"></div>
        </div>

        <!-- KPI Strip -->
        <div class="kpi-grid">
            <div class="kpi"><div class="num">{{ $branches->sum('totalEmployees') }}</div><div class="label">Total Employees</div></div>
            <div class="kpi"><div class="num">{{ $branches->sum('activeCount') }}</div><div class="label">Total Active</div></div>
            <div class="kpi"><div class="num" style="color:#8A3366">{{ $branches->sum('inactiveCount') }}</div><div class="label">Total Inactive</div></div>
            <div class="kpi"><div class="num">{{ $branches->count() }}</div><div class="label">Branches</div></div>
        </div>

        <!-- Branch list -->
        <div class="carousel-wrap">
            <div class="branch-scroller" id="branch-scroller">
                @foreach($branches as $branch)
                    <div class="branch-tile">
                        <div class="tile-head">
                            <h3>{{ $branch->name }}</h3>
                            <p>{{ $branch->totalEmployees }} Total Employees</p>
                        </div>
                        <div class="tile-body">
                            <div class="donut-wrap">
                                <!-- Active % -->
                                <div style="font-size:22px;font-weight:bold;color:#071127">
                                    {{ $branch->totalEmployees > 0 ? round(($branch->activeCount / $branch->totalEmployees) * 100) : 0 }}%
                                </div>
                            </div>
                            <div class="tile-stats">
                                <div class="stat-box"><div class="value">{{ $branch->activeCount }}</div><div class="desc">Active</div></div>
                                <div class="stat-box"><div class="value" style="color:#b2eced">{{ $branch->inactiveCount }}</div><div class="desc">Inactive</div></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Departments & Policies -->
    <div class="row">
        <!-- Departments -->
            <section class="card">
        <div class="section-title">
            <div class="badge">D</div>
            <div>
                <div style="font-weight:700">Departments</div>
                <div class="small">Searchable categories (tap to expand)</div>
            </div>
        </div>
        <div class="shared-search">
            <input id="dept-search" placeholder="Search departments..." onkeyup="filterList('dept-search','departments-list')"/>
        </div>
        <div id="departments-list" class="shared-list">
            @foreach($departments as $dept)
                <div class="shared-card">
                    <div class="shared-header" onclick="toggleBody(this)">
                        <div><strong>{{ $dept['name'] }}</strong></div>
                        <div class="small">+</div>
                    </div>
                    <div class="shared-body" style="display:none">
                        @foreach($dept['items'] as $role)
                            <div class="designation-card">
                                {{ $role['designation'] }}
                                <span style="color:green; font-size:0.9em">
                                    (Active: {{ $role['active'] }})
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        </section>


        <!-- Policies -->
        <section class="card">
            <div class="section-title">
                <div class="badge">P</div>
                <div>
                    <div style="font-weight:700">Company Policies</div>
                    <div class="small">Categories & guidelines</div>
                </div>
            </div>
            <div class="shared-search">
                <input id="policy-search" placeholder="Search policies..." onkeyup="filterList('policy-search','policies-list')"/>
            </div>
            <div id="policies-list" class="shared-list">
                @foreach($policies as $policy)
                    <div class="shared-card">
                        <div class="shared-header" onclick="toggleBody(this)">
                            <div>
                                <strong>{{ $policy['category'] }}</strong>
                                <div style="font-size:13px;opacity:.9">{{ $policy['description'] }}</div>
                            </div>
                            <div class="small">+</div>
                        </div>
                        <div class="shared-body" style="display:none">
                            @foreach($policy['items'] as $p)
                                <div class="designation-card">{{ $p }}</div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
</div>

<script>
function toggleBody(el){
    const body = el.nextElementSibling;
    const toggle = el.querySelector('.small');
    if(body.style.display === 'none'){
        body.style.display = 'block';
        toggle.textContent = '-';
    } else {
        body.style.display = 'none';
        toggle.textContent = '+';
    }
}
function filterList(inputId, listId){
    const filter = document.getElementById(inputId).value.toLowerCase();
    const cards = document.getElementById(listId).getElementsByClassName('shared-card');
    Array.from(cards).forEach(card => {
        const text = card.textContent.toLowerCase();
        card.style.display = text.includes(filter) ? '' : 'none';
    });
}
</script>
@endsection
