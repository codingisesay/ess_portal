@extends('user_view.header')

@section('content')
<div class="container mt-4">
    @php
        $user = Auth::user();

        // Get reporting_manager value for the logged-in user
        $reportingManager = \DB::table('emp_details')
            ->where('user_id', $user->id)
            ->value('reporting_manager');

        // Check if the user has subordinates reporting to them
        $hasSubordinates = \DB::table('emp_details')
            ->where('reporting_manager', $user->id)
            ->exists();

        // Determine which dashboards to show
        $showOrganization = $reportingManager === null; // Top-level user
        $showManager = $hasSubordinates;               // Manager
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

    @else
        <div class="alert alert-warning mt-4">
            You do not have access to any dashboard.
        </div>
    @endif
</div>
@endsection
