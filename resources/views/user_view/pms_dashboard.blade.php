@extends('user_view.header')

@section('content')
<div class="container mt-4">
    @php
        $user = Auth::user();
    @endphp

    @if($user && $user->id == 1)
        {{-- Role Switcher --}}
        <div class="mb-3">
            <label for="roleSwitcher"><strong>Switch Dashboard:</strong></label>
            <select id="roleSwitcher" class="form-control w-50">
                <option value="organization" selected>Organization Dashboard</option>
                <option value="manager">Manager Dashboard</option>
            </select>
        </div>

        {{-- Dashboards --}}
        <div id="organizationDash" class="mt-3">
            @include('user_view.organization')
        </div>

        <div id="managerDash" class="mt-3" style="display:none;">
            @include('user_view.manager_dashboard')
        </div>

        <script>
            document.getElementById('roleSwitcher').addEventListener('change', function() {
                document.getElementById('organizationDash').style.display = this.value === 'organization' ? '' : 'none';
                document.getElementById('managerDash').style.display = this.value === 'manager' ? '' : 'none';
            });
        </script>

    @else
        <div class="alert alert-warning mt-4">
            You do not have access to the Organization Dashboard.
        </div>
    @endif
</div>
@endsection
