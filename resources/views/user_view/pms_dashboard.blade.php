@extends('user_view.header')

@section('content')
<link rel="stylesheet" href="{{ asset('/user_end/css/pms-dashboard.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap 5 JS (bundle includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<div class="container mt-4">
    @php
        $user = Auth::user();

        // Get "None" user id (assuming username or name column is 'none')
        $noneUserId = \DB::table('users')
            ->whereRaw('LOWER(name) = ?', ['none'])
            ->value('id');

        // Get reporting_manager value for the logged-in user
        $reportingManager = \DB::table('emp_details')
            ->where('user_id', $user->id)
            ->value('reporting_manager');

        // Check if the user has subordinates reporting to them
        $hasSubordinates = \DB::table('emp_details')
            ->where('reporting_manager', $user->id)
            ->exists();

        // Determine which dashboards to show
        $showOrganization = ($reportingManager === null || $reportingManager == $noneUserId);
        $showManager = $hasSubordinates; // Manager
          $showEmployee = (!$showOrganization && !$showManager); // 👈 employee case
    @endphp

    @if($showOrganization || $showManager)
        {{-- Role Switcher (only if both dashboards are available) --}}
        @if($showOrganization && $showManager)
            <div class="mb-3">
                <label for="roleSwitcher"><strong>Switch Dashboard:</strong></label>
                <select id="roleSwitcher" class="form-control w-50">
                    @if($showOrganization)
                        <option value="organization" selected>Organization Dashboard</option>
                    @endif
                    @if($showManager)
                        <option value="manager">Manager Dashboard</option>
                    @endif
                </select>
            </div>
        @endif

        {{-- Organization Dashboard --}}
        @if($showOrganization)
            <div id="organizationDash" class="mt-3" style="{{ $showManager ? '' : '' }}">
                @include('user_view.organization')
            </div>
        @endif

        {{-- Manager Dashboard --}}
        @if($showManager)
            <div id="managerDash" class="mt-3" style="{{ $showOrganization ? 'display:none;' : '' }}">
                @include('user_view.manager_dashboard')
            </div>
        @endif

        {{-- JS for Role Switcher --}}
        @if($showOrganization && $showManager)
            <script>
                document.getElementById('roleSwitcher').addEventListener('change', function() {
                    document.getElementById('organizationDash').style.display = this.value === 'organization' ? '' : 'none';
                    document.getElementById('managerDash').style.display = this.value === 'manager' ? '' : 'none';
                });
            </script>
        @endif


@elseif($showEmployee)
    {{-- Employee Dashboard --}}
    <div id="employeeDash" class="mt-3">
        @include('user_view.employee_dashboardpms')
    </div>
@else
    <div class="alert alert-warning mt-4">
        You do not have access to any dashboard.
    </div>
@endif
</div>
@endsection
