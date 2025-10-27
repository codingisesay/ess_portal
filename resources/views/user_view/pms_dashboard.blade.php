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
                <div class="dashboard-switch">
                    <label class="switcher-label"><strong>Switch Dashboard:</strong></label>
                    <div class="ds-pill">
                        <button id="switchOrg" class="ds-option active" type="button" aria-pressed="true">
                            <span class="ds-icon ds-icon-org" aria-hidden="true">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 21V5a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v6h3a2 2 0 0 1 2 2v8h-4v-5h-2v5H7v-5H5v5H3Zm6-7H7v2h2v-2Zm0-4H7v2h2V10Zm4 4h-2v2h2v-2Zm0-4h-2v2h2V10Zm0-4H7v2h6V6Z"/>
                                </svg>
                            </span>
                            <span>Organization</span>
                        </button>
                        <button id="switchMgr" class="ds-option" type="button" aria-pressed="false">
                            <span class="ds-icon ds-icon-mgr" aria-hidden="true">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Zm0 2c-4.42 0-8 2.24-8 5v1h16v-1c0-2.76-3.58-5-8-5Z"/>
                                </svg>
                            </span>
                            <span>Manager</span>
                        </button>
                    </div>
                </div>
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
            <div id="managerDash" class="mt-1" style="{{ $showOrganization ? 'display:none;' : '' }}">
                @include('user_view.manager_dashboard')
            </div>
        @endif

        {{-- JS for Role Switcher --}}
        @if($showOrganization && $showManager)
            <script>
                (function(){
                    const orgBtn = document.getElementById('switchOrg');
                    const mgrBtn = document.getElementById('switchMgr');
                    const org = document.getElementById('organizationDash');
                    const mgr = document.getElementById('managerDash');

                    function activate(target){
                        if(target === 'org'){
                            org.style.display = '';
                            mgr.style.display = 'none';
                            orgBtn.classList.add('active');
                            orgBtn.setAttribute('aria-pressed','true');
                            mgrBtn.classList.remove('active');
                            mgrBtn.setAttribute('aria-pressed','false');
                        } else {
                            org.style.display = 'none';
                            mgr.style.display = '';
                            mgrBtn.classList.add('active');
                            mgrBtn.setAttribute('aria-pressed','true');
                            orgBtn.classList.remove('active');
                            orgBtn.setAttribute('aria-pressed','false');
                        }
                    }

                    orgBtn?.addEventListener('click', () => activate('org'));
                    mgrBtn?.addEventListener('click', () => activate('mgr'));

                    // Initialize default (Organization visible by default in blade)
                    activate(org && org.style.display !== 'none' ? 'org' : 'mgr');
                })();
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
